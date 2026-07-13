<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Audit\HasilAuditController;
use App\Http\Controllers\Audit\JadwalAuditController;
use App\Http\Controllers\Audit\TemuanAuditController;
use App\Http\Controllers\Dashboard\DashboardRedirectController;
use App\Http\Controllers\DokumenMutu\DokumenMutuController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\MasterData\JurusanController;
use App\Http\Controllers\MasterData\PeriodeAuditController;
use App\Http\Controllers\MasterData\ProgramStudiController;
use App\Http\Controllers\MasterData\TahunAkademikController;
use App\Http\Controllers\MasterData\UnitKerjaController;
use App\Http\Controllers\Notifikasi\NotifikasiController;
use App\Http\Controllers\Ppepp\PpeppController;
use App\Http\Controllers\StandarMutu\IndikatorMutuController;
use App\Http\Controllers\StandarMutu\StandarMutuController;
use App\Http\Controllers\Survei\SurveiController;
use App\Http\Controllers\TindakLanjut\TindakLanjutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register')
    ->middleware('guest');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.store')
    ->middleware('guest');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request')->middleware('guest');

Route::post('/forgot-password', function () {
    return back()->with('success', 'Tautan reset password telah dikirim ke email Anda.');
})->name('password.email')->middleware('guest');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::get('/profile', function () {
        return view('auth.profile');
    })->name('profile.show');

    Route::get('/password/change', function () {
        return view('auth.change-password');
    })->name('password.change');

    Route::get('/notifications/unread-count', function () {
        return response()->json([
            'count' => auth()->user()->unreadNotifications->count(),
        ]);
    })->name('notifications.unread-count');

    Route::prefix('admin')->middleware('role:super_admin')->group(function () {
        Route::get('/users', function () {
            return view('admin.users.index');
        })->name('admin.users.index');

        Route::get('/roles', function () {
            return view('admin.roles.index');
        })->name('admin.roles.index');

        Route::get('/activity-log', function () {
            return view('admin.activity-log.index');
        })->name('admin.activity-log.index');

        Route::get('/settings', function () {
            return view('admin.settings.index');
        })->name('admin.settings.index');
    });

    Route::middleware('role:super_admin|admin_spmi')->prefix('master-data')->name('master-data.')->group(function () {
        Route::resource('jurusan', JurusanController::class)->except(['show']);
        Route::resource('prodi', ProgramStudiController::class)->except(['show']);
        Route::resource('unit-kerja', UnitKerjaController::class)->except(['show']);
        Route::resource('tahun-akademik', TahunAkademikController::class)->except(['show']);
        Route::post('tahun-akademik/{tahunAkademik}/activate', [TahunAkademikController::class, 'activate'])->name('tahun-akademik.activate');
        Route::post('tahun-akademik/{tahunAkademik}/deactivate', [TahunAkademikController::class, 'deactivate'])->name('tahun-akademik.deactivate');
        Route::resource('periode-audit', PeriodeAuditController::class)->except(['show']);
    });

    Route::middleware('role:super_admin|admin_spmi|kajur|kaprodi|gpm|auditor|auditor_ketua|dosen|tendik|pimpinan')->group(function () {
        Route::resource('standar-mutu', StandarMutuController::class);
        Route::post('standar-mutu/{standar}/submit', [StandarMutuController::class, 'submit'])->name('standar-mutu.submit');
        Route::post('standar-mutu/{standar}/review', [StandarMutuController::class, 'review'])->name('standar-mutu.review');
        Route::post('standar-mutu/{standar}/approve', [StandarMutuController::class, 'approve'])->name('standar-mutu.approve');
        Route::post('standar-mutu/{standar}/publish', [StandarMutuController::class, 'publish'])->name('standar-mutu.publish');
        Route::get('standar-mutu/{standar}/versions', [StandarMutuController::class, 'versions'])->name('standar-mutu.versions');
        Route::post('standar-mutu/{standar}/indikator', [IndikatorMutuController::class, 'store'])->name('standar-mutu.indikator.store');
        Route::put('standar-mutu/{standar}/indikator/{indikator}', [IndikatorMutuController::class, 'update'])->name('standar-mutu.indikator.update');
        Route::delete('standar-mutu/{standar}/indikator/{indikator}', [IndikatorMutuController::class, 'destroy'])->name('standar-mutu.indikator.destroy');

        Route::resource('dokumen-mutu', DokumenMutuController::class);
        Route::post('dokumen-mutu/{dokumen}/submit', [DokumenMutuController::class, 'submit'])->name('dokumen-mutu.submit');
        Route::post('dokumen-mutu/{dokumen}/review', [DokumenMutuController::class, 'review'])->name('dokumen-mutu.review');
        Route::post('dokumen-mutu/{dokumen}/approve', [DokumenMutuController::class, 'approve'])->name('dokumen-mutu.approve');
        Route::post('dokumen-mutu/{dokumen}/publish', [DokumenMutuController::class, 'publish'])->name('dokumen-mutu.publish');
        Route::get('dokumen-mutu/{dokumen}/versions', [DokumenMutuController::class, 'versions'])->name('dokumen-mutu.versions');

        Route::get('ppepp/dashboard', [PpeppController::class, 'dashboard'])->name('ppepp.dashboard');
        Route::resource('ppepp', PpeppController::class)->only(['index', 'show']);
        Route::get('ppepp/{siklus}/pelaksanaan', [PpeppController::class, 'pelaksanaan'])->name('ppepp.pelaksanaan');
        Route::put('ppepp/pelaksanaan/{pelaksanaan}', [PpeppController::class, 'updatePelaksanaan'])->name('ppepp.pelaksanaan.update');
        Route::post('ppepp/pelaksanaan/{pelaksanaan}/eviden', [PpeppController::class, 'uploadEviden'])->name('ppepp.eviden.upload');
        Route::get('ppepp/{siklus}/evaluasi', [PpeppController::class, 'evaluasi'])->name('ppepp.evaluasi');
    });

    Route::middleware('role:super_admin|admin_spmi|auditor|auditor_ketua')->group(function () {
        Route::get('audit/hasil', [HasilAuditController::class, 'index'])->name('audit.hasil.index');
        Route::get('audit/hasil/{hasil}', [HasilAuditController::class, 'show'])->name('audit.hasil.show');
        Route::get('audit/{jadwal}/checklist', [HasilAuditController::class, 'checklist'])->name('audit.checklist');
        Route::post('audit/{jadwal}/checklist', [HasilAuditController::class, 'submitChecklist'])->name('audit.checklist.submit');
        Route::post('audit/hasil/{hasil}/approve', [HasilAuditController::class, 'approve'])->name('audit.hasil.approve');
        Route::post('audit/temuan', [TemuanAuditController::class, 'store'])->name('audit.temuan.store');
        Route::put('audit/temuan/{temuan}', [TemuanAuditController::class, 'update'])->name('audit.temuan.update');
        Route::resource('jadwal-audit', JadwalAuditController::class)->except(['edit', 'update']);
        Route::post('jadwal-audit/{jadwal}/assign-team', [JadwalAuditController::class, 'assignTeam'])->name('jadwal-audit.assign-team');
        Route::get('audit', function () {
            return redirect()->route('jadwal-audit.index');
        })->name('audit.index');
    });

    Route::middleware('role:super_admin|admin_spmi|kajur|kaprodi|gpm|auditor|auditor_ketua')->group(function () {
        Route::resource('tindak-lanjut', TindakLanjutController::class)->only(['index', 'show']);
        Route::post('tindak-lanjut/{tl}/progress', [TindakLanjutController::class, 'updateProgress'])->name('tindak-lanjut.progress.update');
        Route::post('tindak-lanjut/progress/{progress}/verify', [TindakLanjutController::class, 'verify'])->name('tindak-lanjut.progress.verify');
    });

    Route::middleware('role:super_admin|admin_spmi|kajur|kaprodi|mahasiswa|alumni|mitra_industri')->group(function () {
        Route::get('survei/{survei}/isi', [SurveiController::class, 'fillForm'])->name('survei.fill');
        Route::post('survei/{survei}/isi', [SurveiController::class, 'submitFill'])->name('survei.fill.submit');
        Route::get('survei/{survei}/hasil', [SurveiController::class, 'hasil'])->name('survei.hasil');
        Route::get('survei/dashboard', [SurveiController::class, 'dashboard'])->name('survei.dashboard');
        Route::resource('survei', SurveiController::class)->only(['index', 'create', 'store']);
    });

    Route::middleware('role:super_admin|admin_spmi|kajur|kaprodi|gpm|auditor|auditor_ketua|pimpinan')->group(function () {
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/ppepp/{siklus}', [LaporanController::class, 'ppepp'])->name('laporan.ppepp');
        Route::get('laporan/audit/{periode}', [LaporanController::class, 'audit'])->name('laporan.audit');
        Route::get('laporan/indikator', [LaporanController::class, 'indikator'])->name('laporan.indikator');
        Route::get('laporan/download-pdf/{type}/{id}', [LaporanController::class, 'downloadPdf'])->name('laporan.download-pdf');
        Route::get('laporan/download-excel/{type}/{id}', [LaporanController::class, 'downloadExcel'])->name('laporan.download-excel');
    });

    Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.mark-read');
    Route::post('notifikasi/read-all', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.mark-all-read');
});
