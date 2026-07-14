<?php

namespace App\Http\Controllers\Survei;

use App\Http\Controllers\Controller;
use App\Models\JenisSurvei;
use App\Models\JawabanSurvei;
use App\Models\PertanyaanSurvei;
use App\Models\Survei;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class SurveiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['super_admin', 'admin_spmi'])) {
            $surveis = Survei::with(['jenisSurvei', 'tahunAkademik', 'dibuatOleh'])->latest()->get();
        } else {
            $surveis = Survei::with(['jenisSurvei', 'tahunAkademik'])
                ->where('status', 'Aktif')
                ->where('tanggal_mulai', '<=', now())
                ->where('tanggal_selesai', '>=', now())
                ->latest()
                ->get();
        }

        return view('survei.index', compact('surveis'));
    }

    public function create()
    {
        $jenisSurveis = JenisSurvei::orderBy('nama')->get();
        $tahunAkademiks = TahunAkademik::orderByDesc('is_active')->orderByDesc('nama')->get();

        return view('survei.create', compact('jenisSurveis', 'tahunAkademiks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_survei_id' => 'required|exists:jenis_survei,id',
            'judul' => 'required|string|max:255',
            'tahun_akademik_id' => 'required|exists:tahun_akademik,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'pertanyaan' => 'required|array|min:1',
            'pertanyaan.*.teks_pertanyaan' => 'required|string|max:500',
            'pertanyaan.*.tipe_jawaban' => 'required|in:skala_likert,pilihan_ganda,esai',
        ]);

        $survei = Survei::create([
            'jenis_survei_id' => $validated['jenis_survei_id'],
            'judul' => $validated['judul'],
            'tahun_akademik_id' => $validated['tahun_akademik_id'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'status' => 'Aktif',
            'dibuat_oleh' => auth()->id(),
        ]);

        foreach ($validated['pertanyaan'] as $index => $pertanyaan) {
            PertanyaanSurvei::create([
                'survei_id' => $survei->id,
                'teks_pertanyaan' => $pertanyaan['teks_pertanyaan'],
                'tipe_jawaban' => $pertanyaan['tipe_jawaban'],
                'urutan' => $index + 1,
            ]);
        }

        return redirect()->route('survei.index')
            ->with('success', 'Survei berhasil dibuat.');
    }

    public function fillForm(Survei $survei)
    {
        $survei->load(['jenisSurvei', 'tahunAkademik', 'pertanyaanSurvei' => function ($q) {
            $q->orderBy('urutan');
        }]);

        return view('survei.fill', compact('survei'));
    }

    public function submitFill(Request $request, Survei $survei)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.pertanyaan_survei_id' => 'required|exists:pertanyaan_survei,id',
            'answers.*.jawaban_teks' => 'nullable|string|max:1000',
            'answers.*.jawaban_rating' => 'nullable|integer|min:1|max:5',
        ]);

        foreach ($validated['answers'] as $answer) {
            $data = [
                'survei_id' => $survei->id,
                'pertanyaan_survei_id' => $answer['pertanyaan_survei_id'],
                'responden_id' => auth()->check() ? auth()->id() : null,
            ];

            if (!empty($answer['jawaban_teks'])) {
                $data['teks_jawaban'] = $answer['jawaban_teks'];
            }

            if (!empty($answer['jawaban_rating'])) {
                $data['nilai_jawaban'] = $answer['jawaban_rating'];
            }

            JawabanSurvei::create($data);
        }

        return redirect()->route('survei.index')
            ->with('success', 'Jawaban survei berhasil dikirim. Terima kasih!');
    }

    public function hasil(Survei $survei)
    {
        $survei->load(['jenisSurvei', 'pertanyaanSurvei', 'jawabanSurvei']);

        $stats = [
            'total_responden' => $survei->jawabanSurvei->unique('responden_id')->count(),
            'total_jawaban' => $survei->jawabanSurvei->count(),
        ];

        $pertanyaanStats = $survei->pertanyaanSurvei->map(function ($pertanyaan) use ($survei) {
            $jawaban = $survei->jawabanSurvei->where('pertanyaan_survei_id', $pertanyaan->id);

            $rataRata = $jawaban->avg('nilai_jawaban');

            return [
                'pertanyaan' => $pertanyaan,
                'total_jawaban' => $jawaban->count(),
                'rata_rata_rating' => $rataRata ? round($rataRata, 2) : null,
                'jawaban_teks' => $jawaban->pluck('teks_jawaban')->filter(),
            ];
        });

        return view('survei.hasil', compact('survei', 'stats', 'pertanyaanStats'));
    }

    public function dashboard()
    {
        $surveis = Survei::with(['jenisSurvei', 'jawabanSurvei'])
            ->latest()
            ->get();

        $stats = [
            'total_survei' => $surveis->count(),
            'survei_aktif' => $surveis->where('status', 'Aktif')->count(),
            'total_responden' => $surveis->sum(fn($s) => $s->jawabanSurvei->unique('responden_id')->count()),
        ];

        return view('survei.dashboard', compact('surveis', 'stats'));
    }
}
