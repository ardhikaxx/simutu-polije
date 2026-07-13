<?php

namespace Database\Seeders;

use App\Models\IndikatorMutu;
use App\Models\KategoriStandar;
use App\Models\StandarMutu;
use App\Models\User;
use Illuminate\Database\Seeder;

class StandarMutuSeeder extends Seeder
{
    public function run(): void
    {
        $adminSpmi = User::where('email', 'admin.spmi@polije.ac.id')->first();
        $direktur = User::where('email', 'direktur@polije.ac.id')->first();

        $katPendidikan = KategoriStandar::where('nama', 'LIKE', '%Pendidikan%')->first();
        $katPenelitian = KategoriStandar::where('nama', 'LIKE', '%Penelitian%')->first();
        $katPengabdian = KategoriStandar::where('nama', 'LIKE', '%Pengabdian%')->first();
        $katTambahan = KategoriStandar::where('nama', 'LIKE', '%Tambahan%')->first();

        $standarPendidikan = [
            [
                'kode_standar' => 'STD-DIK-001',
                'nama_standar' => 'Kompetensi Lulusan',
                'deskripsi' => 'Standar yang mengatur tentang kompetensi lulusan yang meliputi sikap, pengetahuan, dan keterampilan sesuai kebutuhan pemangku kepentingan.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['JPP', 'JTP', 'JPTN', 'JMA', 'JTI', 'JBKP', 'JKS', 'JTK', 'JBIS'],
                'indikator' => [
                    ['nama_indikator' => 'Tingkat Kelulusan Tepat Waktu', 'satuan' => '%', 'formula' => '(Jumlah lulusan tepat waktu / Jumlah mahasiswa yang harus lulus) x 100%', 'sumber_data' => 'Data Academic Information System', 'frekuensi' => 'Tahunan', 'pj_role' => 'kaprodi'],
                    ['nama_indikator' => 'Rata-rata IPK Lulusan', 'satuan' => 'skala 4', 'formula' => 'Total IPK semua lulusan / Jumlah lulusan', 'sumber_data' => 'Data Academic Information System', 'frekuensi' => 'Tahunan', 'pj_role' => 'kaprodi'],
                    ['nama_indikator' => 'Daya Tampung Terserap di Dunia Kerja', 'satuan' => '%', 'formula' => '(Jumlah lulusan yang bekerja dalam 1 tahun / Jumlah lulusan) x 100%', 'sumber_data' => 'Tracer Study', 'frekuensi' => 'Tahunan', 'pj_role' => 'kaprodi'],
                ],
            ],
            [
                'kode_standar' => 'STD-DIK-002',
                'nama_standar' => 'Kualitas Proses Pembelajaran',
                'deskripsi' => 'Standar yang mengatur tentang perencanaan, pelaksanaan, dan evaluasi proses pembelajaran yang efektif dan efisien.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['JPP', 'JTP', 'JPTN', 'JMA', 'JTI', 'JBKP', 'JKS', 'JTK', 'JBIS'],
                'indikator' => [
                    ['nama_indikator' => 'Rata-rata Evaluasi Dosen oleh Mahasiswa', 'satuan' => 'skala 5', 'formula' => 'Total skor evaluasi / Jumlah responden', 'sumber_data' => 'Survei Evaluasi Dosen', 'frekuensi' => 'Semester', 'pj_role' => 'kaprodi'],
                    ['nama_indikator' => 'Penyelesaian Kurikulum per Semester', 'satuan' => '%', 'formula' => '(Mata kuliah yang selesai sesuai jadwal / Total mata kuliah yang dijadwalkan) x 100%', 'sumber_data' => 'Data Academic Information System', 'frekuensi' => 'Semester', 'pj_role' => 'kaprodi'],
                ],
            ],
            [
                'kode_standar' => 'STD-DIK-003',
                'nama_standar' => 'Beban dan Sistem Penyelenggaraan Pendidikan',
                'deskripsi' => 'Standar yang mengatur tentang beban belajar, beban kerja dosen, dan sistem penyelenggaraan pendidikan.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['JPP', 'JTP', 'JPTN', 'JMA', 'JTI', 'JBKP', 'JKS', 'JTK', 'JBIS'],
                'indikator' => [
                    ['nama_indikator' => 'Rasio Dosen Mahasiswa', 'satuan' => 'banding', 'formula' => 'Jumlah mahasiswa aktif / Jumlah dosen tetap', 'sumber_data' => 'Data Academic Information System', 'frekuensi' => 'Tahunan', 'pj_role' => 'kajur'],
                    ['nama_indikator' => 'Pemenuhan Beban SKS Dosen', 'satuan' => '%', 'formula' => '(Beban SKS yang diampu aktual / Beban SKS standar) x 100%', 'sumber_data' => 'Data Academic Information System', 'frekuensi' => 'Semester', 'pj_role' => 'kajur'],
                ],
            ],
            [
                'kode_standar' => 'STD-DIK-004',
                'nama_standar' => 'Sarana dan Prasarana',
                'deskripsi' => 'Standar yang mengatur ketersediaan dan kelayakan sarana dan prasarana pendidikan.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['JPP', 'JTP', 'JPTN', 'JMA', 'JTI', 'JBKP', 'JKS', 'JTK', 'JBIS'],
                'indikator' => [
                    ['nama_indikator' => 'Rasio Siswa per Ruang Kelas', 'satuan' => 'banding', 'formula' => 'Jumlah mahasiswa aktif / Jumlah ruang kelas yang layak', 'sumber_data' => 'Data Sarana Prasarana', 'frekuensi' => 'Tahunan', 'pj_role' => 'tendik'],
                    ['nama_indikator' => 'Ketersediaan Lab/Klinik Praktik', 'satuan' => 'unit', 'formula' => 'Jumlah lab/klinik yang tersedia', 'sumber_data' => 'Data Sarana Prasarana', 'frekuensi' => 'Tahunan', 'pj_role' => 'tendik'],
                ],
            ],
            [
                'kode_standar' => 'STD-DIK-005',
                'nama_standar' => 'Dosen dan Tenaga Kependidikan',
                'deskripsi' => 'Standar yang mengatur kualifikasi, kompetensi, dan beban kerja dosen serta tenaga kependidikan.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['JPP', 'JTP', 'JPTN', 'JMA', 'JTI', 'JBKP', 'JKS', 'JTK', 'JBIS'],
                'indikator' => [
                    ['nama_indikator' => 'Persentase Dosen dengan Kualifikasi S3', 'satuan' => '%', 'formula' => '(Jumlah dosen S3 / Jumlah total dosen tetap) x 100%', 'sumber_data' => 'Data Kepegawaian', 'frekuensi' => 'Tahunan', 'pj_role' => 'kajur'],
                    ['nama_indikator' => 'Rasio Dosen per Mahasiswa', 'satuan' => 'banding', 'formula' => 'Jumlah mahasiswa aktif / Jumlah dosen', 'sumber_data' => 'Data Kepegawaian', 'frekuensi' => 'Tahunan', 'pj_role' => 'kajur'],
                ],
            ],
            [
                'kode_standar' => 'STD-DIK-006',
                'nama_standar' => 'Pembiayaan',
                'deskripsi' => 'Standar yang mengatur efisiensi dan efektivitas pengelolaan pembiayaan pendidikan.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['Biro Administrasi Umum dan Keuangan'],
                'indikator' => [
                    ['nama_indikator' => 'Efisiensi Anggaran Per Mahasiswa', 'satuan' => 'Rp', 'formula' => 'Total anggaran pendidikan / Jumlah mahasiswa aktif', 'sumber_data' => 'Data Keuangan', 'frekuensi' => 'Tahunan', 'pj_role' => 'tendik'],
                ],
            ],
            [
                'kode_standar' => 'STD-DIK-007',
                'nama_standar' => 'Penilaian',
                'deskripsi' => 'Standar yang mengatur sistem dan proses penilaian hasil belajar mahasiswa.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['JPP', 'JTP', 'JPTN', 'JMA', 'JTI', 'JBKP', 'JKS', 'JTK', 'JBIS'],
                'indikator' => [
                    ['nama_indikator' => 'Tingkat Ketuntasan Akademik Mahasiswa', 'satuan' => '%', 'formula' => '(Jumlah mahasiswa yang mencapai IPK >= 2.0 / Jumlah mahasiswa aktif) x 100%', 'sumber_data' => 'Data Academic Information System', 'frekuensi' => 'Semester', 'pj_role' => 'kaprodi'],
                    ['nama_indikator' => 'Tingkat Drop Out (DO)', 'satuan' => '%', 'formula' => '(Jumlah mahasiswa DO / Jumlah mahasiswa aktif) x 100%', 'sumber_data' => 'Data Academic Information System', 'frekuensi' => 'Tahunan', 'pj_role' => 'kaprodi'],
                ],
            ],
            [
                'kode_standar' => 'STD-DIK-008',
                'nama_standar' => 'Sistem Penjaminan Mutu Internal',
                'deskripsi' => 'Standar yang mengatur kelembagaan, mekanisme, dan prosedur penjaminan mutu di tingkat institusi.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi Nomor 52 Tahun 2023 tentang Standar Nasional Pendidikan',
                'unit_terdampak' => ['Pusat Penjaminan Mutu (Pusjianmut)'],
                'indikator' => [
                    ['nama_indikator' => 'Tingkat Pelaksanaan Audit Internal', 'satuan' => 'kegiatan', 'formula' => 'Jumlah audit internal yang dilaksanakan per tahun', 'sumber_data' => 'Data Audit Internal', 'frekuensi' => 'Tahunan', 'pj_role' => 'gpm'],
                    ['nama_indikator' => 'Persentase Tindak Lanjut Temuan Audit', 'satuan' => '%', 'formula' => '(Jumlah temuan yang sudah ditindaklanjuti / Jumlah total temuan) x 100%', 'sumber_data' => 'Data Tindak Lanjut', 'frekuensi' => 'Tahunan', 'pj_role' => 'gpm'],
                ],
            ],
        ];

        foreach ($standarPendidikan as $std) {
            $standar = StandarMutu::create([
                'kategori_standar_id' => $katPendidikan->id,
                'kode_standar' => $std['kode_standar'],
                'nama_standar' => $std['nama_standar'],
                'deskripsi' => $std['deskripsi'],
                'dasar_hukum' => $std['dasar_hukum'],
                'unit_terdampak' => $std['unit_terdampak'],
                'status' => 'Published',
                'tanggal_berlaku' => '2025-08-01',
                'dibuat_oleh' => $adminSpmi->id,
                'disahkan_oleh' => $direktur->id,
            ]);

            foreach ($std['indikator'] as $ind) {
                IndikatorMutu::create([
                    'standar_mutu_id' => $standar->id,
                    'nama_indikator' => $ind['nama_indikator'],
                    'definisi_operasional' => $ind['formula'],
                    'satuan' => $ind['satuan'],
                    'formula_perhitungan' => $ind['formula'],
                    'sumber_data' => $ind['sumber_data'],
                    'frekuensi_pengukuran' => $ind['frekuensi'],
                    'penanggung_jawab_role' => $ind['pj_role'],
                ]);
            }
        }

        // Standar Nasional Penelitian
        $standarPenelitian = [
            [
                'kode_standar' => 'STD-PEN-001',
                'nama_standar' => 'Kebijakan dan Pengelolaan Penelitian',
                'deskripsi' => 'Standar yang mengatur kebijakan, pengelolaan, dan pembiayaan penelitian di institusi.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi tentang Standar Nasional Penelitian',
                'unit_terdampak' => ['Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)'],
                'indikator' => [
                    ['nama_indikator' => 'Jumlah Penelitian yang Didanai per Tahun', 'satuan' => 'judul', 'formula' => 'Jumlah judul penelitian yang mendapat pendanaan', 'sumber_data' => 'Data LPPM', 'frekuensi' => 'Tahunan', 'pj_role' => 'gpm'],
                    ['nama_indikator' => 'Rasio Dosen yang Melakukan Penelitian', 'satuan' => '%', 'formula' => '(Jumlah dosen peneliti / Jumlah dosen tetap) x 100%', 'sumber_data' => 'Data LPPM', 'frekuensi' => 'Tahunan', 'pj_role' => 'gpm'],
                ],
            ],
            [
                'kode_standar' => 'STD-PEN-002',
                'nama_standar' => 'Publikasi dan Hak Kekayaan Intelektual',
                'deskripsi' => 'Standar yang mengatur publikasi hasil penelitian dan pencatatan HKI.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi tentang Standar Nasional Penelitian',
                'unit_terdampak' => ['Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)'],
                'indikator' => [
                    ['nama_indikator' => 'Jumlah Publikasi di Jurnal Terakreditasi', 'satuan' => 'artikel', 'formula' => 'Jumlah artikel yang dipublikasikan di jurnal terakreditasi', 'sumber_data' => 'Data Publikasi', 'frekuensi' => 'Tahunan', 'pj_role' => 'gpm'],
                ],
            ],
        ];

        foreach ($standarPenelitian as $std) {
            $standar = StandarMutu::create([
                'kategori_standar_id' => $katPenelitian->id,
                'kode_standar' => $std['kode_standar'],
                'nama_standar' => $std['nama_standar'],
                'deskripsi' => $std['deskripsi'],
                'dasar_hukum' => $std['dasar_hukum'],
                'unit_terdampak' => $std['unit_terdampak'],
                'status' => 'Published',
                'tanggal_berlaku' => '2025-08-01',
                'dibuat_oleh' => $adminSpmi->id,
                'disahkan_oleh' => $direktur->id,
            ]);

            foreach ($std['indikator'] as $ind) {
                IndikatorMutu::create([
                    'standar_mutu_id' => $standar->id,
                    'nama_indikator' => $ind['nama_indikator'],
                    'definisi_operasional' => $ind['formula'],
                    'satuan' => $ind['satuan'],
                    'formula_perhitungan' => $ind['formula'],
                    'sumber_data' => $ind['sumber_data'],
                    'frekuensi_pengukuran' => $ind['frekuensi'],
                    'penanggung_jawab_role' => $ind['pj_role'],
                ]);
            }
        }

        // Standar Nasional Pengabdian kepada Masyarakat
        $standarPengabdian = [
            [
                'kode_standar' => 'STD-PKM-001',
                'nama_standar' => 'Kebijakan dan Pengelolaan Pengabdian kepada Masyarakat',
                'deskripsi' => 'Standar yang mengatur kebijakan, perencanaan, dan pelaksanaan kegiatan pengabdian kepada masyarakat.',
                'dasar_hukum' => 'Peraturan Menteri Pendidikan, Kebudayaan, Riset, dan Teknologi tentang Standar Nasional Pengabdian kepada Masyarakat',
                'unit_terdampak' => ['Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM)'],
                'indikator' => [
                    ['nama_indikator' => 'Jumlah Kegiatan Pengabdian per Tahun', 'satuan' => 'kegiatan', 'formula' => 'Jumlah kegiatan pengabdian masyarakat yang dilaksanakan', 'sumber_data' => 'Data LPPM', 'frekuensi' => 'Tahunan', 'pj_role' => 'gpm'],
                ],
            ],
        ];

        foreach ($standarPengabdian as $std) {
            $standar = StandarMutu::create([
                'kategori_standar_id' => $katPengabdian->id,
                'kode_standar' => $std['kode_standar'],
                'nama_standar' => $std['nama_standar'],
                'deskripsi' => $std['deskripsi'],
                'dasar_hukum' => $std['dasar_hukum'],
                'unit_terdampak' => $std['unit_terdampak'],
                'status' => 'Published',
                'tanggal_berlaku' => '2025-08-01',
                'dibuat_oleh' => $adminSpmi->id,
                'disahkan_oleh' => $direktur->id,
            ]);

            foreach ($std['indikator'] as $ind) {
                IndikatorMutu::create([
                    'standar_mutu_id' => $standar->id,
                    'nama_indikator' => $ind['nama_indikator'],
                    'definisi_operasional' => $ind['formula'],
                    'satuan' => $ind['satuan'],
                    'formula_perhitungan' => $ind['formula'],
                    'sumber_data' => $ind['sumber_data'],
                    'frekuensi_pengukuran' => $ind['frekuensi'],
                    'penanggung_jawab_role' => $ind['pj_role'],
                ]);
            }
        }

        // Standar Tambahan Polije
        $standarTambahan = [
            [
                'kode_standar' => 'STD-TAM-001',
                'nama_standar' => 'Kepuasan Pemangku Kepentingan',
                'deskripsi' => 'Standar yang mengatur pengukuran kepuasan mahasiswa, dosen, dan mitra terhadap layanan institusi.',
                'dasar_hukum' => 'Keputusan Direktur Polije tentang Standar Mutu Internal',
                'unit_terdampak' => ['Pusat Penjaminan Mutu (Pusjianmut)'],
                'indikator' => [
                    ['nama_indikator' => 'Indeks Kepuasan Mahasiswa', 'satuan' => 'skala 5', 'formula' => 'Rata-rata seluruh skor kepuasan dari survei', 'sumber_data' => 'Survei Kepuasan Mahasiswa', 'frekuensi' => 'Semester', 'pj_role' => 'gpm'],
                    ['nama_indikator' => 'Indeks Kepuasan Dosen', 'satuan' => 'skala 5', 'formula' => 'Rata-rata seluruh skor kepuasan dari survei dosen', 'sumber_data' => 'Survei Evaluasi Dosen', 'frekuensi' => 'Tahunan', 'pj_role' => 'gpm'],
                ],
            ],
            [
                'kode_standar' => 'STD-TAM-002',
                'nama_standar' => 'Mutu Layanan Administrasi',
                'deskripsi' => 'Standar yang mengatur kualitas layanan administrasi akademik dan umum.',
                'dasar_hukum' => 'Keputusan Direktur Polije tentang Standar Mutu Internal',
                'unit_terdampak' => ['Biro Administrasi Akademik', 'Biro Administrasi Umum dan Keuangan'],
                'indikator' => [
                    ['nama_indikator' => 'Waktu Pelayanan Administrasi Akademik', 'satuan' => 'hari', 'formula' => 'Rata-rata waktu penyelesaian permohonan administrasi', 'sumber_data' => 'Log Pelayanan', 'frekuensi' => 'Semester', 'pj_role' => 'tendik'],
                ],
            ],
        ];

        foreach ($standarTambahan as $std) {
            $standar = StandarMutu::create([
                'kategori_standar_id' => $katTambahan->id,
                'kode_standar' => $std['kode_standar'],
                'nama_standar' => $std['nama_standar'],
                'deskripsi' => $std['deskripsi'],
                'dasar_hukum' => $std['dasar_hukum'],
                'unit_terdampak' => $std['unit_terdampak'],
                'status' => 'Published',
                'tanggal_berlaku' => '2025-08-01',
                'dibuat_oleh' => $adminSpmi->id,
                'disahkan_oleh' => $direktur->id,
            ]);

            foreach ($std['indikator'] as $ind) {
                IndikatorMutu::create([
                    'standar_mutu_id' => $standar->id,
                    'nama_indikator' => $ind['nama_indikator'],
                    'definisi_operasional' => $ind['formula'],
                    'satuan' => $ind['satuan'],
                    'formula_perhitungan' => $ind['formula'],
                    'sumber_data' => $ind['sumber_data'],
                    'frekuensi_pengukuran' => $ind['frekuensi'],
                    'penanggung_jawab_role' => $ind['pj_role'],
                ]);
            }
        }
    }
}
