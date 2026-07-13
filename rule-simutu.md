# RULE-SIMPI.MD
## Blueprint Arsitektur Sistem — SIMUTU POLIJE
### Sistem Informasi Penjaminan Mutu Politeknik Negeri Jember (Integrated Internal Quality Assurance Management System)

---

## 1. RINGKASAN EKSEKUTIF

**Nama Aplikasi:** SIMUTU POLIJE (Sistem Informasi Penjaminan Mutu Politeknik Negeri Jember)
**Kelas Sistem:** Integrated Internal Quality Assurance Management System (IQAMS)
**Tujuan:** Menjadi pusat tunggal seluruh siklus Sistem Penjaminan Mutu Internal (SPMI) — mulai dari penetapan standar mutu, pelaksanaan, evaluasi, pengendalian, peningkatan (siklus **PPEPP**), audit mutu internal paperless, tindak lanjut temuan, survei kepuasan pemangku kepentingan, hingga pelaporan yang siap dipakai untuk akreditasi program studi/institusi (BAN-PT/LAM).

**Prinsip Arsitektur Utama:**
1. **Single Source of Truth Database** — satu database pusat, data organisasi (jurusan, prodi, unit kerja, tahun akademik) tidak diinput berulang oleh masing-masing unit.
2. **Role-Aware Dashboard** — begitu login, sistem mengenali jabatan/role pengguna dan menyajikan menu serta dashboard sesuai kewenangan (RBAC granular, bukan sekadar level user biasa/admin).
3. **PPEPP-Centric** — setiap entitas inti (standar, dokumen, indikator, audit) selalu terhubung ke tahap PPEPP yang sedang berjalan pada periode akademik tertentu.
4. **Full Traceability** — versioning dokumen, activity log, dan approval workflow membuat setiap perubahan data memiliki jejak audit yang lengkap.
5. **Paperless Audit** — seluruh proses audit mutu internal (checklist, penilaian, temuan, berita acara, tanda tangan) dilakukan digital.
6. **SSO-Ready** — arsitektur autentikasi disiapkan agar dapat diintegrasikan dengan sistem akademik Polije (SSO) tanpa perombakan besar di kemudian hari.

---

## 2. TECH STACK & DEPENDENSI

| Layer | Teknologi | Catatan |
|---|---|---|
| Backend Framework | **Laravel 12** | PHP 8.3+ |
| Database | **MySQL 8** | InnoDB, utf8mb4 |
| Frontend Styling | **Bootstrap 5** (CDN) | Tanpa build step NPM/Vite |
| Icon | **Font Awesome 6** (CDN) | |
| Alert/Notifikasi UI | **SweetAlert2** (CDN) | Semua alert sukses/gagal/konfirmasi wajib SweetAlert2, tidak boleh pakai `alert()` bawaan browser atau session flash biasa tanpa SweetAlert |
| Chart/Grafik Dashboard | **Chart.js** (CDN) | Untuk seluruh grafik analytics |
| Tabel Data | **DataTables (Bootstrap 5 build)** (CDN) | Server-side processing untuk tabel besar (log aktivitas, daftar dokumen, dsb) |
| Signature Pad | **signature_pad.js** (CDN) | Untuk tanda tangan digital auditor/pimpinan |
| PDF Generator | **barryvdh/laravel-dompdf** (composer) | Laporan PDF |
| Excel Export/Import | **maatwebsite/excel** (composer) | Laporan Excel & import data massal |
| RBAC | **spatie/laravel-permission** (composer) | Role & permission granular |
| Activity Log | **spatie/laravel-activitylog** (composer) | Log seluruh aktivitas user |
| File & Evidence Storage | **spatie/laravel-medialibrary** (composer) | Manajemen file eviden dengan collection & versioning |
| Notifikasi | **Laravel Notification** (built-in: database + mail channel) | |
| Queue | **Laravel Queue (database/redis driver)** | Untuk kirim email & notifikasi async |
| Autentikasi Dasar | **Laravel Breeze / native Auth (server-rendered blade)** | Disiapkan hook SSO (lihat §8.1) |
| Editor Konten Kaya | **CKEditor 5 / TinyMCE** (CDN, opsional) | Untuk isi kebijakan/manual mutu berbasis teks |

**Prinsip:** semua CDN dipasang di `layouts/app.blade.php` sebagai master layout. Tidak ada proses `npm install` / `npm run build`. Seluruh custom CSS ditaruh di `public/css/custom.css`, seluruh custom JS di `public/js/custom.js`, dipanggil manual di layout.

---

## 3. KONSEP DASAR: SIKLUS PPEPP

Seluruh proses mutu di sistem ini mengikuti 5 tahap PPEPP, dan setiap `standar_mutu` pada `periode_akademik` tertentu punya *satu siklus PPEPP* aktif:

| Tahap | Arti | Aktor Utama | Output Data |
|---|---|---|---|
| **P — Penetapan** | Penyusunan & pengesahan standar mutu, indikator, target | Admin SPMI, Pimpinan | `standar_mutu`, `indikator_mutu`, dokumen kebijakan/manual/standar |
| **P — Pelaksanaan** | Implementasi standar oleh unit/prodi, upload eviden | Kaprodi, GPM, Dosen, Tendik | `ppepp_pelaksanaan`, `eviden` |
| **E — Evaluasi** | Perhitungan capaian indikator vs target, evaluasi diri | Sistem (otomatis) + Kaprodi | `capaian_indikator`, status warna (hijau/kuning/merah) |
| **P — Pengendalian** | Audit Mutu Internal, temuan, rekomendasi | Auditor, Auditor Ketua | `hasil_audit`, `temuan_audit` |
| **P — Peningkatan** | Tindak lanjut atas temuan/evaluasi | Kaprodi/unit terkait, dipantau Admin SPMI | `tindak_lanjut_temuan`, `tindak_lanjut_progress` |

**Aturan otomatisasi:** saat `standar_mutu` baru berstatus **Approved/Published**, sistem otomatis men-generate:
- 1 baris `ppepp_siklus` (status awal: Penetapan Selesai)
- Jadwal Pelaksanaan (`ppepp_pelaksanaan` kosong per unit terdampak, dengan due date)
- Jadwal Evaluasi (`jadwal_evaluasi`, biasanya akhir semester)
- Jadwal Audit (`jadwal_audit` draft, menunggu penunjukan auditor oleh Admin SPMI)
- Placeholder Tindak Lanjut (`tindak_lanjut_temuan` baru dibuat setelah ada temuan)

---

## 4. ARSITEKTUR SISTEM TINGKAT TINGGI

