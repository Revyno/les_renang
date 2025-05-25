<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AboutUs;
class Aboutsection extends Component
{
    public $about;

    public function mount()
    {
        $this->about = AboutUs::first() ?? [
            'title' => 'About',
            'description' => 'Tirta Nirwana adalah lembaga pelatihan renang...',
            'image' => 'assets/img/teacher/abo-1.jpg',
            'video_url' => 'https://www.youtube.com/live/zQl3NRxZED0?si=hbCTQZMHCxusuU_A'
        ];
    }
    public function render()
    {
        // $about = AboutUs::first();
        // $videoUrl = $about->video_url ?? 'https://youtu.be/default-video';
        // return view('livewire.aboutsection',compact('about', 'videoUrl'));
          return view('livewire.aboutsection');
    }
}
