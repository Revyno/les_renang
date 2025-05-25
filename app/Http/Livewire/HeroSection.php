<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Hero;

class HeroSection extends Component
{
    public $hero;

    public function mount()
    {
        $this->hero = Hero::first() ?? ['title' => 'Les Renang Terbaik & Terpercaya di Surabaya', 'description' => 'Selamat datang di website Tirta Nirwana semoga harimu cerah selalu :3', 'image' => 'assets/img/pict-1.jpg'];
    }

    public function render()
    {
        return view('livewire.hero-section');
    }
}