```
┌──────────────────────────────────────────────────────────────────┐
│                         SIMUTU POLIJE                             │
│                                                                    │
│  ┌────────────┐   ┌────────────┐   ┌────────────┐   ┌──────────┐ │
│  │   Auth &   │   │   Master   │   │   Modul     │   │  Modul   │ │
│  │    RBAC    │──▶│    Data    │──▶│  Standar &  │──▶│ Dokumen  │ │
│  │  (+ SSO    │   │ (Org, TA,  │   │   Indikator │   │   Mutu   │ │
│  │   hook)    │   │  Periode)  │   │             │   │          │ │
│  └────────────┘   └────────────┘   └────────────┘   └──────────┘ │
│         │                 │                │               │      │
│         ▼                 ▼                ▼               ▼      │
│  ┌─────────────────────────────────────────────────────────────┐ │
│  │              MODUL PPEPP (Orkestrator Siklus Mutu)           │ │
│  └─────────────────────────────────────────────────────────────┘ │
│         │                 │                │               │      │
│         ▼                 ▼                ▼               ▼      │
│  ┌────────────┐   ┌────────────┐   ┌────────────┐   ┌──────────┐ │
│  │   Audit    │   │  Tindak    │   │   Survei   │   │ Evidence │ │
│  │   Mutu     │   │  Lanjut    │   │Terintegrasi│   │Repository│ │
│  │  Internal  │   │  Temuan    │   │            │   │          │ │
│  └────────────┘   └────────────┘   └────────────┘   └──────────┘ │
│         │                 │                │               │      │
│         └────────┬────────┴────────┬───────┴───────────────┘      │
│                   ▼                 ▼                              │
│         ┌────────────────┐  ┌────────────────┐                    │
│         │   Approval      │  │  Notifikasi &  │                    │
│         │   Workflow +    │  │  Activity Log  │                    │
│         │ Digital Signature│  │                │                    │
│         └────────────────┘  └────────────────┘                    │
│                   │                 │                              │
│                   ▼                 ▼                              │
│         ┌──────────────────────────────────┐                      │
│         │  Dashboard Analytics & Laporan    │                      │
│         │  Otomatis (PDF/Excel)             │                      │
│         └──────────────────────────────────┘                      │
└──────────────────────────────────────────────────────────────────┘
```

**Alur data:** Master Data → dipakai bersama (shared) oleh seluruh modul lain via foreign key, tidak ada duplikasi input. Modul PPEPP menjadi "orkestrator" yang menghubungkan Standar Mutu → Pelaksanaan → Evaluasi → Audit → Tindak Lanjut menjadi satu rantai kausal yang bisa ditelusuri ujung ke ujung (traceable dari standar sampai laporan akreditasi).

---

## 5. ROLE & HAK AKSES (RBAC) — DETAIL LENGKAP

Menggunakan `spatie/laravel-permission` dengan model **Role → banyak Permission**, dan setiap user bisa attach ke satu role utama (opsional multi-role untuk kasus dosen yang juga GPM).

### 5.1 Daftar Role

| Kode Role | Nama Role | Scope Data |
|---|---|---|
| `super_admin` | Super Administrator | Seluruh institusi, tanpa batas |
| `admin_spmi` | Admin SPMI / Kepala Pusat Penjaminan Mutu | Seluruh institusi (operasional mutu) |
| `kajur` | Ketua Jurusan | Scope: 1 Jurusan (semua prodi di bawahnya) |
| `kaprodi` | Ketua Program Studi | Scope: 1 Program Studi |
| `gpm` | Gugus Penjaminan Mutu Prodi | Scope: 1 Program Studi (operasional) |
| `auditor` | Auditor Mutu Internal | Scope: unit yang ditugaskan per jadwal audit |
| `auditor_ketua` | Auditor Ketua / Koordinator Audit | Scope: seluruh hasil audit dalam 1 periode audit |
| `dosen` | Dosen | Scope: data diri sendiri |
| `tendik` | Tenaga Kependidikan | Scope: data diri sendiri / unit kerja |
| `pimpinan` | Direktur / Wadir / Senat | Scope: seluruh institusi (read-only monitoring) |
| `mahasiswa` | Mahasiswa | Scope: survei & informasi publik mutu |
| `alumni` | Alumni | Scope: tracer study & survei alumni |
| `mitra_industri` | Mitra Industri / Pengguna Lulusan | Scope: survei pengguna lulusan |

### 5.2 Matriks Hak Akses per Modul

Legenda: **C**=Create, **R**=Read, **U**=Update, **D**=Delete, **A**=Approve, **X**=Full Config, **-**=Tidak ada akses

| Modul | super_admin | admin_spmi | kajur | kaprodi | gpm | auditor | auditor_ketua | dosen | tendik | pimpinan | mahasiswa | alumni | mitra |
|---|---|---|---|---|---|---|---|---|---|---|---|---|---|
| Master Data & Konfigurasi | X | R | - | - | - | - | - | - | - | - | - | - | - |
| Manajemen User & Role | X | R | - | - | - | - | - | - | - | - | - | - | - |
| Standar Mutu | X | CRUD+A | R | R | R | R | R | R | R | R | - | - | - |
| Dokumen Mutu | X | CRUD+A | RU (prodi bawahnya) | CRU | CRU | R | R | R | R | R | - | - | - |
| PPEPP (semua tahap) | X | CRUD+monitor | R+A(prodi) | CRU (prodi sendiri) | CRU | R | R | CU (eviden diri) | CU (eviden diri) | R | - | - | - |
| Audit Mutu Internal | X | CRUD (jadwal, tim) | R (hasil prodi) | R (unit sendiri) | R | CRU (checklist, temuan) | CRU+A (final) | - | - | R | - | - | - |
| Tindak Lanjut Temuan | X | CRUD+monitor | RU (prodi) | CRU (prodi sendiri) | CRU | R+A(verifikasi) | R+A | - | - | R | - | - | - |
| Survei | X | CRUD | R (hasil prodi) | R (hasil prodi) | R | - | - | - | - | R | C (isi survei) | C (isi survei) | C (isi survei) |
| Dashboard Analytics | X | R (seluruh) | R (jurusan) | R (prodi) | R (prodi) | R (audit) | R (audit) | R (diri) | R (diri) | R (seluruh) | - | - | - |
| Laporan Otomatis | X | CRUD | R+cetak (jurusan) | R+cetak (prodi) | R+cetak (prodi) | R+cetak (audit) | R+cetak (audit) | - | - | R+cetak | - | - | - |
| Notifikasi | X | Kirim broadcast | Terima | Terima | Terima | Terima | Terima | Terima | Terima | Terima | Terima | Terima | Terima |
| Activity Log | X (full) | R (log unit) | - | - | - | - | - | - | - | - | - | - | - |
| Digital Signature | X | Tanda tangan dokumen institusi | Tanda tangan dokumen jurusan | Tanda tangan dokumen prodi | - | Tanda tangan hasil audit | Tanda tangan final audit | - | - | Tanda tangan laporan institusi | - | - | - |

