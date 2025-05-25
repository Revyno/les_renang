<?php

namespace App\Http\Livewire;
use App\Models\Instructor;
use Livewire\Component;

class TeamSection extends Component
{
    public $instructors;
    public function mount()
    {
        $this->instructors = Instructor::all()->toArray() ?? [
            ['name' => 'Walter White', 'title' => 'Chief Executive Officer', 'image' => 'assets/img/team/team-1.jpg', 'social' => ['twitter' => '', 'facebook' => '', 'instagram' => '', 'linkedin' => '']],
            // Add more default instructors
        ];
    }

    public function render()

    {
    
        return view('livewire.team-section', [
            'instructors' => Instructor::all() // Or any query you need
        ]);
    }
    // public function render()
    // {
    //     return view('livewire.team-section');
    // }
}

