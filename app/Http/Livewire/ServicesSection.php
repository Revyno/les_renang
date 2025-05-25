<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;
class ServicesSection extends Component
{
    public $services;

    public function mount()
    {
        $this->services = Service::all()->toArray() ?? [
            ['title' => 'Nesciunt Mete', 'description' => 'Provident nihil minus...', 'image' => 'assets/img/services-1.jpg', 'icon' => 'bi-activity'],

        ];
    }
    public function render()
    {
        return view('livewire.services-section');
    }
}