> Permission granular disimpan sebagai string format `modul.aksi`, contoh: `standar-mutu.create`, `audit.approve-final`, `dokumen.publish`. Middleware `role_or_permission` dari Spatie dipasang di setiap route group.

### 5.3 Prinsip Scope Data (Data Ownership)

Karena RBAC saja tidak cukup untuk membatasi *data* (bukan cuma *menu*), setiap query di Controller/Service wajib melalui **Global Scope** berbasis kolom `jurusan_id` / `program_studi_id` / `unit_kerja_id` pada tabel-tabel utama, contoh:
- `kaprodi` → hanya bisa lihat/edit row dengan `program_studi_id` = milik prodinya (disimpan di `users.program_studi_id`).
- `kajur` → hanya bisa lihat row dengan `jurusan_id` = jurusannya (query menembus relasi `program_studi.jurusan_id`).
- `auditor` → hanya bisa akses `hasil_audit` di mana dirinya terdaftar sebagai anggota `tim_audit` pada `jadwal_audit_id` terkait.

Implementasi: Trait `HasScopedData` pada model + Laravel Policy per model (`StandarMutuPolicy`, `DokumenMutuPolicy`, `HasilAuditPolicy`, dst.) dipanggil di Controller lewat `$this->authorize()`.

---

## 6. STRUKTUR DATABASE (ERD KONSEPTUAL)

### 6.1 Kelompok: Autentikasi & Organisasi

**`users`**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | |
| nama | varchar | |
| nip_nim | varchar nullable | NIP dosen/tendik atau NIM mahasiswa |
| email | varchar unique | |
| password | varchar nullable | nullable untuk akun SSO |
| sso_external_id | varchar nullable unique | ID dari sistem akademik Polije saat SSO aktif |
| jurusan_id | FK nullable | |
| program_studi_id | FK nullable | |
| unit_kerja_id | FK nullable | |
| status | enum(aktif,nonaktif) | |
| foto_profil | varchar nullable | |
| last_login_at | timestamp nullable | |
| created_at, updated_at | | |

**`roles`, `permissions`, `model_has_roles`, `role_has_permissions`** — standar Spatie Permission.

**`fakultas_jurusan`** (Polije: Jurusan setara Fakultas)
id, nama_jurusan, kode_jurusan, ketua_jurusan_id (FK users), status

**`program_studi`**
id, jurusan_id (FK), nama_prodi, kode_prodi, jenjang (D3/D4/S2Terapan), akreditasi_saat_ini, kaprodi_id (FK users), status

**`unit_kerja`**
id, nama_unit, jenis (Akademik/Non-Akademik/Penunjang), kepala_unit_id (FK users), status

**`tahun_akademik`**
id, nama (contoh "2026/2027"), semester (Ganjil/Genap), tanggal_mulai, tanggal_selesai, is_active

**`periode_audit`**
id, nama, tahun_akademik_id (FK), tanggal_mulai, tanggal_selesai, status (Perencanaan/Berjalan/Selesai)

### 6.2 Kelompok: Standar & Indikator Mutu

**`kategori_standar`** — id, nama (contoh: "Standar Nasional Pendidikan", "Standar Nasional Penelitian", "Standar Tambahan Polije"), urutan

**`standar_mutu`**
id, kategori_standar_id (FK), kode_standar (auto-generate, contoh `STD-DIK-001`), nama_standar, deskripsi, dasar_hukum, unit_terdampak (JSON array unit_kerja_id / program_studi_id), status (Draft/Submitted/Reviewed/Revision Needed/Approved/Published/Archived/Expired), versi_aktif_id (FK ke standar_mutu_versions), dibuat_oleh (FK users), disahkan_oleh (FK users nullable), tanggal_berlaku, created_at

**`standar_mutu_versions`**
id, standar_mutu_id (FK), nomor_versi, konten_lengkap (longtext/JSON), file_pendukung, alasan_revisi, dibuat_oleh, created_at
> Setiap kali `standar_mutu` diedit setelah published, sistem membuat row baru di sini, tidak overwrite versi lama.

**`indikator_mutu`**
id, standar_mutu_id (FK), nama_indikator, definisi_operasional, satuan, formula_perhitungan (text, boleh berisi ekspresi sederhana), sumber_data, frekuensi_pengukuran (Semester/Tahunan), penanggung_jawab_role (enum role), created_at

**`target_indikator`**
id, indikator_mutu_id (FK), tahun_akademik_id (FK), program_studi_id (FK nullable — null berarti target institusi), nilai_target, ambang_kuning (untuk status warning), created_at

**`capaian_indikator`**
id, indikator_mutu_id (FK), tahun_akademik_id (FK), program_studi_id (FK), nilai_capaian, status_warna (enum: hijau,kuning,merah — dihitung otomatis dari target vs ambang), sumber_input (Manual/Otomatis dari modul lain), dihitung_pada, dihitung_oleh

### 6.3 Kelompok: Dokumen Mutu

**`kategori_dokumen`** — id, nama (Kebijakan Mutu, Manual Mutu, Standar Mutu, SOP, Formulir, Instruksi Kerja, Panduan, Dokumen Pendukung), prefix_nomor (untuk auto-numbering, contoh "POL", "MM", "SOP")

**`dokumen_mutu`**
id, kategori_dokumen_id (FK), nomor_dokumen (auto: `{prefix}/{unit}/{tahun}/{urut}`), judul, program_studi_id (FK nullable), unit_kerja_id (FK nullable), standar_mutu_id (FK nullable — dokumen bisa terkait standar tertentu), status (Draft/Submitted/Reviewed/Revision Needed/Approved/Published/Archived/Expired), versi_aktif_id (FK), tanggal_berlaku, tanggal_kedaluwarsa nullable, dibuat_oleh, created_at

**`dokumen_mutu_versions`**
id, dokumen_mutu_id (FK), nomor_versi, file_path, file_size, catatan_revisi, dibuat_oleh, created_at
> File fisik dikelola via `spatie/laravel-medialibrary` (collection: `dokumen-mutu`), tabel ini menyimpan metadata versi & link ke media.

**`dokumen_approval_histories`** (dipakai juga oleh entitas lain via polymorphic — lihat §6.8)

### 6.4 Kelompok: PPEPP

**`ppepp_siklus`**
id, standar_mutu_id (FK), tahun_akademik_id (FK), tahap_sekarang (enum: penetapan,pelaksanaan,evaluasi,pengendalian,peningkatan), status_siklus (Berjalan/Selesai), created_at

