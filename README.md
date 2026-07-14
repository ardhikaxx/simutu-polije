<div align="center">

# SIMUTU POLIJE

### Sistem Informasi Penjaminan Mutu Politeknik Negeri Jember

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

Sistem informasi berbasis web untuk mengelola seluruh siklus penjaminan mutu pendidikan di politeknik, mulai dari perencanaan standar, audit internal, tindak lanjut, hingga pelaporan & evaluasi PPEPP.

[**Live Demo**](#demo) | [**Instalasi**](#instalasi) | [**Dokumentasi**](#dokumentasi-fitur) | [**Kontribusi**](#kontribusi)

</div>

---

## Daftar Isi

- [Tentang](#tentang)
- [Fitur Utama](#fitur-utama)
- [Modul Sistem](#modul-sistem)
- [Role & Hak Akses](#role--hak-akses)
- [Arsitektur Sistem](#arsitektur-sistem)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Instalasi](#instalasi)
- [Struktur Database](#struktur-database)
- [Screenshots](#screenshots)
- [Kontribusi](#kontribusi)
- [License](#license)

---

## Tentang

**SIMUTU POLIJE** (Sistem Informasi Penjaminan Mutu Politeknik Negeri Jember) adalah aplikasi web open-source yang dibangun untuk mendukung pelaksanaan sistem penjaminan mutu pendidikan di lingkungan politeknik. Sistem ini mengotomatiskan seluruh siklus **Plan-Do-Check-Act (PDCA)** dalam kerangka **PPEPP** (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, Peningkatan) sesuai standar **ISO 9001:2015** dan **BAN-PT** / **LAM Teknik**.

### Mengapa SIMUTU?

- **All-in-one**: Satu platform untuk semua kebutuhan penjaminan mutu
- **Role-based access control (RBAC)**: 13 role dengan hak akses granular
- **Multi-campus**: Mendukung beberapa lokasi kampus (PSDKU)
- **Audit trail lengkap**: Setiap aktivitas tercatat secara otomatis
- **Open-source**: Gratis dan dapat dikembangkan sesuai kebutuhan

---

## Fitur Utama

### Master Data
- Manajemen **Fakultas & Jurusan**
- Manajemen **Program Studi** (D3, D4, S2 Terapan)
- Manajemen **Unit Kerja** (Akademik, Non-Akademik, Penunjang)
- Manajemen **Tahun Akademik** (Ganjil/Genap) dengan status aktif
- Manajemen **Periode Audit**

### Standar Mutu
- CRUD Standar Mutu lengkap (create, read, update, delete)
- Sistem **versi otomatis** untuk setiap perubahan standar
- **Alur approve**: Draft &rarr; Submit &rarr; Review &rarr; Approved &rarr; Published
- Manajemen **Indikator Mutu** per standar
- Penetapan **Target Indikator** per tahun akademik
- Pencatatan **Capaian Indikator** dengan status warna (hijau/kuning/merah)

### Dokumen Mutu
- Upload dan versi dokumen mutu pendukung
- Sistem approval workflow untuk dokumen
- Versioning otomatis
- Status: Draft &rarr; Submitted &rarr; Reviewed &rarr; Approved &rarr; Published

### PPEPP (Penetapan, Pelaksanaan, Evaluasi, Pengendalian, Peningkatan)
- Siklus PPEPP per standar mutu dan tahun akademik
- Pelacakan tahapan: Penetapan &rarr; Pelaksanaan &rarr; Pengendalian &rarr; Evaluasi &rarr; Peningkatan
- Monitoring pelaksanaan per program studi / unit kerja
- Upload **eviden** (bukti pelaksanaan)
- Dashboard PPEPP dengan progress bar

### Audit Internal
- Penjadwalan audit (Reguler & Khusus)
- Penetapan **tim audit** dengan pembagian peran
- **Checklist audit** berbasis template
- Pengisian **hasil audit** dengan skor
- Pencatatan **temuan audit** (Observasi, Minor, Mayor) dengan tingkat risiko
- Approval hasil audit

### Tindak Lanjut
- Pembuatan rencana tindak lanjut dari temuan audit
- Pelaporan progress tindak lanjut dengan upload bukti
- Verifikasi progress (Diterima / Ditolak)
- Status tracking: Open &rarr; On Progress &rarr; Need Revision &rarr; Verified &rarr; Closed

### Survei Kepuasan
- Pembuatan survei dengan berbagai tipe jawaban (Skala Likert, Pilihan Ganda, Esai)
- Survei untuk mahasiswa, dosen, alumni, mitra industri, tendik
- Pengisian survei oleh responden
- Dashboard hasil survei dengan statistik

### Laporan
- Laporan capaian indikator mutu
- Laporan hasil audit
- Laporan PPEPP per siklus
- Export ke **PDF** dan **Excel**
- **Export Semua Data** (seluruh standar + capaian sekaligus)

### Template Dokumen Mutu
- Koleksi **13 template PDF** per standar mutu
- Filter by standar + pencarian
- Download template dengan panduan pengisian
- Hitungan download counter

### Dashboard Interaktif
- **Dashboard Super Admin**: Line chart tren capaian, radar chart per standar, doughnut PPEPP, bar chart tindak lanjut (data real dari DB)
- **Dashboard Pimpinan (Executive Summary)**: Radar capaian vs target, tren 3 tahun, alert merah untuk standar di bawah target, ringkasan eksekutif
- Semua chart menggunakan data real dari database

### Riwayat Revisi Dokumen
- Timeline visual perubahan versi dokumen
- Form tambah revisi baru dengan catatan
- Versi otomatis naik 0.1
- Tracking siapa, kapan, dan apa yang berubah

### Tracking Aktivitas User
- Timeline aktivitas seluruh user di sistem
- Filter by user + pencarian
- Detail modul yang diakses dan data yang diubah

### Konfirmasi Sebelum Aksi
- SweetAlert2 otomatis untuk submit, review, approve, publish, delete, revisi
- Mencegah kesalahan klik pada aksi penting

### Shortcut Akses Cepat
- Tombol shortcut di dashboard untuk akses halaman sering diakses
- Standar baru, dokumen baru, template, jadwal audit, tindak lanjut, laporan, kelola user, aktivitas

### Notifikasi
- Notifikasi real-time untuk tugas yang menunggu
- Tandai sudah dibaca / tandai semua sudah dibaca
- Badge notifikasi unread di sidebar

### Admin & Pengaturan
- Manajemen **User** (CRUD lengkap dengan role assignment)
- Manajemen **Role & Permission** (Spatie)
- **Activity Log** (setiap aksi tercatat)
- Pengaturan aplikasi

---

## Modul Sistem

| No | Modul | Deskripsi |
|----|-------|-----------|
| 1 | **Dashboard** | Ringkasan statistik per role (13 dashboard berbeda, chart interaktif) |
| 2 | **Master Data** | Kelola jurusan, prodi, unit kerja, tahun akademik, periode audit |
| 3 | **Standar Mutu** | Kelola standar, indikator, target, capaian indikator |
| 4 | **Dokumen Mutu** | Kelola dokumen pendukung dengan versioning, approval & riwayat revisi |
| 5 | **Template Dokumen** | Download template PDF per standar mutu dengan panduan pengisian |
| 6 | **PPEPP** | Siklus PPEPP, pelaksanaan, eviden, evaluasi |
| 7 | **Jadwal Audit** | Penjadwalan & penugasan tim audit |
| 8 | **Hasil Audit** | Checklist, skor, temuan audit |
| 9 | **Tindak Lanjut** | Progress, verifikasi, tracking status temuan |
| 10 | **Survei** | Buat, isi, dan lihat hasil survei kepuasan |
| 11 | **Laporan** | Capaian indikator, audit, PPEPP + export PDF/Excel + export semua data |
| 12 | **Notifikasi** | Notifikasi tugas dan aktivitas |
| 13 | **Admin** | User, Role, Activity Log, Tracking Aktivitas, Pengaturan |
| 14 | **Profil** | Edit profil & ganti password |

---

## Role & Hak Akses

Sistem ini memiliki **13 role** dengan hak akses yang berbeda:

| No | Role | Deskripsi | Akses Utama |
|----|------|-----------|-------------|
| 1 | **Super Admin** | Administrator sistem penuh | Semua menu, user management, pengaturan |
| 2 | **Admin SPMI** | Admin Sistem Penjaminan Mutu Internal | Kelola standar, dokumen, audit, tindak lanjut |
| 3 | **Kajur** (Kepala Jurusan) | Kepala jurusan/program studi | Lihat standar jurusan, approve dokumen, laporan |
| 4 | **Kaprodi** (Kepala Prodi) | Kepala program studi | Kelola pelaksanaan PPEPP prodi, eviden |
| 5 | **GPM** (Gerakan Peningkatan Mutu) | Tim peningkatan mutu | Isi checklist audit, kelola temuan |
| 6 | **Auditor** | Auditor internal | Isi checklist, input temuan audit |
| 7 | **Auditor Ketua** | Ketua tim auditor | Semua akses auditor + approve hasil audit |
| 8 | **Dosen** | Dosen pengajar | Isi survei, lihat dashboard |
| 9 | **Tendik** | Tenaga kependidikan | Isi survei, lihat dashboard |
| 10 | **Pimpinan** | Pimpinan institusi (Direktur/Wadir) | Dashboard, laporan, approve strategis |
| 11 | **Mahasiswa** | Mahasiswa aktif | Isi survei kepuasan |
| 12 | **Alumni** | Lulusan institusi | Isi survei kepuasan |
| 13 | **Mitra Industri** | Partner industri | Isi survei kepuasan |

### Permission Matrix

| Modul | Super Admin | Admin SPMI | Kajur | Kaprodi | Auditor | Dosen | Mahasiswa |
|-------|:-----------:|:----------:|:-----:|:-------:|:-------:|:-----:|:---------:|
| Dashboard | V | V | V | V | V | V | V |
| Master Data | V | V | - | - | - | - | - |
| Standar Mutu | V | V | V | V | V | - | - |
| Dokumen Mutu | V | V | V | V | - | - | - |
| Template Dokumen | V | V | V | V | V | V | V |
| PPEPP | V | V | V | V | - | - | - |
| Jadwal Audit | V | V | V | - | V | - | - |
| Hasil Audit | V | V | V | - | V | - | - |
| Tindak Lanjut | V | V | V | V | V | - | - |
| Survei | V | V | V | V | - | V | V |
| Laporan | V | V | V | V | V | V | - |
| Tracking Aktivitas | V | V | - | - | - | - | - |
| Admin | V | - | - | - | - | - | - |

---

## Arsitektur Sistem

```
┌─────────────────────────────────────────────────────┐
│                    SIMUTU POLIJE                     │
├─────────────────────────────────────────────────────┤
│  Frontend: Bootstrap 5.3 + Blade Templates          │
│  Backend:  Laravel 12 (MVC Pattern)                 │
│  Database: MySQL 8                                   │
│  Auth:     Laravel Auth + Spatie Permission          │
│  Logging:  Spatie Activity Log                       │
│  Charts:   Chart.js                                 │
│  Tables:   DataTables                                │
│  Alerts:   SweetAlert2                               │
└─────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────┐
│                   SIKLUS PDCA                        │
│                                                      │
│  ┌──────────┐   ┌──────────┐   ┌──────────┐        │
│  │  PLAN    │──▶│   DO     │──▶│  CHECK   │        │
│  │ Standar  │   │ Pelaksa- │   │  Audit   │        │
│  │ & Target │   │  naan    │   │ & Hasil  │        │
│  └──────────┘   └──────────┘   └────┬─────┘        │
│       ▲                              │               │
│       │         ┌──────────┐         │               │
│       └─────────│   ACT    │◀────────┘               │
│                 │ Tindak   │                         │
│                 │ Lanjut   │                         │
│                 └──────────┘                         │
└─────────────────────────────────────────────────────┘
```

---

## Teknologi yang Digunakan

| Komponen | Teknologi | Versi |
|----------|-----------|-------|
| Backend Framework | Laravel | 12.x |
| Programming Language | PHP | 8.2 |
| Frontend Framework | Bootstrap | 5.3 |
| Database | MySQL | 8.x |
| CSS Icons | Font Awesome | 6.x |
| Charts | Chart.js | 4.x |
| Data Tables | DataTables | 1.13 |
| Alert | SweetAlert2 | 11.x |
| RBAC | Spatie Laravel Permission | 6.x |
| Activity Log | Spatie Activity Log | 4.x |
| JS Library | jQuery | 3.x |

---

## Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (opsional, untuk asset compilation)
- XAMPP / Laragon / Docker (atau environment sejenis)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/ardhikaxx/simutu-polije.git
cd simutu-polije

# 2. Install dependencies PHP
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di file .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=simutu_polije
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Buat database
mysql -u root -e "CREATE DATABASE simutu_polije CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 7. Jalankan migrasi & seed data
php artisan migrate:fresh --seed

# 8. Buat storage link
php artisan storage:link

# 9. Jalankan aplikasi
php artisan serve
```

Aplikasi akan berjalan di **http://localhost:8000**

### Akun Test

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@polije.ac.id | password |
| Admin SPMI | admin.spmi@polije.ac.id | password |
| Kajur | kajur.tif@polije.ac.id | password |
| Kaprodi | kaprodi.tik@polije.ac.id | password |
| Auditor | auditor@polije.ac.id | password |
| Auditor Ketua | auditor.ketua@polije.ac.id | password |
| Dosen | dosen@polije.ac.id | password |
| Mahasiswa | mahasiswa@polije.ac.id | password |

> Semua password: `password`

---

## Struktur Database

Sistem ini menggunakan **38+ tabel** dengan struktur relasi yang terintegrasi:

```
fakultas_jurusan ──┬── program_studi ──┬── jadwal_audit ──┬── tim_audit
                   │                   │                  ├── hasil_audit ──┬── hasil_audit_detail
                   │                   │                  │                 └── temuan_audit ── tindak_lanjut
                   │                   │                  │
                   │                   │                  └── tindak_lanjut_temuan ── tindak_lanjut_progress
                   │                   │
                   │                   └── ppepp_pelaksanaan ── eviden
                   │
                   └── unit_kerja

standar_mutu ──┬── standar_mutu_versions
               ├── indikator_mutu ── target_indikator
               ├── capaian_indikator
               └── ppepp_siklus ──┬── ppepp_pelaksanaan
                                  └── ppepp_evaluasi

dokumen_mutu ── dokumen_mutu_versions

survei ──┬── pertanyaan_survei
         └── jawaban_survei

users ──┬── roles (spatie)
        ├── model_has_roles
        └── activity_log
```

---

## Screenshots

<details>
<summary><b>Dashboard Super Admin</b></summary>

- Statistik total user, standar mutu aktif, dokumen, audit berjalan
- Grafik monitoring real-time

</details>

<details>
<summary><b>Manajemen Standar Mutu</b></summary>

- Daftar standar dengan status & versi
- Form create/edit dengan alur approval

</details>

<details>
<summary><b>Jadwal Audit</b></summary>

- Penjadwalan audit per periode
- Penetapan tim audit

</details>

<details>
<summary><b>PPEPP Dashboard</b></summary>

- Progress siklus PPEPP per standar
- Monitoring pelaksanaan per prodi

</details>

---

## Demo

> Untuk mencoba demo, jalankan instalasi di atas dan gunakan akun test yang tersedia.
> Super Admin memiliki akses penuh ke semua fitur.

---

## Kontribusi

Kontribusi sangat dipersilakan! Berikut cara berkontribusi:

1. **Fork** repository ini
2. Buat branch baru (`git checkout -b feature/fitur-baru`)
3. Commit perubahan (`git commit -m 'feat: tambah fitur baru'`)
4. Push ke branch (`git push origin feature/fitur-baru`)
5. Buka **Pull Request**

### Pedoman Commit

Gunakan [Conventional Commits](https://www.conventionalcommits.org/):

| Tipe | Deskripsi |
|------|-----------|
| `feat:` | Fitur baru |
| `fix:` | Perbaikan bug |
| `docs:` | Perubahan dokumentasi |
| `style:` | Format kode (tidak mempengaruhi logika) |
| `refactor:` | Refaktorasi kode |
| `test:` | Menambah test |
| `chore:` | Maintenance |

---

## Author

**ardhikaxx** - [GitHub](https://github.com/ardhikaxx)

---

## License

MIT License - Lihat file [LICENSE](LICENSE) untuk informasi lebih lanjut.

---

<div align="center">

**SIMUTU POLIJE** dibangun untuk kemajuan penjaminan mutu pendidikan di Indonesia.

Jika project ini bermanfaat, berikan **Star** :star: di GitHub!

</div>
