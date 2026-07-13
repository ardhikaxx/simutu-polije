<?php

namespace Database\Seeders;

use App\Models\FakultasJurusan;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class JurusanProdiSeeder extends Seeder
{
    public function run(): void
    {
        $jurusanData = [
            [
                'kode_jurusan' => 'JPP',
                'nama_jurusan' => 'Jurusan Produksi Pertanian',
                'prodi' => [
                    ['kode_prodi' => 'HOR', 'nama_prodi' => 'D3 Produksi Tanaman Hortikultura', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'PKB', 'nama_prodi' => 'D3 Produksi Tanaman Perkebunan', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'BTP', 'nama_prodi' => 'D4 Budidaya Tanaman Perkebunan', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TPB', 'nama_prodi' => 'D4 Teknik Produksi Benih', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TPTP', 'nama_prodi' => 'D4 Teknologi Produksi Tanaman Pangan', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'PPK', 'nama_prodi' => 'D4 Pengelolaan Perkebunan Kopi', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JTP',
                'nama_jurusan' => 'Jurusan Teknologi Pertanian',
                'prodi' => [
                    ['kode_prodi' => 'TIP', 'nama_prodi' => 'D3 Teknologi Industri Pangan', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'KTP', 'nama_prodi' => 'D3 Keteknikan Pertanian', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TRP', 'nama_prodi' => 'D4 Teknologi Rekayasa Pangan', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JPTN',
                'nama_jurusan' => 'Jurusan Peternakan',
                'prodi' => [
                    ['kode_prodi' => 'PTK', 'nama_prodi' => 'D3 Produksi Ternak', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'MBU', 'nama_prodi' => 'D4 Manajemen Bisnis Unggas', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TPT', 'nama_prodi' => 'D4 Teknologi Pakan Ternak', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JMA',
                'nama_jurusan' => 'Jurusan Manajemen Agribisnis',
                'prodi' => [
                    ['kode_prodi' => 'MAB', 'nama_prodi' => 'D3 Manajemen Agribisnis', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'MAG', 'nama_prodi' => 'D4 Manajemen Agroindustri', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JTI',
                'nama_jurusan' => 'Jurusan Teknologi Informasi',
                'prodi' => [
                    ['kode_prodi' => 'MI', 'nama_prodi' => 'D3 Manajemen Informatika', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TK', 'nama_prodi' => 'D3 Teknik Komputer', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TI', 'nama_prodi' => 'D4 Teknik Informatika', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TRK', 'nama_prodi' => 'D4 Teknologi Rekayasa Komputer', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JBKP',
                'nama_jurusan' => 'Jurusan Bahasa, Komunikasi, dan Pariwisata',
                'prodi' => [
                    ['kode_prodi' => 'BIG', 'nama_prodi' => 'D3 Bahasa Inggris', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'DP', 'nama_prodi' => 'D4 Destinasi Pariwisata', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JKS',
                'nama_jurusan' => 'Jurusan Kesehatan',
                'prodi' => [
                    ['kode_prodi' => 'MIK', 'nama_prodi' => 'D4 Manajemen Informasi Kesehatan', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'GZK', 'nama_prodi' => 'D4 Gizi Klinik', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'PRK', 'nama_prodi' => 'D4 Promosi Kesehatan', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JTK',
                'nama_jurusan' => 'Jurusan Teknik',
                'prodi' => [
                    ['kode_prodi' => 'TET', 'nama_prodi' => 'D4 Teknik Energi Terbarukan', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'MO', 'nama_prodi' => 'D4 Mesin Otomotif', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TRM', 'nama_prodi' => 'D4 Teknologi Rekayasa Mekatronika', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'JBIS',
                'nama_jurusan' => 'Jurusan Bisnis',
                'prodi' => [
                    ['kode_prodi' => 'ASP', 'nama_prodi' => 'D4 Akuntansi Sektor Publik', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'MPI', 'nama_prodi' => 'D4 Manajemen Pemasaran Internasional', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'PSDKU-BON',
                'nama_jurusan' => 'PSDKU Bondowoso',
                'prodi' => [
                    ['kode_prodi' => 'MAB-BDO', 'nama_prodi' => 'D4 Manajemen Agribisnis', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'PMD-BDO', 'nama_prodi' => 'D4 Produksi Media', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'BD-BDO', 'nama_prodi' => 'D4 Bisnis Digital', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'PSDKU-NGJ',
                'nama_jurusan' => 'PSDKU Nganjuk',
                'prodi' => [
                    ['kode_prodi' => 'MAB-NGJ', 'nama_prodi' => 'D3 Manajemen Agribisnis', 'jenjang' => 'D3', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TI-NGJ', 'nama_prodi' => 'D4 Teknik Informatika', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'PSDKU-SDA',
                'nama_jurusan' => 'PSDKU Sidoarjo',
                'prodi' => [
                    ['kode_prodi' => 'MAG-SDA', 'nama_prodi' => 'D4 Manajemen Agroindustri', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'TI-SDA', 'nama_prodi' => 'D4 Teknik Informatika', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'PSDKU-NGW',
                'nama_jurusan' => 'PSDKU Ngawi',
                'prodi' => [
                    ['kode_prodi' => 'MAB-NGW', 'nama_prodi' => 'D4 Manajemen Agribisnis', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                    ['kode_prodi' => 'MIK-NGW', 'nama_prodi' => 'D4 Manajemen Informasi Kesehatan', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
            [
                'kode_jurusan' => 'PSDKU-SBR',
                'nama_jurusan' => 'PSDKU Sabu Raijua',
                'prodi' => [
                    ['kode_prodi' => 'TRPL-SBR', 'nama_prodi' => 'D4 Teknologi Rekayasa Perangkat Lunak', 'jenjang' => 'D4', 'akreditasi' => 'B'],
                ],
            ],
        ];

        foreach ($jurusanData as $jurusanInfo) {
            $jurusan = FakultasJurusan::create([
                'nama_jurusan' => $jurusanInfo['nama_jurusan'],
                'kode_jurusan' => $jurusanInfo['kode_jurusan'],
                'status' => 'aktif',
            ]);

            foreach ($jurusanInfo['prodi'] as $prodiInfo) {
                ProgramStudi::create([
                    'jurusan_id' => $jurusan->id,
                    'nama_prodi' => $prodiInfo['nama_prodi'],
                    'kode_prodi' => $prodiInfo['kode_prodi'],
                    'jenjang' => $prodiInfo['jenjang'],
                    'akreditasi_saat_ini' => $prodiInfo['akreditasi'],
                    'status' => 'aktif',
                ]);
            }
        }

        // Kelas Internasional under JTI (Jurusan Teknologi Informasi)
        $jti = FakultasJurusan::where('kode_jurusan', 'JTI')->first();
        $kelasInternasional = [
            ['kode_prodi' => 'MI-INT', 'nama_prodi' => 'D3 Manajemen Informatika (Kelas Internasional)', 'jenjang' => 'D3', 'akreditasi' => 'B'],
            ['kode_prodi' => 'TI-INT', 'nama_prodi' => 'D4 Teknik Informatika (Kelas Internasional)', 'jenjang' => 'D4', 'akreditasi' => 'B'],
        ];

        $jma = FakultasJurusan::where('kode_jurusan', 'JMA')->first();
        $kelasInternasional[] = ['kode_prodi' => 'MAG-INT', 'nama_prodi' => 'D4 Manajemen Agroindustri (Kelas Internasional)', 'jenjang' => 'D4', 'akreditasi' => 'B'];

        foreach ($kelasInternasional as $ki) {
            ProgramStudi::create([
                'jurusan_id' => $ki['kode_prodi'] === 'MAG-INT' ? $jma->id : $jti->id,
                'nama_prodi' => $ki['nama_prodi'],
                'kode_prodi' => $ki['kode_prodi'],
                'jenjang' => $ki['jenjang'],
                'akreditasi_saat_ini' => $ki['akreditasi'],
                'status' => 'aktif',
            ]);
        }
    }
}