**`ppepp_pelaksanaan`**
id, ppepp_siklus_id (FK), program_studi_id (FK nullable), unit_kerja_id (FK nullable), deskripsi_implementasi (text), tanggal_pelaksanaan, status (Belum/Proses/Selesai), diisi_oleh (FK users), created_at

**`eviden`** (polymorphic — bisa menempel ke `ppepp_pelaksanaan`, `indikator_mutu`, `temuan_audit`, dll)
id, eviden_able_type, eviden_able_id, judul, deskripsi, file_path (via medialibrary), tipe_file, diunggah_oleh, created_at

**`ppepp_evaluasi`**
id, ppepp_siklus_id (FK), capaian_indikator_id (FK), catatan_evaluasi, dievaluasi_oleh, created_at

**`ppepp_pengendalian`** — merujuk langsung ke `hasil_audit` (lihat §6.5), tidak duplikasi tabel.

**`ppepp_peningkatan`** — merujuk langsung ke `tindak_lanjut_temuan` (lihat §6.6).

### 6.5 Kelompok: Audit Mutu Internal

**`jadwal_audit`**
id, periode_audit_id (FK), program_studi_id / unit_kerja_id (FK nullable, salah satu wajib diisi), tanggal_audit, jenis_audit (Reguler/Khusus), status (Draft/Terjadwal/Berlangsung/Selesai), dibuat_oleh

**`tim_audit`**
id, jadwal_audit_id (FK), user_id (FK, role auditor/auditor_ketua), peran_dalam_tim (Anggota/Ketua Tim)

**`checklist_audit_template`**
id, nama_template, standar_mutu_id (FK nullable), created_at

**`checklist_audit_item`**
id, checklist_audit_template_id (FK), pertanyaan, bobot_skor, indikator_mutu_id (FK nullable — dikaitkan otomatis ke indikator jika relevan)

**`hasil_audit`**
id, jadwal_audit_id (FK), checklist_audit_template_id (FK), total_skor, kesimpulan (text), status (Draft/Submitted/Reviewed/Approved), berita_acara_file, ditandatangani_oleh (JSON array user_id + timestamp signature), created_at

**`hasil_audit_detail`**
id, hasil_audit_id (FK), checklist_audit_item_id (FK), skor_diberikan, catatan_auditor

**`temuan_audit`**
id, hasil_audit_id (FK), kategori_temuan (Observasi/Minor/Mayor), tingkat_risiko (Rendah/Sedang/Tinggi), deskripsi_temuan, rekomendasi, standar_mutu_id (FK nullable), created_at

### 6.6 Kelompok: Tindak Lanjut

**`tindak_lanjut_temuan`**
id, temuan_audit_id (FK), penanggung_jawab_id (FK users), rencana_tindak_lanjut (text), target_selesai (date), status (Open/On Progress/Need Revision/Verified/Closed), created_at

**`tindak_lanjut_progress`**
id, tindak_lanjut_temuan_id (FK), keterangan_progress, file_bukti, dilaporkan_oleh, diverifikasi_oleh (nullable), status_verifikasi (Pending/Diterima/Ditolak), created_at

### 6.7 Kelompok: Survei

**`jenis_survei`** — id, nama (Kepuasan Mahasiswa, Evaluasi Dosen, Evaluasi Layanan Akademik, Evaluasi Fasilitas, Tracer Study Alumni, Kepuasan Pengguna Lulusan, dll), target_responden (enum role)

**`survei`** — id, jenis_survei_id (FK), judul, tahun_akademik_id (FK), tanggal_mulai, tanggal_selesai, status (Draft/Aktif/Selesai), dibuat_oleh

**`pertanyaan_survei`** — id, survei_id (FK), teks_pertanyaan, tipe_jawaban (skala_likert/pilihan_ganda/esai), urutan

**`jawaban_survei`** — id, survei_id (FK), pertanyaan_survei_id (FK), responden_id (FK users nullable — bisa anonim), nilai_jawaban, teks_jawaban nullable, created_at

**`hasil_survei_agregat`** — id, survei_id (FK), program_studi_id (FK nullable), indeks_kepuasan (decimal, dihitung sistem), jumlah_responden, dihitung_pada
> Dihitung via scheduled job (`php artisan schedule`) setiap kali survei ditutup, atau on-demand.

### 6.8 Kelompok: Approval Workflow, Notifikasi, Log, Signature

**`approval_workflows`** (definisi alur per jenis dokumen)
id, kategori_dokumen_id (FK nullable), nama_alur, urutan_step (JSON: [{"role":"kaprodi","aksi":"submit"}, {"role":"kajur","aksi":"review"}, {"role":"admin_spmi","aksi":"approve"}])

**`approval_histories`** (polymorphic — approvable_type/approvable_id menunjuk ke `dokumen_mutu`, `standar_mutu`, `hasil_audit`, dll)
id, approvable_type, approvable_id, step_ke, actor_id (FK users), aksi (Submit/Review/Revisi/Approve/Reject/Publish), catatan, created_at

**`digital_signatures`**
id, approvable_type, approvable_id (polymorphic — dokumen apa yang ditandatangani), user_id (FK), signature_image_path, ip_address, signed_at

**`notifications`** — tabel bawaan Laravel Notification (id UUID, type, notifiable_type, notifiable_id, data JSON, read_at)

**`activity_logs`** — tabel bawaan `spatie/laravel-activitylog` (log_name, description, subject_type, subject_id, causer_id, properties JSON, created_at)

**`pengaturan_aplikasi`** — key-value store: identitas institusi (nama, logo, alamat), pengaturan email SMTP, pengaturan modul aktif/nonaktif (JSON), pengaturan reminder (H- berapa hari sebelum deadline)

### 6.9 Diagram Relasi Inti (ringkas)

```
tahun_akademik ─┬─▶ target_indikator ─▶ indikator_mutu ─▶ standar_mutu ─▶ kategori_standar
                ├─▶ ppepp_siklus ◀── standar_mutu
                ├─▶ periode_audit ─▶ jadwal_audit ─▶ tim_audit ─▶ users
                └─▶ survei ─▶ pertanyaan_survei ─▶ jawaban_survei

jadwal_audit ─▶ hasil_audit ─▶ hasil_audit_detail ─▶ checklist_audit_item
                            └▶ temuan_audit ─▶ tindak_lanjut_temuan ─▶ tindak_lanjut_progress

dokumen_mutu ─▶ dokumen_mutu_versions
             └▶ approval_histories (polymorphic)
             └▶ digital_signatures (polymorphic)

program_studi ─▶ jurusan_id
users ─▶ jurusan_id / program_studi_id / unit_kerja_id (scope kepemilikan data)
```

