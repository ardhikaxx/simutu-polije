<?php

namespace App\Http\Controllers\TemplateDokumen;

use App\Http\Controllers\Controller;
use App\Models\StandarMutu;
use App\Models\TemplateDokumen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TemplateDokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = TemplateDokumen::with('standarMutu');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_template', 'like', "%{$request->search}%")
                    ->orWhere('deskripsi', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('standar')) {
            $query->where('standar_mutu_id', $request->standar);
        }

        $templates = $query->latest()->get();
        $standarMutus = StandarMutu::orderBy('nama_standar')->get();

        return view('dokumen-mutu.template', compact('templates', 'standarMutus'));
    }

    public function download(TemplateDokumen $template)
    {
        $template->increment('downloads');

        $standar = $template->standarMutu;

        $pdf = Pdf::loadView('dokumen-mutu.pdf-template', [
            'template' => $template,
            'standar' => $standar,
            'indikators' => $standar->indikatorMutu,
        ])->setPaper('a4');

        return $pdf->download('template-' . $template->standarMutu->kode_standar . '.pdf');
    }
}
