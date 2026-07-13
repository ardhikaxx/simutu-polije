<?php

namespace App\Services\Numbering;

use App\Models\DokumenMutu;
use App\Models\FakultasJurusan;
use App\Models\KategoriDokumen;
use App\Models\ProgramStudi;
use App\Models\UnitKerja;

class DocumentNumberingService
{
    public function generate(KategoriDokumen $kategori, $unitId): string
    {
        $prefix = $kategori->prefix_nomor;
        $kodeUnit = $this->resolveKodeUnit($unitId);
        $tahun = now()->format('Y');

        $lastNumber = DokumenMutu::where('kategori_dokumen_id', $kategori->id)
            ->whereYear('created_at', $tahun)
            ->count();

        $urut = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "{$prefix}/{$kodeUnit}/{$tahun}/{$urut}";
    }

    private function resolveKodeUnit($unitId): string
    {
        $prodi = ProgramStudi::find($unitId);

        if ($prodi) {
            return $prodi->kode_prodi;
        }

        $unitKerja = UnitKerja::find($unitId);

        if ($unitKerja) {
            return $this->generateAbbreviation($unitKerja->nama_unit);
        }

        $jurusan = FakultasJurusan::find($unitId);

        if ($jurusan) {
            return $jurusan->kode_jurusan;
        }

        return 'INST';
    }

    private function generateAbbreviation(string $namaUnit): string
    {
        $words = explode(' ', $namaUnit);
        $abbreviation = '';

        foreach ($words as $word) {
            $abbreviation .= strtoupper(substr($word, 0, 2));
        }

        return substr($abbreviation, 0, 4);
    }
}
