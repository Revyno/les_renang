<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\class;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $activeRegistrations = $user->activeRegistrations()->with(['classes', 'program'])->get();
        
        return view('frontend.student.dashboard', compact('user', 'activeRegistrations'));
    }

    public function profile()
    {
        return view('frontend.student.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($validated);
        
        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function registrations()
    {
        $registrations = Auth::user()->registrations()
            ->with(['swimLevel', 'schedule'])
            ->latest()
            ->get();
            
        return view('frontend.student.registrations', compact('registrations'));
    }

    public function showRegistration(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('frontend.student.registration_detail', compact('registration'));
    }

    public function uploadPayment(Request $request, Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);
        
        $path = $request->file('payment_proof')->store('payment-proofs', 'public');
        
        $registration->update([
            'payment_proof' => $path,
            'payment_status' => 'pending',
        ]);
        
        return back()->with('success', 'Bukti pembayaran berhasil diunggah');
    }
}