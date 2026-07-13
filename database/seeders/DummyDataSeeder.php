<?php

namespace Database\Seeders;

use App\Models\ChecklistAuditItem;
use App\Models\ChecklistAuditTemplate;
use App\Models\DokumenMutu;
use App\Models\DokumenMutuVersion;
use App\Models\HasilAudit;
use App\Models\HasilAuditDetail;
use App\Models\JadwalAudit;
use App\Models\KategoriDokumen;
use App\Models\PeriodeAudit;
use App\Models\PertanyaanSurvei;
use App\Models\PpeppSiklus;
use App\Models\ProgramStudi;
use App\Models\StandarMutu;
use App\Models\Survei;
use App\Models\TemuanAudit;
use App\Models\TahunAkademik;
use App\Models\TindakLanjutTemuan;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $adminSpmi = User::where('email', 'admin.spmi@polije.ac.id')->first();
        $gpmRatna = User::where('email', 'gpm.ratna@polije.ac.id')->first();
        $gpmNovi = User::where('email', 'gpm.novi@polije.ac.id')->first();
        $auditor1 = User::where('email', 'auditor1@polije.ac.id')->first();
        $auditor2 = User::where('email', 'auditor2@polije.ac.id')->first();
        $auditorKetua = User::where('email', 'auditor.ketua@polije.ac.id')->first();
        $kaprodiTI = User::where('email', 'kaprodi.ti@polije.ac.id')->first();
        $kaprodiMI = User::where('email', 'kaprodi.mi@polije.ac.id')->first();
        $kajurJTI = User::where('email', 'kajur.jti@polije.ac.id')->first();

        $taActive = TahunAkademik::where('is_active', true)->first();
        $taPrev = TahunAkademik::where('nama', '2024/2025')->where('semester', 'Genap')->first();

        $prodiTI = ProgramStudi::where('kode_prodi', 'TI')->first();
        $prodiMI = ProgramStudi::where('kode_prodi', 'MI')->first();
        $prodiMAG = ProgramStudi::where('kode_prodi', 'MAG')->first();
        $prodiASP = ProgramStudi::where('kode_prodi', 'ASP')->first();

        $pusjanmut = UnitKerja::where('nama_unit', 'LIKE', '%Pusjianmut%')->first();
        $biroAka = UnitKerja::where('nama_unit', 'Biro Administrasi Akademik')->first();

        $stdDik001 = StandarMutu::where('kode_standar', 'STD-DIK-001')->first();
        $stdDik002 = StandarMutu::where('kode_standar', 'STD-DIK-002')->first();
        $stdDik004 = StandarMutu::where('kode_standar', 'STD-DIK-004')->first();
        $stdDik005 = StandarMutu::where('kode_standar', 'STD-DIK-005')->first();
        $stdDik008 = StandarMutu::where('kode_standar', 'STD-DIK-008')->first();

        $katKebijakan = \App\Models\KategoriDokumen::where('prefix_nomor', 'POL')->first();
        $katSOP = \App\Models\KategoriDokumen::where('prefix_nomor', 'SOP')->first();
        $katMM = \App\Models\KategoriDokumen::where('prefix_nomor', 'MM')->first();

        // ── Checklist Audit Template ──
        $template = ChecklistAuditTemplate::create([
            'nama_template' => 'Template Audit Internal Pendidikan',
            'standar_mutu_id' => $stdDik001->id,
        ]);

        $items = [
            'Dokumen kurikulum telah diupdate sesuai kebutuhan industri',
            'Kriteria penilaian mahasiswa sudah jelas dan terukur',
            'Rencana pembelajaran semester (RPS) tersedia untuk semua mata kuliah',
            'Evaluasi dosen oleh mahasiswa dilakukan setiap semester',
            'Sarana dan prasarana laboratorium memadai',
            'Buku referensi dan jurnal terbaru tersedia di perpustakaan',
            'Sertifikasi dosen dilakukan secara berkala',
            'Laporan penelitian dosen dipublikasikan',
        ];

        $checklistItems = [];
        foreach ($items as $index => $itemText) {
            $checklistItems[] = ChecklistAuditItem::create([
                'checklist_audit_template_id' => $template->id,
                'teks_item' => $itemText,
                'skor_maksimal' => 10,
                'urutan' => $index + 1,
            ]);
        }

        // ── Dokumen Mutu (various statuses) ──
        $dokumenData = [
            [
                'kategori_id' => $katKebijakan->id,
                'nomor' => 'POL-2025-001',
                'judul' => 'Kebijakan Penjaminan Mutu Polije',
                'status' => 'Published',
                'unit_id' => $pusjanmut->id,
            ],
            [
                'kategori_id' => $katSOP->id,
                'nomor' => 'SOP-2025-001',
                'judul' => 'SOP Audit Internal Penjaminan Mutu',
                'status' => 'Approved',
                'unit_id' => $pusjanmut->id,
            ],
            [
                'kategori_id' => $katMM->id,
                'nomor' => 'MM-2025-001',
                'judul' => 'Manual Mutu Penyelenggaraan Pendidikan',
                'status' => 'Published',
                'unit_id' => $biroAka->id,
            ],
            [
                'kategori_id' => $katSOP->id,
                'nomor' => 'SOP-2025-002',
                'judul' => 'SOP Pengelolaan Tracer Study',
                'status' => 'Submitted',
                'prodi_id' => $prodiTI->id,
            ],
            [
                'kategori_id' => $katKebijakan->id,
                'nomor' => 'POL-2025-002',
                'judul' => 'Kebijakan Penelitian dan Pengabdian',
                'status' => 'Draft',
                'unit_id' => $pusjanmut->id,
            ],
        ];

        foreach ($dokumenData as $dok) {
            $dm = DokumenMutu::create([
                'kategori_dokumen_id' => $dok['kategori_id'],
                'nomor_dokumen' => $dok['nomor'],
                'judul' => $dok['judul'],
                'program_studi_id' => $dok['prodi_id'] ?? null,
                'unit_kerja_id' => $dok['unit_id'] ?? null,
                'standar_mutu_id' => $stdDik008->id,
                'status' => $dok['status'],
                'tanggal_berlaku' => '2025-08-01',
                'tanggal_kedaluwarsa' => '2026-07-31',
                'dibuat_oleh' => $adminSpmi->id,
            ]);

            DokumenMutuVersion::create([
                'dokumen_mutu_id' => $dm->id,
                'nomor_versi' => '1.0',
                'file_path' => "dokumen/{$dok['nomor']}/v1.0.pdf",
                'file_size' => rand(100000, 500000),
                'catatan_revisi' => 'Dokumen awal',
                'dibuat_oleh' => $adminSpmi->id,
            ]);
        }

        // ── PPEPP Siklus ──
        $tahapList = ['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'];
        $standarList = [$stdDik001, $stdDik002, $stdDik004, $stdDik005, $stdDik008];

        foreach ($standarList as $index => $std) {
            PpeppSiklus::create([
                'standar_mutu_id' => $std->id,
                'tahun_akademik_id' => $taActive->id,
                'tahap_sekarang' => $tahapList[$index % count($tahapList)],
                'status_siklus' => 'Berjalan',
            ]);
        }

        // ── Periode Audit & Jadwal Audit ──
        $periodeAktif = PeriodeAudit::where('status', 'Berjalan')->first();

        if ($periodeAktif) {
            $jadwal1 = JadwalAudit::create([
                'periode_audit_id' => $periodeAktif->id,
                'program_studi_id' => $prodiTI->id,
                'tanggal_audit' => '2025-11-15',
                'jenis_audit' => 'Reguler',
                'status' => 'Terjadwal',
                'dibuat_oleh' => $auditorKetua->id,
            ]);

            $jadwal2 = JadwalAudit::create([
                'periode_audit_id' => $periodeAktif->id,
                'unit_kerja_id' => $pusjanmut->id,
                'tanggal_audit' => '2025-11-20',
                'jenis_audit' => 'Reguler',
                'status' => 'Terjadwal',
                'dibuat_oleh' => $auditorKetua->id,
            ]);

            // ── Hasil Audit ──
            $hasilAudit = HasilAudit::create([
                'jadwal_audit_id' => $jadwal1->id,
                'checklist_audit_template_id' => $template->id,
                'total_skor' => 72.50,
                'kesimpulan' => 'Program Studi Teknik Informatika memenuhi sebagian besar standar yang ditetapkan. Beberapa temuan minor terkait ketersediaan buku referensi terbaru.',
                'status' => 'Approved',
                'ditandatangani_oleh' => [$auditorKetua->id, $auditor1->id],
            ]);

            foreach ($checklistItems as $item) {
                HasilAuditDetail::create([
                    'hasil_audit_id' => $hasilAudit->id,
                    'checklist_audit_item_id' => $item->id,
                    'skor_diberikan' => rand(60, 100) / 10,
                    'catatan_auditor' => 'Memenuhi kriteria dengan catatan minor',
                ]);
            }

            // ── Temuan Audit ──
            $temuan1 = TemuanAudit::create([
                'hasil_audit_id' => $hasilAudit->id,
                'kategori_temuan' => 'Minor',
                'tingkat_risiko' => 'Sedang',
                'deskripsi_temuan' => 'Ketersediaan buku referensi terbaru di perpustakaan masih kurang untuk program studi Teknik Informatika.',
                'rekomendasi' => 'Melakukan pengadaan buku referensi terbaru minimal 20 judul per tahun.',
                'standar_mutu_id' => $stdDik004->id,
            ]);

            $temuan2 = TemuanAudit::create([
                'hasil_audit_id' => $hasilAudit->id,
                'kategori_temuan' => 'Observasi',
                'tingkat_risiko' => 'Rendah',
                'deskripsi_temuan' => 'Beberapa RPS mata kuliah pilihan belum memuat capaian pembelajaran yang terukur.',
                'rekomendasi' => 'Melakukan revisi RPS untuk memasukkan capaian pembelajaran yang terukur.',
                'standar_mutu_id' => $stdDik002->id,
            ]);

            // ── Tindak Lanjut ──
            TindakLanjutTemuan::create([
                'temuan_audit_id' => $temuan1->id,
                'penanggung_jawab_id' => $kaprodiTI->id,
                'rencana_tindak_lanjut' => 'Mengajukan anggaran pengadaan buku referensi terbaru melalui DIPA tahun berikutnya.',
                'target_selesai' => '2026-03-31',
                'status' => 'On Progress',
            ]);

            TindakLanjutTemuan::create([
                'temuan_audit_id' => $temuan2->id,
                'penanggung_jawab_id' => $kaprodiTI->id,
                'rencana_tindak_lanjut' => 'Melakukan revisi RPS seluruh mata kuliah pilihan pada semester berikutnya.',
                'target_selesai' => '2026-02-28',
                'status' => 'Open',
            ]);

            // ── Tim Audit ──
            \App\Models\TimAudit::create([
                'jadwal_audit_id' => $jadwal1->id,
                'user_id' => $auditorKetua->id,
                'peran_dalam_tim' => 'Ketua Tim',
            ]);
            \App\Models\TimAudit::create([
                'jadwal_audit_id' => $jadwal1->id,
                'user_id' => $auditor1->id,
                'peran_dalam_tim' => 'Anggota',
            ]);
            \App\Models\TimAudit::create([
                'jadwal_audit_id' => $jadwal1->id,
                'user_id' => $auditor2->id,
                'peran_dalam_tim' => 'Anggota',
            ]);
        }

        // ── Survei dengan Pertanyaan ──
        $jenisSurveiKepuasan = \App\Models\JenisSurvei::where('nama', 'Kepuasan Mahasiswa')->first();

        $survei = Survei::create([
            'jenis_survei_id' => $jenisSurveiKepuasan->id,
            'judul' => 'Survei Kepuasan Mahasiswa Semester Ganjil 2025/2026',
            'tahun_akademik_id' => $taActive->id,
            'tanggal_mulai' => '2025-10-01',
            'tanggal_selesai' => '2025-11-30',
            'status' => 'Aktif',
            'dibuat_oleh' => $adminSpmi->id,
        ]);

        $pertanyaanData = [
            ['teks' => 'Bagaimana kepuasan Anda terhadap kualitas pengajaran dosen?', 'tipe' => 'rating'],
            ['teks' => 'Bagaimana kepuasan Anda terhadap fasilitas laboratorium?', 'tipe' => 'rating'],
            ['teks' => 'Bagaimana kepuasan Anda terhadap layanan administrasi?', 'tipe' => 'rating'],
            ['teks' => 'Bagaimana kepuasan Anda terhadap perpustakaan?', 'tipe' => 'rating'],
            ['teks' => 'Saran dan masukan untuk peningkatan mutu?', 'tipe' => 'teks'],
        ];

        $pertanyaanIds = [];
        foreach ($pertanyaanData as $index => $p) {
            $pertanyaan = PertanyaanSurvei::create([
                'survei_id' => $survei->id,
                'teks_pertanyaan' => $p['teks'],
                'tipe_jawaban' => $p['tipe'],
                'urutan' => $index + 1,
            ]);
            $pertanyaanIds[] = $pertanyaan->id;
        }

        // Sample jawaban
        $mahasiswaUsers = User::role('mahasiswa')->get()->take(5);
        foreach ($mahasiswaUsers as $mhs) {
            foreach ($pertanyaanIds as $pId) {
                $pertanyaan = PertanyaanSurvei::find($pId);
                \App\Models\JawabanSurvei::create([
                    'survei_id' => $survei->id,
                    'pertanyaan_survei_id' => $pId,
                    'responden_id' => $mhs->id,
                    'nilai_jawaban' => $pertanyaan->tipe_jawaban === 'rating' ? rand(3, 5) : null,
                    'teks_jawaban' => $pertanyaan->tipe_jawaban === 'teks' ? 'Semoga kualitas terus ditingkatkan.' : null,
                ]);
            }
        }

        // ── Sample Capaian Indikator ──
        $indikatorList = \App\Models\IndikatorMutu::all()->take(5);
        foreach ($indikatorList as $indikator) {
            \App\Models\CapaianIndikator::create([
                'indikator_mutu_id' => $indikator->id,
                'tahun_akademik_id' => $taActive->id,
                'program_studi_id' => $prodiTI->id,
                'nilai_capaian' => rand(6000, 9800) / 100,
                'status_warna' => rand(0, 100) > 30 ? 'hijau' : 'kuning',
                'sumber_input' => 'Manual',
                'dihitung_pada' => now(),
                'dihitung_oleh' => $gpmRatna->id,
            ]);

            \App\Models\TargetIndikator::create([
                'indikator_mutu_id' => $indikator->id,
                'tahun_akademik_id' => $taActive->id,
                'program_studi_id' => $prodiTI->id,
                'nilai_target' => 80.00,
                'ambang_kuning' => 70.00,
            ]);
        }
    }
}
