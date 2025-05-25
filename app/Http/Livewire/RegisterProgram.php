<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Registration; 
use App\Models\Program;// Assuming you have a Contact model for WhatsApp number
use Livewire\WithFileUploads;

class RegisterProgram extends Component
{
    use WithFileUploads;

    public $programId;
    public $classId;
    public $classes;
    public $program;
    public $userId;
    public $parentName,$parentEmail,$parentPhone;
    public $student_name, $student_age, $student_gender, $student_photo, $medical_notes;
    public $registration_date;
    public $payment_proof, $payment_status = 'unpaid', $status = 'pending';


    public function mount($programId, $classId)
    {
        $this->programId = $programId;
        $this->classId = $classId;
        $this->userId = auth()->id(); // Assuming the user is authenticated
        $this->registration_date = now()->toDateString(); // Default to current date
        $this->program = Program::findOrFail($programId);
        $this->classes = $this->program->classes; // Assuming Program has a relationship with Classes
    }
    protected $rules = [
        'programId' => 'required|exists:programs,id',
        'classId' => 'required|exists:classes,id',
        'parentName' => 'required|string|max:255',
        'parentEmail' => 'required|email|max:255',
        'parentPhone' => 'required|string|max:20',
        'student_name' => 'required|string|max:255',
        'student_age' => 'required|integer|min:10|max:100',
        'student_gender' => 'required|in:male,female',
        'student_Photo' => 'nullable|image|max:2048', // Max 2MB
        'medical_notes' => 'nullable|string|max:1000',
    ];
    public function submit()
    {
        $this->validate();

        $data = $this->only([
            'programId', 'classId', 'userId', 'parentName', 'parentEmail', 
            'parentPhone', 'student_name', 'student_age', 'student_gender',
            'student_photo', 'medical_notes', 'registration_date', 'payment_proof',
            'payment_status', 'status']);
        $data['user_id'] = $this->userId;
        $data['program_id'] = $this->programId;
        $data['class_id'] = $this->classId;

        if ($this->student_photo) {
            $data['student_photo'] = $this->student_photo->store('photos', 'public');
        }

        Registration::create($data);
        session()->flash('message', 'Registration successful!');
        return redirect()->route('programs.index'); // Redirect to a suitable route after registration

    }
         
    public function render()
    {
        return view('livewire.register-program');
    }
}
