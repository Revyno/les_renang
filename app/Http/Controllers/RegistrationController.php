// app/Http/Controllers/RegistrationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('registration.form');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string',
            'email' => 'required|email|unique:registrations',
            'usia' => 'required|numeric',
            'program' => 'required|string',
            'jadwal' => 'required|string',
            'tingkat_kemampuan' => 'required|string',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        Registration::create($request->all());
        
        return redirect()->route('registration.success');
    }
    
    public function success()
    {
        return view('registration.success');
    }
}