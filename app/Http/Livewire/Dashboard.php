<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
class Dashboard extends Component
{public $registrations;

    public function mount()
    {
        $this->registrations = Registration::where('user_id', Auth::id())->with('program')->get();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
