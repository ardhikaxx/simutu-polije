<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AktivitasUserController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        if ($request->filled('user')) {
            $query->where('causer_id', $request->user);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                    ->orWhere('subject_type', 'like', "%{$request->search}%");
            });
        }

        $activities = $query->paginate(20);
        $users = User::orderBy('nama')->get();

        return view('aktivitas.index', compact('activities', 'users'));
    }

    public function user(User $user)
    {
        $activities = Activity::where('causer_id', $user->id)
            ->latest()
            ->paginate(20);

        return view('aktivitas.user', compact('user', 'activities'));
    }
}
