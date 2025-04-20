<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::query();
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('no_telepon', 'like', "%{$search}%");
                // ->orWhere('program', 'like', "%{$search}%");
        }
        
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('created_at', [$request->get('date_from'), $request->get('date_to')]);
        }
        
        $registrations = $query->latest()->paginate(10);
        
        return view('admin.registrations.index', compact('registrations'));
    }
    
    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }
    
    public function edit(Registration $registration)
    {
        return view('admin.registrations.edit', compact('registration'));
    }
    
    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string',
            'email' => 'required|email|unique:registrations,email,' . $registration->id,
            'usia' => 'required|numeric',
            'program' => 'required|string',
            'jadwal' => 'required',
            'tingkat_kemampuan' => 'required|string',
            'status' => 'required|string',
        ]);
        
        $registration->update($validated);
        
        return redirect()->route('admin.registrations.show', $registration)
            ->with('success', 'Data pendaftaran berhasil diperbarui');
    }
    
    public function destroy(Registration $registration)
    {
        $registration->delete();
        
        return redirect()->route('admin.registrations.index')
            ->with('success', 'Data pendaftaran berhasil dihapus');
    }
}