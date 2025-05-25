<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Program;
use App\Models\Registration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $class = Classes::all();
        $program = Program::with(['class_name', 'instructor'])->get();
        
        return view('frontend.registration', compact('classes', 'programs'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_email' => 'required|email|max:255',
            'parent_phone' => 'required|string|max:20',
            'student_name' => 'required|string|max:255',
            'student_age' => 'required|integer|min:3|max:18',
            'student_gender' => 'required|in:male,female',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'medical_notes' => 'nullable|string',
            'class_id' => 'required|exists:class,id',
            'program_id' => 'required|exists:program,id',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        
        $registration = Registration::create($validated);

        //Handle payment proof
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('photos/payments', 'public');
            $registration->update(['payment_proof' => $paymentProofPath]);
        }
        else {
            $registration->update(['payment_proof' => null]);
        }

        //Handle payement status
        if ($request->has('payment_status')) {
            $validated['payment_status'] = $request->input('payment_status');
            $registration->update(['payment_status' => $request->input('payment_status')]);
        }
        else {
            $registration->update(['payment_status' => 'unpaid']);
            $registration->update(['status' => 'pending']);
        }

        // Handle file uploads
        if ($request->hasFile('student_photo')) {
            $photoPath = $request->file('student_photo')->store('photos/students', 'public');
            $registration->update(['student_photo' => $photoPath]);
        }
        else {
            $registration->update(['student_photo' => null]);
        }
        
        return redirect()->route('register.success', $registration);
    }

    public function success(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }
        
         return view('frontend.registration_success', compact('registration'));
    }
}