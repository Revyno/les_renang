<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\contact;
class Footer extends Component
{
    public $contacts;
    public function mount()
    {
        $this->contacts= Contact::first() ?: [
            'description'=> 'Tirta Nirwana menyediakan les renang profesional di surabaya ',
            'address' => '',
            'phone' => '',
            'email' => '',
            'social' => [],
            'whatsapp_number' => '',
            'whatsapp_message' => ''
        ];

        // $this->contacts = contact::all();
    }
    public function render()

    {
        return view('livewire.footer');
    }
}
