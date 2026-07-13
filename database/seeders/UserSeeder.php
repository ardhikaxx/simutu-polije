<?php

namespace Database\Seeders;

use App\Models\FakultasJurusan;
use App\Models\ProgramStudi;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        // ── Super Admin ──
        $superAdmin = User::create([
            'nama' => 'Administrator Sistem',
            'nip_nim' => '198501012010011001',
            'email' => 'superadmin@polije.ac.id',
            'password' => $defaultPassword,
            'status' => 'aktif',
        ]);
        $superAdmin->assignRole('super_admin');

        // ── Admin SPMI ──
        $pusjanmut = UnitKerja::where('nama_unit', 'LIKE', '%Pusjianmut%')->first();

        $adminSpmi1 = User::create([
            'nama' => 'Rina Widiastuti',
            'nip_nim' => '198605152011012002',
            'email' => 'admin.spmi@polije.ac.id',
            'password' => $defaultPassword,
            'unit_kerja_id' => $pusjanmut->id,
            'status' => 'aktif',
        ]);
        $adminSpmi1->assignRole('admin_spmi');

        $adminSpmi2 = User::create([
            'nama' => 'Budi Santoso',
            'nip_nim' => '198803102012011003',
            'email' => 'spmi.staf1@polije.ac.id',
            'password' => $defaultPassword,
            'unit_kerja_id' => $pusjanmut->id,
            'status' => 'aktif',
        ]);
        $adminSpmi2->assignRole('admin_spmi');

        // ── Pimpinan ──
        $direktur = User::create([
            'nama' => 'Drs. Kusno, M.T., Ph.D.',
            'nip_nim' => '196805151992011001',
            'email' => 'direktur@polije.ac.id',
            'password' => $defaultPassword,
            'status' => 'aktif',
        ]);
        $direktur->assignRole('pimpinan');

        $wadir1 = User::create([
            'nama' => 'Dr. Eng. Siti Nurhaliza, S.T., M.T.',
            'nip_nim' => '197508201998012001',
            'email' => 'wadir1@polije.ac.id',
            'password' => $defaultPassword,
            'status' => 'aktif',
        ]);
        $wadir1->assignRole('pimpinan');

        $wadir2 = User::create([
            'nama' => 'Ahmad Fauzi, S.Pi., M.Si.',
            'nip_nim' => '197603011999011001',
            'email' => 'wadir2@polije.ac.id',
            'password' => $defaultPassword,
            'status' => 'aktif',
        ]);
        $wadir2->assignRole('pimpinan');

        // ── Auditors ──
        $auditor1 = User::create([
            'nama' => 'Dewi Kartika Sari',
            'nip_nim' => '198206152008012001',
            'email' => 'auditor1@polije.ac.id',
            'password' => $defaultPassword,
            'unit_kerja_id' => $pusjanmut->id,
            'status' => 'aktif',
        ]);
        $auditor1->assignRole('auditor');

        $auditor2 = User::create([
            'nama' => 'Hendra Wijaya',
            'nip_nim' => '198309202009011001',
            'email' => 'auditor2@polije.ac.id',
            'password' => $defaultPassword,
            'unit_kerja_id' => $pusjanmut->id,
            'status' => 'aktif',
        ]);
        $auditor2->assignRole('auditor');

        $auditor3 = User::create([
            'nama' => 'Eko Prasetyo',
            'nip_nim' => '198401102010011001',
            'email' => 'auditor3@polije.ac.id',
            'password' => $defaultPassword,
            'unit_kerja_id' => $pusjanmut->id,
            'status' => 'aktif',
        ]);
        $auditor3->assignRole('auditor');

        $auditorKetua = User::create([
            'nama' => 'Dr. Surya Agus Hidayat, S.T., M.T.',
            'nip_nim' => '197205051997011001',
            'email' => 'auditor.ketua@polije.ac.id',
            'password' => $defaultPassword,
            'unit_kerja_id' => $pusjanmut->id,
            'status' => 'aktif',
        ]);
        $auditorKetua->assignRole('auditor_ketua');

        // ── Ketua Jurusan (one per jurusan) ──
        $kajurData = [
            'JPP' => ['nama' => 'Ir. Wahyu Supriyadi, M.P.', 'nip' => '197001151995011001', 'email' => 'kajur.jpp@polije.ac.id'],
            'JTP' => ['nama' => 'Dr. Eng. Agus Dharma, S.T., M.T.', 'nip' => '197203201996011001', 'email' => 'kajur.jtp@polije.ac.id'],
            'JPTN' => ['nama' => 'Dr. Ir. Nanik Triatuti, M.P.', 'nip' => '197106101996012001', 'email' => 'kajur.jptn@polije.ac.id'],
            'JMA' => ['nama' => 'Ir. Hadi Sumardjo, M.M.', 'nip' => '197305101997011001', 'email' => 'kajur.jma@polije.ac.id'],
            'JTI' => ['nama' => 'Dr. Eng. Budi Hartono, S.Kom., M.Kom.', 'nip' => '197508151998011001', 'email' => 'kajur.jti@polije.ac.id'],
            'JBKP' => ['nama' => 'Dra. Sri Mulyani, M.Hum.', 'nip' => '197402101997012001', 'email' => 'kajur.jbkp@polije.ac.id'],
            'JKS' => ['nama' => 'Ns. Dwi Rahayu, S.Kep., M.Kep.', 'nip' => '197605201999012001', 'email' => 'kajur.jks@polije.ac.id'],
            'JTK' => ['nama' => 'Ir. Joko Susilo, M.T.', 'nip' => '197108151996011001', 'email' => 'kajur.jtk@polije.ac.id'],
            'JBIS' => ['nama' => 'Dr. Sri Wahyuni, S.E., M.M.', 'nip' => '197401101998012001', 'email' => 'kajur.jbis@polije.ac.id'],
        ];

        $kajurUsers = [];
        foreach ($kajurData as $kode => $data) {
            $jurusan = FakultasJurusan::where('kode_jurusan', $kode)->first();
            $user = User::create([
                'nama' => $data['nama'],
                'nip_nim' => $data['nip'],
                'email' => $data['email'],
                'password' => $defaultPassword,
                'jurusan_id' => $jurusan->id,
                'status' => 'aktif',
            ]);
            $user->assignRole('kajur');
            $kajurUsers[$kode] = $user;
        }

        // ── Kaprodi (one per prodi) ──
        $kaprodiNames = [
            'HOR' => 'Ir. Ani Wijayati, M.P.',
            'PKB' => 'Drs. Kusuma Adi, M.P.',
            'BTP' => 'Ir. Darmawan Setiawan, M.P.',
            'TPB' => 'Dr. Rini Solihah, S.P., M.P.',
            'TPTP' => 'Ir. Joko Prasetyo, M.P.',
            'PPK' => 'Andi Cahyono, S.P., M.P.',
            'TIP' => 'Dr. Eng. Maya Indriani, S.T., M.T.',
            'KTP' => 'Ir. Sugeng Riyadi, M.T.',
            'TRP' => 'Dr. Eng. Rudi Hermawan, S.T., M.T.',
            'PTK' => 'Dr. Ir. Budi Cahyono, M.P.',
            'MBU' => 'Ir. Siti Nurjanah, S.Pt., M.P.',
            'TPT_Ternak' => 'Andik Prasetyo, S.Pt., M.P.',
            'MAB' => 'Dra. Endang Lestari, M.M.',
            'MAG' => 'Dr. Agus Salim, S.P., M.P.',
            'MI' => 'Rizky Firmansyah, S.Kom., M.Kom.',
            'TK' => 'Dimas Prasetyo, S.T., M.T.',
            'TI' => 'Dr. Eng. Arif Rahman, S.Kom., M.Kom.',
            'TRK' => 'Fajar Nugroho, S.T., M.T.',
            'BIG' => 'Dra. Lilik Suryani, M.Hum.',
            'DP' => 'Made Surya Darmawan, S.Par., M.Par.',
            'MIK' => 'Ns. Rina Marlina, S.Kom., M.Kes.',
            'GZK' => 'Ns. Diana Puspita, S.Gz., M.Gz.',
            'PRK' => 'Ayu Lestari, S.K.M., M.K.M.',
            'TET' => 'Ir. Mohamad Zainuri, M.T.',
            'MO' => 'Agus Setiawan, S.T., M.T.',
            'TRM' => 'Rico Firmansyah, S.T., M.T.',
            'ASP' => 'Dra. Wati Susilawati, M.Acc.',
            'MPI' => 'Dr. Rina Marlina, S.E., M.M.',
            'MAB_BDO' => 'Sugiarto, S.P., M.P.',
            'PMD_BDO' => 'Rika Amalia, S.Sn., M.Sn.',
            'BD_BDO' => 'Fadilah Nurhadi, S.Kom., M.M.',
            'MAB_NGJ' => 'Heri Supriyanto, S.P., M.P.',
            'TI_NGJ' => 'Arif Wibowo, S.Kom., M.Kom.',
            'MAG_SDA' => 'Retno Susilawati, S.P., M.P.',
            'TI_SDA' => 'Yoga Dwi Pamungkas, S.Kom., M.Kom.',
            'MAB_NGW' => ' Slamet Riyadi, S.P., M.P.',
            'MIK_NGW' => 'Putri Anjani, S.K.M., M.K.M.',
            'TRPL_SBR' => 'Yohanes Bala Putra, S.Kom., M.Kom.',
        ];

        $kaprodiUsers = [];
        foreach ($kaprodiNames as $kode => $nama) {
            $prodi = ProgramStudi::where('kode_prodi', $kode)->first();
            if (!$prodi) {
                continue;
            }
            $user = User::create([
                'nama' => $nama,
                'nip_nim' => '197' . rand(0, 9) . '0' . rand(1, 9) . rand(10, 28) . rand(1001, 1231) . rand(1001, 9999),
                'email' => 'kaprodi.' . strtolower($prodi->kode_prodi) . '@polije.ac.id',
                'password' => $defaultPassword,
                'program_studi_id' => $prodi->id,
                'jurusan_id' => $prodi->jurusan_id,
                'status' => 'aktif',
            ]);
            $user->assignRole('kaprodi');
            $kaprodiUsers[$prodi->kode_prodi] = $user;
        }

        // ── GPM (at least 2 per main jurusan) ──
        $gpmData = [
            ['nama' => 'Ratna Dewi', 'jurusan' => 'JPP', 'email' => 'gpm.ratna@polije.ac.id'],
            ['nama' => 'Agung Prabowo', 'jurusan' => 'JPP', 'email' => 'gpm.agung@polije.ac.id'],
            ['nama' => 'Putri Wahyuningrum', 'jurusan' => 'JTP', 'email' => 'gpm.putri@polije.ac.id'],
            ['nama' => 'Hendra Lesmana', 'jurusan' => 'JTP', 'email' => 'gpm.hendra@polije.ac.id'],
            ['nama' => 'Siti Aminah', 'jurusan' => 'JPTN', 'email' => 'gpm.siti@polije.ac.id'],
            ['nama' => 'Rudi Hartono', 'jurusan' => 'JPTN', 'email' => 'gpm.rudi@polije.ac.id'],
            ['nama' => 'Lia Agustina', 'jurusan' => 'JMA', 'email' => 'gpm.lia@polije.ac.id'],
            ['nama' => 'Candra Wijaya', 'jurusan' => 'JMA', 'email' => 'gpm.candra@polije.ac.id'],
            ['nama' => 'Novi Anggraeni', 'jurusan' => 'JTI', 'email' => 'gpm.novi@polije.ac.id'],
            ['nama' => 'Bayu Setiawan', 'jurusan' => 'JTI', 'email' => 'gpm.bayu@polije.ac.id'],
            ['nama' => 'Yuni Rahmawati', 'jurusan' => 'JBKP', 'email' => 'gpm.yuni@polije.ac.id'],
            ['nama' => 'Adi Kurniawan', 'jurusan' => 'JBKP', 'email' => 'gpm.adi@polije.ac.id'],
            ['nama' => 'Mega Permata', 'jurusan' => 'JKS', 'email' => 'gpm.mega@polije.ac.id'],
            ['nama' => 'Firmansyah Adi', 'jurusan' => 'JKS', 'email' => 'gpm.firmansyah@polije.ac.id'],
            ['nama' => 'Dian Kusuma', 'jurusan' => 'JTK', 'email' => 'gpm.dian@polije.ac.id'],
            ['nama' => 'Wahyu Nugroho', 'jurusan' => 'JTK', 'email' => 'gpm.wahyu@polije.ac.id'],
            ['nama' => 'Rina Susanti', 'jurusan' => 'JBIS', 'email' => 'gpm.rina@polije.ac.id'],
            ['nama' => 'Dedi Kurnia', 'jurusan' => 'JBIS', 'email' => 'gpm.dedi@polije.ac.id'],
        ];

        foreach ($gpmData as $gpm) {
            $jurusan = FakultasJurusan::where('kode_jurusan', $gpm['jurusan'])->first();
            $user = User::create([
                'nama' => $gpm['nama'],
                'nip_nim' => '199' . rand(0, 9) . '0' . rand(1, 9) . rand(10, 28) . rand(1001, 1231) . rand(1001, 9999),
                'email' => $gpm['email'],
                'password' => $defaultPassword,
                'jurusan_id' => $jurusan->id,
                'status' => 'aktif',
            ]);
            $user->assignRole('gpm');
        }

        // ── Dosen (realistic names) ──
        $dosenData = [
            ['nama' => 'Dr. Ir. Mohammad Sutoro, M.P.', 'email' => 'dosen.sutoro@polije.ac.id', 'jurusan' => 'JPP'],
            ['nama' => 'Prof. Dr. Ir. Bambang Purwanto, M.Agr.', 'email' => 'dosen.bambang@polije.ac.id', 'jurusan' => 'JTP'],
            ['nama' => 'Dra. Kartini, M.P.', 'email' => 'dosen.kartini@polije.ac.id', 'jurusan' => 'JPTN'],
            ['nama' => 'Ir. Sugiarto, M.M.', 'email' => 'dosen.sugiarto@polije.ac.id', 'jurusan' => 'JMA'],
            ['nama' => 'Dr. Rudi Hartono, S.Kom., M.Kom.', 'email' => 'dosen.rudi@polije.ac.id', 'jurusan' => 'JTI'],
            ['nama' => 'Maria Ulfa, S.Pd., M.Hum.', 'email' => 'dosen.maria@polije.ac.id', 'jurusan' => 'JBKP'],
            ['nama' => 'Ns. Andriani Putri, S.Kep., M.Kep.', 'email' => 'dosen.andriani@polije.ac.id', 'jurusan' => 'JKS'],
            ['nama' => 'Ir. Heri Purnomo, M.T.', 'email' => 'dosen.heri@polije.ac.id', 'jurusan' => 'JTK'],
            ['nama' => 'Dewi Anggraeni, S.E., M.M.', 'email' => 'dosen.dewi@polije.ac.id', 'jurusan' => 'JBIS'],
            ['nama' => 'Cahyo Wibowo, S.T., M.T.', 'email' => 'dosen.cahyo@polije.ac.id', 'jurusan' => 'JTI'],
        ];

        foreach ($dosenData as $dosen) {
            $jurusan = FakultasJurusan::where('kode_jurusan', $dosen['jurusan'])->first();
            $user = User::create([
                'nama' => $dosen['nama'],
                'nip_nim' => '198' . rand(0, 9) . '0' . rand(1, 9) . rand(10, 28) . rand(1001, 1231) . rand(1001, 9999),
                'email' => $dosen['email'],
                'password' => $defaultPassword,
                'jurusan_id' => $jurusan->id,
                'status' => 'aktif',
            ]);
            $user->assignRole('dosen');
        }

        // ── Tendik ──
        $biroAka = UnitKerja::where('nama_unit', 'Biro Administrasi Akademik')->first();
        $biroUmum = UnitKerja::where('nama_unit', 'Biro Administrasi Umum dan Keuangan')->first();
        $perpus = UnitKerja::where('nama_unit', 'Perpustakaan')->first();
        $uptBahasa = UnitKerja::where('nama_unit', 'UPT Bahasa')->first();
        $uptTik = UnitKerja::where('nama_unit', 'UPT TIK')->first();

        $tendikData = [
            ['nama' => 'Sri Wahyuni', 'email' => 'tendik.sri@polije.ac.id', 'unit_id' => $biroAka->id],
            ['nama' => 'Agus Riyanto', 'email' => 'tendik.agus@polije.ac.id', 'unit_id' => $biroUmum->id],
            ['nama' => 'Novita Sari', 'email' => 'tendik.novita@polije.ac.id', 'unit_id' => $perpus->id],
            ['nama' => 'Dwi Rahmawati', 'email' => 'tendik.dwi@polije.ac.id', 'unit_id' => $uptBahasa->id],
            ['nama' => 'Ahmad Syaifuddin', 'email' => 'tendik.ahmad@polije.ac.id', 'unit_id' => $uptTik->id],
        ];

        foreach ($tendikData as $tendik) {
            $user = User::create([
                'nama' => $tendik['nama'],
                'nip_nim' => '199' . rand(0, 9) . '0' . rand(1, 9) . rand(10, 28) . rand(1001, 1231) . rand(1001, 9999),
                'email' => $tendik['email'],
                'password' => $defaultPassword,
                'unit_kerja_id' => $tendik['unit_id'],
                'status' => 'aktif',
            ]);
            $user->assignRole('tendik');
        }

        // ── Mahasiswa ──
        $prodiTI = ProgramStudi::where('kode_prodi', 'TI')->first();
        $prodiMI = ProgramStudi::where('kode_prodi', 'MI')->first();
        $prodiMAG = ProgramStudi::where('kode_prodi', 'MAG')->first();
        $prodiASP = ProgramStudi::where('kode_prodi', 'ASP')->first();
        $prodiTIP = ProgramStudi::where('kode_prodi', 'TIP')->first();
        $prodiHOR = ProgramStudi::where('kode_prodi', 'HOR')->first();

        $mahasiswaData = [
            ['nama' => 'Rizki Pratama', 'nim' => '1841010001', 'email' => 'mahasiswa.rizki@polije.ac.id', 'prodi_id' => $prodiTI->id],
            ['nama' => 'Ayuningtyas Dwi Putri', 'nim' => '1841010002', 'email' => 'mahasiswa.ayu@polije.ac.id', 'prodi_id' => $prodiTI->id],
            ['nama' => 'Fadil Mubarok', 'nim' => '1842010001', 'email' => 'mahasiswa.fadil@polije.ac.id', 'prodi_id' => $prodiMI->id],
            ['nama' => 'Salsabila Nur Aini', 'nim' => '1843010001', 'email' => 'mahasiswa.salsa@polije.ac.id', 'prodi_id' => $prodiMAG->id],
            ['nama' => 'Muhammad Ali Zainuri', 'nim' => '1844010001', 'email' => 'mahasiswa.ali@polije.ac.id', 'prodi_id' => $prodiASP->id],
            ['nama' => 'Putri Ayu Lestari', 'nim' => '1845010001', 'email' => 'mahasiswa.putri@polije.ac.id', 'prodi_id' => $prodiTIP->id],
            ['nama' => 'Aditya Nugraha Putra', 'nim' => '1846010001', 'email' => 'mahasiswa.adit@polije.ac.id', 'prodi_id' => $prodiHOR->id],
            ['nama' => 'Citra Dewi Anggraini', 'nim' => '1841010003', 'email' => 'mahasiswa.citra@polije.ac.id', 'prodi_id' => $prodiTI->id],
        ];

        foreach ($mahasiswaData as $mhs) {
            $prodi = ProgramStudi::find($mhs['prodi_id']);
            $user = User::create([
                'nama' => $mhs['nama'],
                'nip_nim' => $mhs['nim'],
                'email' => $mhs['email'],
                'password' => $defaultPassword,
                'program_studi_id' => $mhs['prodi_id'],
                'jurusan_id' => $prodi->jurusan_id,
                'status' => 'aktif',
            ]);
            $user->assignRole('mahasiswa');
        }

        // ── Alumni ──
        $alumniData = [
            ['nama' => 'Rizky Aditya Pratama', 'nim' => 'AL2022001', 'email' => 'alumni.rizky@polije.ac.id'],
            ['nama' => 'Nina Sulistiawati', 'nim' => 'AL2022002', 'email' => 'alumni.nina@polije.ac.id'],
            ['nama' => 'Hendra Kurniawan', 'nim' => 'AL2021003', 'email' => 'alumni.hendra@polije.ac.id'],
        ];

        foreach ($alumniData as $alumni) {
            $user = User::create([
                'nama' => $alumni['nama'],
                'nip_nim' => $alumni['nim'],
                'email' => $alumni['email'],
                'password' => $defaultPassword,
                'status' => 'aktif',
            ]);
            $user->assignRole('alumni');
        }

        // ── Mitra Industri ──
        $mitraData = [
            ['nama' => 'PT. Pupuk Kaltim', 'email' => 'mitra.pupuk@pupukkaltim.com'],
            ['nama' => 'PT. Semen Indonesia', 'email' => 'mitra.semen@semenindonesia.com'],
            ['nama' => 'PT. Tirta Mahakam', 'email' => 'mitra.tirta@tirtamahakam.com'],
        ];

        foreach ($mitraData as $mitra) {
            $user = User::create([
                'nama' => $mitra['nama'],
                'email' => $mitra['email'],
                'password' => $defaultPassword,
                'status' => 'aktif',
            ]);
            $user->assignRole('mitra_industri');
        }

        // ── Now update jurusan.prodi with ketua_jurusan_id ──
        foreach ($kajurUsers as $kode => $user) {
            FakultasJurusan::where('kode_jurusan', $kode)->update([
                'ketua_jurusan_id' => $user->id,
            ]);
        }

        // Update kaprodi on prodi
        foreach ($kaprodiUsers as $kode => $user) {
            ProgramStudi::where('kode_prodi', $kode)->update([
                'kaprodi_id' => $user->id,
            ]);
        }
    }
}
