<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StudentAttendanceController extends Controller
{
    public function index(Request $request): View
    {
        return view('presensi', ['announcements' => DB::table('announcements')->whereNotNull('published_at')->latest('published_at')->take(8)->get(), 'history' => DB::table('attendances')->join('attendance_sessions', 'attendance_sessions.id', '=', 'attendances.attendance_session_id')->where('attendances.user_id', $request->user()->id)->select('attendance_sessions.module', 'attendances.checked_in_at', 'attendances.status')->latest('attendances.checked_in_at')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $d = $request->validate(['code' => ['required', 'string', 'max:12']]);
        $session = DB::table('attendance_sessions')->where('code', strtoupper($d['code']))->where('opens_at', '<=', now())->where('closes_at', '>=', now())->first();
        if (! $session) {
            return back()->withErrors(['code' => 'Kode presensi tidak aktif atau tidak ditemukan.']);
        } DB::table('attendances')->updateOrInsert(['attendance_session_id' => $session->id, 'user_id' => $request->user()->id], ['status' => 'present', 'checked_in_at' => now(), 'updated_at' => now(), 'created_at' => now()]);

        return back()->with('success', 'Presensi berhasil dicatat untuk '.$session->module.'.');
    }
}
