<?php

namespace App\Http\Livewire;

use App\Models\contact;
use App\Models\Program;
use Livewire\Component;

class ProgramList extends Component
{
    public $whatsappNumber = '6281247608150'; 
    // Default WhatsApp number

    public function mount()
    {
        $contact = contact::first();
        $this->whatsappNumber = $contact ? $contact->whatsapp_number : '6281247608150';
        $this->programs = Program::where('toggle', true)->with('classes')->get();
        // You can set the WhatsApp number dynamically if needed
        // $this->whatsappNumber = '6281247608150'; // Example of setting a default number
    }
    public function render()
    {
        return view('livewire.program-list');
    }
}
