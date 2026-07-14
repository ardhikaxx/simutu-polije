/**
 * SIMUTU POLIJE - Custom JavaScript
 */

/* ============================================
   Sidebar Toggle
   ============================================ */
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const mainWrapper = document.getElementById('main-wrapper');

    if (sidebarToggle && sidebar && overlay && mainWrapper) {
        sidebarToggle.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainWrapper.classList.toggle('sidebar-collapsed');
            }
        });
    }

    if (sidebarClose && sidebar && overlay) {
        sidebarClose.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    if (overlay && sidebar) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

    // Auto close sidebar on mobile when a navigation link is clicked
    if (sidebar) {
        sidebar.querySelectorAll('.sidebar-nav .nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('show');
                    if (overlay) overlay.classList.remove('show');
                }
            });
        });
    }

    // Close sidebar on mobile when Escape key is pressed
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && window.innerWidth < 992 && sidebar && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            if (overlay) overlay.classList.remove('show');
        }
    });

    // Clean up classes when resizing across breakpoints
    window.addEventListener('resize', debounce(function () {
        if (window.innerWidth >= 992 && sidebar && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            if (overlay) overlay.classList.remove('show');
        } else if (window.innerWidth < 992 && sidebar && sidebar.classList.contains('collapsed')) {
            sidebar.classList.remove('collapsed');
            if (mainWrapper) mainWrapper.classList.remove('sidebar-collapsed');
        }
    }, 150));
});

/* ============================================
   SweetAlert2 Helper Functions
   ============================================ */
const SimutuAlert = {
    success: function (title, text) {
        Swal.fire({
            icon: 'success',
            title: title || 'Berhasil!',
            text: text || '',
            confirmButtonColor: '#1a237e',
            confirmButtonText: 'OK'
        });
    },

    error: function (title, text) {
        Swal.fire({
            icon: 'error',
            title: title || 'Gagal!',
            text: text || '',
            confirmButtonColor: '#1a237e',
            confirmButtonText: 'Tutup'
        });
    },

    warning: function (title, text) {
        Swal.fire({
            icon: 'warning',
            title: title || 'Peringatan!',
            text: text || '',
            confirmButtonColor: '#1a237e',
            confirmButtonText: 'OK'
        });
    },

    info: function (title, text) {
        Swal.fire({
            icon: 'info',
            title: title || 'Informasi',
            text: text || '',
            confirmButtonColor: '#1a237e',
            confirmButtonText: 'OK'
        });
    },

    confirm: function (title, text, callback) {
        Swal.fire({
            title: title || 'Konfirmasi',
            text: text || 'Apakah Anda yakin?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed && typeof callback === 'function') {
                callback();
            }
        });
    },

    confirmDelete: function (callback) {
        Swal.fire({
            title: 'Hapus Data?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53935',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed && typeof callback === 'function') {
                callback();
            }
        });
    },

    confirmWithInput: function (title, inputPlaceholder, callback) {
        Swal.fire({
            title: title || 'Konfirmasi',
            input: 'text',
            inputPlaceholder: inputPlaceholder || 'Masukkan teks...',
            showCancelButton: true,
            confirmButtonColor: '#1a237e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            inputValidator: function (value) {
                if (!value) return 'Field wajib diisi!';
            }
        }).then(function (result) {
            if (result.isConfirmed && typeof callback === 'function') {
                callback(result.value);
            }
        });
    },

    toast: function (icon, title) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: function (toast) {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: icon || 'success',
            title: title || 'Operasi berhasil'
        });
    },

    loading: function (title) {
        Swal.fire({
            title: title || 'Memproses...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: function () {
                Swal.showLoading();
            }
        });
    },

    close: function () {
        Swal.close();
    }
};

/* ============================================
   Notification Polling
   ============================================ */
let notificationPollInterval = null;

function startNotificationPolling(intervalMs) {
    intervalMs = intervalMs || 30000;
    stopNotificationPolling();

    notificationPollInterval = setInterval(function () {
        fetch('/notifications/unread-count', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function (response) {
            if (response.ok) return response.json();
        })
        .then(function (data) {
            if (data && typeof data.count !== 'undefined') {
                updateNotificationBadge(data.count);
            }
        })
        .catch(function () {});
    }, intervalMs);
}