---

## 7. MODUL-MODUL SISTEM (DETAIL)

### 7.1 Modul Autentikasi & SSO
- Login form standar (email/NIP/NIM + password) menggunakan session guard Laravel.
- Arsitektur disiapkan dengan **Auth Provider interface** (`App\Services\Auth\AuthProviderInterface`) — implementasi default `LocalAuthProvider`, nanti tinggal tambah `SsoAuthProvider` (OAuth2/SAML sesuai spesifikasi sistem akademik Polije) tanpa mengubah controller login.
- Kolom `users.sso_external_id` sudah disiapkan sejak awal.
- Setelah login sukses → sistem cek role via Spatie → redirect ke dashboard sesuai role (`DashboardRedirectMiddleware`).
- Fitur: lupa password (email reset), ganti password wajib saat pertama login (khusus akun dibuatkan admin), lock akun setelah 5x gagal login.

### 7.2 Modul Master Data / Struktur Organisasi
- CRUD: Jurusan, Program Studi, Unit Kerja, Tahun Akademik, Periode Audit.
- CRUD: Kategori Standar, Kategori Dokumen, Jenis Survei.
- Import massal via Excel (template disediakan, pakai `maatwebsite/excel`).
- Aktivasi/nonaktivasi modul sistem (super_admin) — disimpan di `pengaturan_aplikasi`, dicek via Middleware `CheckModuleActive` di setiap route group modul.

### 7.3 Modul Standar Mutu
- CRUD standar mutu berbasis SN-DIKTI (8 standar pendidikan, 8 penelitian, 8 pengabdian = 24 standar) + standar tambahan institusi (custom).
- Setiap standar → daftar indikator mutu → target per tahun akademik per prodi.
- Versioning otomatis: field diedit setelah `Published` → sistem clone ke `standar_mutu_versions` sebelum overwrite, versi lama tetap bisa dibuka read-only.
- Saat status berubah ke `Published` → trigger **Auto-Generate PPEPP** (lihat §3).

### 7.4 Modul Dokumen Mutu
- Repository terstruktur per kategori: Kebijakan Mutu, Manual Mutu, Standar Mutu, SOP, Formulir, Instruksi Kerja, Panduan, Dokumen Pendukung.
- **Auto Document Numbering**: format dikonfigurasi super_admin, contoh `{prefix_kategori}/{kode_unit}/{tahun}/{nomor_urut_3_digit}` → `SOP/JTI/2026/001`.
- Upload file (PDF/Word/Excel) via medialibrary, maksimal ukuran dikonfigurasi.
- Approval workflow dinamis sesuai `approval_workflows` per kategori dokumen (lihat §7.11).
- Status kedaluwarsa otomatis: job scheduler harian cek `tanggal_kedaluwarsa` → ubah status ke `Expired` + kirim notifikasi ke pemilik dokumen.

### 7.5 Modul PPEPP (Orkestrator)
- Halaman "Siklus PPEPP Saya" (untuk kaprodi/gpm) menampilkan progress bar 5 tahap per standar yang relevan dengan prodinya.
- Tahap Pelaksanaan: form isi implementasi + upload eviden (multi-file).
- Tahap Evaluasi: dihitung otomatis dari `capaian_indikator` vs `target_indikator` → status warna:
  - Hijau: capaian ≥ target
  - Kuning: capaian ≥ ambang_kuning tapi < target
  - Merah: capaian < ambang_kuning
- Tahap Pengendalian & Peningkatan: link langsung ke modul Audit dan Tindak Lanjut (tidak duplikasi UI, cukup ringkasan + tautan).

### 7.6 Modul Audit Mutu Internal (Paperless)
- Admin SPMI membuat `jadwal_audit` per periode, menunjuk `tim_audit` (auditor + auditor ketua).
- Auditor login → dashboard "Tugas Audit Saya" → buka checklist digital (mobile-friendly, bisa diisi dari smartphone/tablet).
- Setiap item checklist diberi skor + catatan; total skor dihitung otomatis (bobot × skor / total bobot).
- Auditor input temuan (kategori: Observasi/Minor/Mayor + tingkat risiko) langsung terhubung ke item checklist relevan.
- Upload bukti audit (foto lapangan, dokumen) via eviden polymorphic.
- Setelah selesai → auditor generate **Berita Acara Audit** (PDF otomatis dari template) → tanda tangan digital (signature_pad) → submit ke Auditor Ketua.
- Auditor Ketua review, bisa gabungkan beberapa hasil audit unit menjadi satu laporan periode → approve final → kirim ke Admin SPMI (trigger notifikasi + generate entri `tindak_lanjut_temuan` otomatis untuk setiap `temuan_audit` yang statusnya Minor/Mayor).

### 7.7 Modul Monitoring Tindak Lanjut
- Setiap `temuan_audit` berstatus Minor/Mayor otomatis membuat 1 baris `tindak_lanjut_temuan` dengan status awal `Open`.
- Kaprodi/penanggung jawab mengisi rencana tindak lanjut + target selesai.
- Progress dilaporkan bertahap (`tindak_lanjut_progress`) dengan bukti, status berubah: Open → On Progress → (diverifikasi auditor) → Verified/Need Revision → Closed.
- **Smart Reminder**: job scheduler harian cek `target_selesai` mendekati (H-7, H-3, H-1) → kirim notifikasi ke penanggung jawab + tembusan Admin SPMI.
- Dashboard persentase penyelesaian per unit/prodi (Closed / Total temuan × 100%).

### 7.8 Modul Survei Terintegrasi
- Builder survei sederhana: Admin SPMI buat `survei`, tambah `pertanyaan_survei` (skala likert 1-5 / pilihan ganda / esai).
- Target responden otomatis sesuai `jenis_survei.target_responden` (mahasiswa/dosen/alumni/mitra/tendik).
- Link survei dikirim via notifikasi in-app + email; mahasiswa/alumni/mitra bisa isi tanpa perlu banyak menu (form sederhana, opsi anonim untuk survei tertentu).
- Hasil dihitung otomatis ke `hasil_survei_agregat`: indeks kepuasan, distribusi jawaban (untuk grafik Chart.js).

### 7.9 Modul Dashboard Analytics
- Widget: capaian indikator (donut/gauge chart per warna), tingkat kepatuhan standar (%), jumlah dokumen per status, jumlah audit terlaksana vs terjadwal, % tindak lanjut closed, skor audit rata-rata per unit, indeks kepuasan survei, tren mutu multi-tahun (line chart).
- Filter global: Tahun Akademik, Jurusan, Program Studi, Periode Audit — filter ini memengaruhi seluruh widget di halaman (AJAX partial reload, tanpa reload penuh).
- Dashboard berbeda per role (lihat §9).

