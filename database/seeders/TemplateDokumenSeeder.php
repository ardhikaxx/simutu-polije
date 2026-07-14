<?php

namespace Database\Seeders;

use App\Models\StandarMutu;
use App\Models\TemplateDokumen;
use Illuminate\Database\Seeder;

class TemplateDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            ['kode' => 'STD-DIK-001', 'nama' => 'Template Standar Kompetensi Lulusan', 'deskripsi' => 'Template dokumen standar kompetensi lulusan meliputi sikap, pengetahuan, dan keterampilan.', 'jenis' => 'pdf', 'ukuran' => 245],
            ['kode' => 'STD-DIK-002', 'nama' => 'Template Kualitas Proses Pembelajaran', 'deskripsi' => 'Template dokumen perencanaan, pelaksanaan, dan evaluasi proses pembelajaran.', 'jenis' => 'pdf', 'ukuran' => 312],
            ['kode' => 'STD-DIK-003', 'nama' => 'Template Beban dan Sistem Penyelenggaraan Pendidikan', 'deskripsi' => 'Template dokumen beban belajar, beban kerja dosen, dan sistem penyelenggaraan.', 'jenis' => 'pdf', 'ukuran' => 198],
            ['kode' => 'STD-DIK-004', 'nama' => 'Template Sarana dan Prasarana', 'deskripsi' => 'Template dokumen ketersediaan dan kelayakan sarana prasarana pendidikan.', 'jenis' => 'pdf', 'ukuran' => 276],
            ['kode' => 'STD-DIK-005', 'nama' => 'Template Dosen dan Tenaga Kependidikan', 'deskripsi' => 'Template dokumen kualifikasi, kompetensi, dan beban kerja dosen serta tendik.', 'jenis' => 'pdf', 'ukuran' => 230],
            ['kode' => 'STD-DIK-006', 'nama' => 'Template Pembiayaan', 'deskripsi' => 'Template dokumen efisiensi dan efektivitas pengelolaan pembiayaan pendidikan.', 'jenis' => 'pdf', 'ukuran' => 189],
            ['kode' => 'STD-DIK-007', 'nama' => 'Template Penilaian', 'deskripsi' => 'Template dokumen sistem dan proses penilaian hasil belajar mahasiswa.', 'jenis' => 'pdf', 'ukuran' => 215],
            ['kode' => 'STD-DIK-008', 'nama' => 'Template Sistem Penjaminan Mutu Internal', 'deskripsi' => 'Template dokumen kelembagaan, mekanisme, dan prosedur penjaminan mutu.', 'jenis' => 'pdf', 'ukuran' => 342],
            ['kode' => 'STD-PEN-001', 'nama' => 'Template Kebijakan dan Pengelolaan Penelitian', 'deskripsi' => 'Template dokumen kebijakan, pengelolaan, dan pembiayaan penelitian.', 'jenis' => 'pdf', 'ukuran' => 267],
            ['kode' => 'STD-PEN-002', 'nama' => 'Template Publikasi dan HKI', 'deskripsi' => 'Template dokumen publikasi hasil penelitian dan pencatatan HKI.', 'jenis' => 'pdf', 'ukuran' => 198],
            ['kode' => 'STD-PKM-001', 'nama' => 'Template Pengabdian kepada Masyarakat', 'deskripsi' => 'Template dokumen kebijakan, perencanaan, dan pelaksanaan pengabdian masyarakat.', 'jenis' => 'pdf', 'ukuran' => 221],
            ['kode' => 'STD-TAM-001', 'nama' => 'Template Kepuasan Pemangku Kepentingan', 'deskripsi' => 'Template dokumen pengukuran kepuasan mahasiswa, dosen, dan mitra.', 'jenis' => 'pdf', 'ukuran' => 178],
            ['kode' => 'STD-TAM-002', 'nama' => 'Template Mutu Layanan Administrasi', 'deskripsi' => 'Template dokumen kualitas layanan administrasi akademik dan umum.', 'jenis' => 'pdf', 'ukuran' => 156],
        ];

        foreach ($templates as $t) {
            $standar = StandarMutu::where('kode_standar', $t['kode'])->first();
            if ($standar) {
                TemplateDokumen::create([
                    'standar_mutu_id' => $standar->id,
                    'nama_template' => $t['nama'],
                    'deskripsi' => $t['deskripsi'],
                    'jenis_file' => $t['jenis'],
                    'ukuran_file' => $t['ukuran'],
                    'downloads' => rand(5, 120),
                    'is_active' => true,
                ]);
            }
        }
    }
}