function stopNotificationPolling() {
    if (notificationPollInterval) {
        clearInterval(notificationPollInterval);
        notificationPollInterval = null;
    }
}

function updateNotificationBadge(count) {
    var badge = document.getElementById('notification-badge');
    if (!badge) return;

    if (count > 0) {
        badge.textContent = count > 99 ? '99+' : count;
        badge.classList.remove('d-none');
    } else {
        badge.classList.add('d-none');
    }
}

function initResponsiveTables() {
    document.querySelectorAll('.content-wrapper table.table, .modal-body table.table').forEach(function (table) {
        if (!table.parentElement.classList.contains('table-responsive') &&
            !table.parentElement.classList.contains('dataTables_scrollBody') &&
            !table.parentElement.classList.contains('dataTables_wrapper')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'table-responsive w-100 overflow-x-auto';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    startNotificationPolling(30000);
    initResponsiveTables();
});

/* ============================================
   DataTables Default Init
   ============================================ */
function initSimutuDataTable(selector, options) {
    selector = selector || '.simutu-datatable';
    var defaults = {
        responsive: true,
        scrollX: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            infoFiltered: '(difilter dari _MAX_ total data)',
            zeroRecords: 'Tidak ada data yang cocok',
            paginate: {
                first: 'Pertama',
                last: 'Terakhir',
                next: 'Berikut',
                previous: 'Sebelum'
            }
        }
    };

    var merged = $.extend({}, defaults, options || {});
    var dt = $(selector).DataTable(merged);
    initResponsiveTables();
    return dt;
}

/* ============================================
   CSRF Token Setup for AJAX
   ============================================ */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/* ============================================
   Utility Functions
   ============================================ */
function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function formatCurrency(num) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(num);
}

function formatDate(dateStr) {
    if (!dateStr) return '-';
    var d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
}

function formatDateTime(dateStr) {
    if (!dateStr) return '-';
    var d = new Date(dateStr);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function debounce(func, wait) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            func.apply(context, args);
        }, wait);
    };
}

function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function () {
            SimutuAlert.toast('success', 'Berhasil disalin ke clipboard');
        });
    }
}

/* ============================================
   Auto Konfirmasi SweetAlert untuk Aksi Penting
   ============================================ */
document.addEventListener('DOMContentLoaded', function () {
    var confirmMessages = {
        'submit': { title: 'Submit Dokumen?', text: 'Dokumen akan dikirim untuk review.', icon: 'question' },
        'review': { title: 'Review Dokumen?', text: 'Dokumen akan ditandai sebagai sudah direview.', icon: 'question' },
        'approve': { title: 'Setujui Dokumen?', text: 'Dokumen akan disetujui.', icon: 'question' },
        'publish': { title: 'Publikasikan Dokumen?', text: 'Dokumen akan dipublikasikan dan dapat diakses semua user.', icon: 'question' },
        'delete': { title: 'Hapus Data?', text: 'Data yang dihapus tidak dapat dikembalikan!', icon: 'warning', confirmColor: '#e53935' },
        'revisi': { title: 'Simpan Revisi?', text: 'Versi dokumen akan bertambah.', icon: 'question' },
        'activate': { title: 'Aktifkan Tahun Akademik?', text: 'Tahun akademik lain akan dinonaktifkan.', icon: 'question' },
        'deactivate': { title: 'Nonaktifkan Tahun Akademik?', text: 'Tahun akademik akan dinonaktifkan.', icon: 'question' },
    };

    document.querySelectorAll('form').forEach(function (form) {
        var action = form.getAttribute('action') || '';
        var submitBtn = form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        var matchedKey = null;
        for (var key in confirmMessages) {
            if (action.toLowerCase().indexOf('/' + key) !== -1 || action.toLowerCase().indexOf('/' + key + '/') !== -1) {
                matchedKey = key;
                break;
            }
        }
        if (!matchedKey) return;

        var msg = confirmMessages[matchedKey];
        submitBtn.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: msg.title,
                text: msg.text,
                icon: msg.icon,
                showCancelButton: true,
                confirmButtonColor: msg.confirmColor || '#1a237e',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});

/* Make SimutuAlert globally available */
window.SimutuAlert = SimutuAlert;
