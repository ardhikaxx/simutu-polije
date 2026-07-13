<?php

namespace App\Http\Controllers\Notifikasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);

        return view('notifikasi.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->route('notifikasi.index')
            ->with('success', 'Notifikasi telah ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifikasi.index')
            ->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }
}