### 7.10 Modul Notifikasi
- Channel: `database` (bell icon in-app, real-time via polling AJAX setiap X detik atau Laravel Echo/WebSocket opsional) + `mail`.
- Event pemicu: audit baru ditugaskan, deadline dokumen mendekati, permintaan revisi dokumen, dokumen disetujui, hasil audit terbit, deadline tindak lanjut mendekati/lewat, survei baru dibuka, pengumuman broadcast dari Admin SPMI.
- Semua notifikasi dicatat di tabel `notifications`, ditampilkan dengan badge unread count.

### 7.11 Modul Approval Workflow
- Status universal (dipakai dokumen, standar mutu, hasil audit): `Draft → Submitted → Reviewed → Revision Needed → Approved → Published → Archived/Expired`.
- Alur approval dikonfigurasi per kategori (`approval_workflows.urutan_step` JSON) — misal dokumen SOP prodi: Kaprodi submit → Kajur review → Admin SPMI approve → Published.
- Setiap transisi status dicatat di `approval_histories` (polymorphic) lengkap dengan catatan & aktor, ditampilkan sebagai timeline vertikal di halaman detail dokumen.

### 7.12 Modul Repository Evidence
- Struktur folder virtual otomatis (bukan folder fisik OS, tapi hierarki di UI): Tahun Akademik → Jurusan → Program Studi → Standar Mutu → Indikator → daftar eviden.
- Search & filter lanjutan: berdasarkan jenis file, tanggal upload, pengunggah, standar terkait.
- Preview file langsung di browser (PDF viewer embed, image preview) tanpa perlu download dulu.

### 7.13 Modul Laporan Otomatis
- Generator laporan: PPEPP per standar/periode, Audit Mutu Internal (lengkap dgn berita acara & rekomendasi), Capaian Indikator, Survei Kepuasan, Evaluasi Diri Prodi, Monitoring Tindak Lanjut, Mutu Tahunan Institusi, Rekapitulasi Dokumen Mutu.
- Semua template laporan konsisten (header identitas Polije, footer nomor halaman & tanggal cetak), export PDF (dompdf) dan Excel (maatwebsite/excel).
- Laporan berat/besar (misal laporan tahunan institusi) di-generate via Queue Job, user diberi notifikasi ketika file siap diunduh (menghindari timeout request).

### 7.14 Modul Activity Log
- Mencatat: login/logout, create/update/delete data penting, transisi approval, download laporan.
- Menggunakan `spatie/laravel-activitylog`, ditampilkan dalam tabel DataTables dengan filter: user, modul, rentang tanggal, jenis aksi.
- Hanya super_admin (full) dan admin_spmi (log unit terkait) yang bisa akses.

### 7.15 Modul Digital Signature
- Menggunakan `signature_pad.js` (canvas tanda tangan) atau upload gambar tanda tangan tersimpan (signature bank per user, agar tidak tanda tangan ulang tiap dokumen).
- Setiap tanda tangan dicatat dengan timestamp + IP address sebagai bukti non-repudiation sederhana (bukan sertifikat digital berbadan hukum PSrE, cukup untuk kebutuhan internal).
- Ditempel otomatis ke PDF hasil generate (dompdf, posisi dikonfigurasi per template).

### 7.16 Modul Pengaturan & Konfigurasi Sistem
- Identitas institusi (nama, logo, alamat, kop surat).
- Pengaturan SMTP email.
- Aktif/nonaktifkan modul.
- Pengaturan reminder (H- berapa hari).
- Manajemen backup database (tombol backup manual + jadwal backup otomatis via `spatie/laravel-backup`, disimpan lokal/cloud sesuai konfigurasi server).
- Placeholder pengaturan Integrasi API/SSO untuk pengembangan lanjutan.

---

## 8. ALUR BISNIS UTAMA (BUSINESS FLOW)

### 8.1 Alur Penetapan Standar Mutu Baru
```
Admin SPMI buat draft Standar Mutu
        │
        ▼
Submit untuk review (status: Submitted)
        │
        ▼
Reviewer internal SPMI (bisa multi-reviewer) beri catatan (Revision Needed) atau lanjut
        │
        ▼
Disahkan Pimpinan/Direktur (tanda tangan digital) → status: Approved
        │
        ▼
Published → Trigger otomatis:
   • Buat ppepp_siklus baru
   • Buat jadwal pelaksanaan per unit terdampak
   • Buat jadwal evaluasi
   • Buat draft jadwal audit
   • Kirim notifikasi ke seluruh unit terdampak
```

### 8.2 Alur Audit Mutu Internal End-to-End
```
Admin SPMI buat Jadwal Audit + tunjuk Tim Audit
        │
        ▼
Notifikasi ke Auditor & Unit yang diaudit
        │
        ▼
Auditor buka checklist digital saat hari-H → isi skor & catatan per item
        │
        ▼
Auditor input Temuan (jika ada) → upload bukti
        │
        ▼
Auditor generate Berita Acara → tanda tangan digital → submit
        │
        ▼
Auditor Ketua review & gabungkan → approve final
        │
        ▼
Kirim ke Admin SPMI → Temuan Minor/Mayor otomatis jadi Tindak Lanjut (status: Open)
        │
        ▼
Notifikasi ke Kaprodi/PIC terkait untuk mengisi rencana tindak lanjut
```

### 8.3 Alur Tindak Lanjut Temuan
```
Temuan (Open) → PIC isi Rencana Tindak Lanjut + Target Selesai (status: On Progress)
        │
        ▼
Sistem kirim reminder H-7 / H-3 / H-1 sebelum target selesai
        │
        ▼
PIC lapor progress + bukti → status: menunggu verifikasi
        │
        ▼
Auditor/Admin SPMI verifikasi:
   • Diterima → status: Verified → Closed
   • Ditolak → status: Need Revision → PIC lapor ulang
```

### 8.4 Alur Approval Dokumen Mutu (contoh SOP Prodi)
```
GPM/Kaprodi buat draft SOP (Draft)
        │
        ▼
Submit (Submitted) → notifikasi ke Kajur
        │
        ▼
Kajur review: Approve lanjut / Revision Needed (kembali ke Draft dgn catatan)
        │
        ▼
Admin SPMI review final: Approve
        │
        ▼
Publish (auto document numbering diterapkan di titik ini) → dokumen aktif & bisa diakses seluruh unit relevan
```

---

## 9. DASHBOARD PER ROLE (RINGKASAN KONTEN)

| Role | Widget Utama Dashboard |
|---|---|
| Super Admin | Statistik pengguna aktif, status seluruh modul, log aktivitas terbaru, kesehatan sistem (storage, queue) |
| Admin SPMI | Progress PPEPP seluruh prodi, status dokumen menunggu approval, jadwal audit mendatang, capaian indikator institusi, notifikasi permintaan validasi |
| Kajur | Peta capaian indikator seluruh prodi di jurusannya (heatmap warna), status dokumen menunggu persetujuannya, ringkasan tindak lanjut jurusan |
| Kaprodi | Progress PPEPP prodi sendiri (5 tahap), daftar eviden yang perlu dilengkapi, status temuan audit & tindak lanjut, deadline terdekat |
| GPM | Checklist tugas operasional mutu, dokumen yang perlu diunggah, status evaluasi diri |
| Auditor | Daftar tugas audit mendatang, checklist yang belum diselesaikan, riwayat audit yang pernah dikerjakan |
| Auditor Ketua | Rekap seluruh hasil audit periode berjalan, status review yang menunggu, statistik temuan per kategori risiko |
| Dosen | Status dokumen pribadi (RPS, BKD, dll) yang diunggah, indikator kinerja individu, notifikasi kekurangan dokumen |
| Tendik | Dokumen administrasi yang perlu diunggah, status validasi, evaluasi layanan yang perlu diisi |
| Pimpinan | Executive dashboard: capaian mutu institusi real-time, tren multi-tahun, tingkat penyelesaian audit & tindak lanjut, perbandingan antar prodi (read-only, filterable) |
| Mahasiswa | Daftar survei aktif yang perlu diisi, hasil survei yang sudah dipublikasikan (agregat, bukan data individu) |
| Alumni | Tracer study aktif, riwayat pengisian survei alumni |
| Mitra Industri | Survei kepuasan pengguna lulusan yang perlu diisi |

---

## 10. STRUKTUR FOLDER LARAVEL PROJECT

```
simutu-polije/
├── app/
│   ├── Console/
│   │   └── Commands/            (GenerateReminderCommand, CalculateSurveyResultCommand, dll)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Admin/           (Super Admin: User, Role, Konfigurasi)
│   │   │   ├── MasterData/      (Jurusan, Prodi, UnitKerja, TahunAkademik, PeriodeAudit)
│   │   │   ├── StandarMutu/
│   │   │   ├── DokumenMutu/
│   │   │   ├── Ppepp/
│   │   │   ├── Audit/           (JadwalAudit, ChecklistAudit, HasilAudit, TemuanAudit)
│   │   │   ├── TindakLanjut/
│   │   │   ├── Survei/
│   │   │   ├── Dashboard/       (per-role dashboard controllers)
│   │   │   ├── Laporan/
│   │   │   └── Notifikasi/
│   │   ├── Middleware/
│   │   │   ├── DashboardRedirectMiddleware.php
│   │   │   ├── CheckModuleActive.php
│   │   │   └── RoleScopeMiddleware.php
│   │   └── Requests/            (Form Request validation per modul)
│   ├── Models/                  (1 model per tabel, sesuai §6)
│   ├── Policies/                 (StandarMutuPolicy, DokumenMutuPolicy, HasilAuditPolicy, dst.)
│   ├── Services/
│   │   ├── Auth/AuthProviderInterface.php + LocalAuthProvider.php
│   │   ├── Ppepp/PpeppOrchestratorService.php   (logika auto-generate siklus)
│   │   ├── Audit/AuditScoringService.php
│   │   ├── Numbering/DocumentNumberingService.php
│   │   ├── Survey/SurveyAggregationService.php
│   │   └── Report/ReportGeneratorService.php
│   ├── Notifications/           (DeadlineReminder, AuditAssigned, DocumentApproved, dll — Laravel Notification classes)
│   └── Observers/                (StandarMutuObserver → trigger PpeppOrchestratorService saat status jadi Published)
├── database/
│   ├── migrations/
│   ├── seeders/                  (RoleSeeder, PermissionSeeder, MasterDataDemoSeeder)
│   └── factories/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php     (master layout: CDN Bootstrap5, FontAwesome6, SweetAlert2, Chart.js)
│       ├── components/           (Blade components: card-stat, modal-confirm, badge-status, timeline-approval)
│       ├── auth/
│       ├── dashboard/            (satu file per role: dashboard-admin-spmi.blade.php, dst.)
│       ├── master-data/
│       ├── standar-mutu/
│       ├── dokumen-mutu/
│       ├── ppepp/
│       ├── audit/
│       ├── tindak-lanjut/
│       ├── survei/
│       └── laporan/
├── routes/
│   └── web.php                   (dikelompokkan per modul dengan route group + middleware role)
├── public/
│   ├── css/custom.css
│   ├── js/custom.js
│   └── assets/logo-polije.png
└── storage/app/public/           (dikelola medialibrary: dokumen-mutu, eviden, tanda-tangan, foto-profil)
```

---

## 11. STRUKTUR ROUTING (RINGKAS)

```php
// routes/web.php (gambaran struktur, bukan kode final)

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::middleware(['role:super_admin'])->prefix('admin')->group(function () {
        // User, Role, Permission, Konfigurasi Aplikasi, Backup
    });

    Route::middleware(['role:super_admin|admin_spmi'])->prefix('master-data')->group(function () {
        // Jurusan, Prodi, Unit Kerja, Tahun Akademik, Periode Audit, Kategori
    });

    Route::middleware(['role:super_admin|admin_spmi|kajur|kaprodi|gpm'])->prefix('standar-mutu')->group(function () {
        // index, create, store, edit, update, versions, publish
    });

    Route::middleware(['permission:dokumen.manage'])->prefix('dokumen-mutu')->group(function () {
        // CRUD + workflow transition endpoints (submit, review, revise, approve, publish)
    });

    Route::prefix('ppepp')->group(function () {
        // siklus, pelaksanaan (upload eviden), evaluasi (read-only, dihitung sistem)
    });

    Route::middleware(['role:admin_spmi|auditor|auditor_ketua'])->prefix('audit')->group(function () {
        // jadwal, checklist, hasil-audit, temuan, berita-acara, tanda-tangan
    });

    Route::prefix('tindak-lanjut')->group(function () {
        // list, update-progress, verifikasi
    });

    Route::prefix('survei')->group(function () {
        // admin: builder survei | responden: isi survei
    });

    Route::prefix('laporan')->group(function () {
        // generate-pdf, generate-excel, riwayat-laporan (queue-based untuk laporan besar)
    });

    Route::prefix('notifikasi')->group(function () {
        // index, mark-as-read, broadcast (admin_spmi only)
    });
});
```

---

## 12. MIDDLEWARE & SECURITY

- **Auth Middleware** — semua route (kecuali landing publik & isi survei via token untuk alumni/mitra tanpa akun) wajib login.
- **Role/Permission Middleware** (`spatie/laravel-permission`) di setiap route group.
- **RoleScopeMiddleware** — custom middleware yang menyuntik scope query (`jurusan_id`/`program_studi_id`) ke Controller berdasarkan role user, dikombinasikan dengan Laravel Policy per aksi (view/update/delete).
- **CheckModuleActive** — cek `pengaturan_aplikasi` sebelum masuk ke route modul tertentu (jika modul dinonaktifkan super_admin, redirect dengan pesan SweetAlert).
- **CSRF Protection** — bawaan Laravel, wajib di semua form.
- **Validasi Input** — Form Request class per aksi, pesan validasi berbahasa Indonesia.
- **File Upload Security** — whitelist ekstensi (pdf, doc, docx, xls, xlsx, jpg, png, mp4 untuk eviden tertentu), maksimal ukuran dikonfigurasi, scan nama file (sanitize) sebelum simpan.
- **Rate Limiting** — login attempt throttle, endpoint isi survei publik (mitra/alumni tanpa akun via token unik per undangan) dibatasi throttle per IP.
- **Audit Trail** — `spatie/laravel-activitylog` mencatat causer + before/after value untuk data sensitif (perubahan role, penghapusan dokumen, dsb).
- **Digital Signature Integrity** — signature disimpan sebagai image + hash sederhana (SHA-256 dari kombinasi user_id + dokumen_id + timestamp) untuk deteksi jika data dokumen berubah setelah ditandatangani.

---

## 13. NOTIFICATION & EMAIL SYSTEM

| Event | Penerima | Channel |
|---|---|---|
| Standar mutu baru dipublikasi | Seluruh unit terdampak | Database + Email |
| Dokumen menunggu approval | Approver step berikutnya | Database + Email |
| Dokumen direvisi | Pembuat dokumen | Database + Email |
| Dokumen dipublikasi | Pembuat + unit terkait | Database |
| Jadwal audit baru ditugaskan | Auditor & unit yang diaudit | Database + Email |
| Hasil audit terbit | Kaprodi/unit terkait | Database + Email |
| Temuan baru → tindak lanjut dibuat | PIC penanggung jawab | Database + Email |
| Reminder deadline tindak lanjut (H-7/H-3/H-1) | PIC + tembusan Admin SPMI | Database + Email |
| Survei baru dibuka | Target responden sesuai jenis survei | Database + Email |
| Pengumuman broadcast Admin SPMI | Role/unit yang dipilih | Database + Email |

Semua job pengiriman email dijalankan lewat **Queue** (`ShouldQueue` interface) agar tidak memperlambat response HTTP. Worker dijalankan via `php artisan queue:work` (supervisor di production).

---

## 14. NON-FUNCTIONAL REQUIREMENTS

- **Bahasa**: seluruh UI, pesan validasi, notifikasi, dan label sistem menggunakan **Bahasa Indonesia**; istilah teknis (Dashboard, Upload, Export, dll) boleh tetap Inggris jika lazim dipakai.
- **Responsif**: seluruh halaman wajib mobile-friendly (Bootstrap 5 grid + breakpoint), khusus modul Audit harus nyaman diisi dari tablet/smartphone di lapangan.
- **Performa**: tabel besar (Activity Log, Dokumen Mutu, Jawaban Survei) wajib pakai server-side DataTables, bukan load semua data ke frontend.
- **Ketersediaan**: backup database otomatis harian (`spatie/laravel-backup`), retensi minimal 30 hari.
- **Skalabilitas**: struktur modul dipisah per domain (bounded context) agar mudah dipecah jadi microservice di kemudian hari bila diperlukan.
- **Aksesibilitas Data untuk Akreditasi**: seluruh laporan evaluasi diri & rekap indikator harus bisa diekspor dalam format yang selaras dengan kebutuhan borang BAN-PT/LAM (terstruktur per standar SN-DIKTI).
- **Auditability**: tidak ada hard delete untuk data yang sudah pernah masuk approval workflow — gunakan `SoftDeletes` + status `Archived` sebagai pengganti hapus permanen.

---

## 15. RENCANA FASE PENGEMBANGAN (ROADMAP)

| Fase | Cakupan |
|---|---|
| **Fase 1 — Fondasi** | Setup Laravel 12, autentikasi lokal, RBAC (Spatie), master data organisasi, layout master (Bootstrap5+FA6+SweetAlert2 CDN), konfigurasi awal Super Admin |
| **Fase 2 — Standar & Dokumen** | Modul Standar Mutu + versioning, Modul Dokumen Mutu + auto numbering + approval workflow dasar, Digital Signature dasar |
| **Fase 3 — PPEPP Core** | Modul PPEPP (Penetapan otomatis, Pelaksanaan + eviden, Evaluasi otomatis dgn status warna) |
| **Fase 4 — Audit Mutu Internal** | Jadwal audit, tim audit, checklist digital, penilaian, temuan, berita acara, tanda tangan digital |
| **Fase 5 — Tindak Lanjut & Reminder** | Modul tindak lanjut + verifikasi + smart reminder (scheduled job) |
| **Fase 6 — Survei Terintegrasi** | Builder survei, pengisian oleh mahasiswa/dosen/alumni/mitra, agregasi hasil |
| **Fase 7 — Dashboard & Laporan** | Dashboard Analytics per role (Chart.js), Laporan Otomatis (PDF/Excel), Activity Log viewer |
| **Fase 8 — Notifikasi & Polish** | Notification system lengkap (database+mail), broadcast pengumuman, QA menyeluruh, hardening security |
| **Fase 9 (opsional, jangka panjang)** | Integrasi SSO dengan sistem akademik Polije, API untuk integrasi eksternal (SATUSEHAT-style interoperability jika relevan ke sistem lain kampus) |

---

## 16. LANGKAH SELANJUTNYA

Dokumen berikutnya yang perlu disusun: **`design-simpi.md`** — berisi:
- Wireframe/mockup tiap dashboard per role
- Detail alur UI (page flow) tiap modul
- Palet warna & tipografi (identitas visual Polije)
- Struktur komponen Blade reusable (card, badge status, timeline approval, modal SweetAlert2 per aksi)
- Spesifikasi tabel DataTables per modul (kolom, filter, aksi)

---

*Dokumen ini adalah blueprint arsitektur awal. Detail teknis (nama kolom pasti, tipe data presisi, index database) dapat disesuaikan saat implementasi migration tanpa mengubah struktur besar yang sudah ditetapkan di sini.*
