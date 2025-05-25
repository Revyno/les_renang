<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Stats;
class StatsSection extends Component
{
    public $stats;

    public function mount()
    {
        $this->stats = Stats::all()->toArray() ?? [
            ['icon' => 'bi-emoji-smile', 'value' => 60, 'label' => 'Happy Students'],
            ['icon' => 'bi-journal-richtext', 'value' => 100, 'label' => 'Lessons Completed'],
            ['icon' => 'bi-headset', 'value' => 500, 'label' => 'Hours of Training'],
            ['icon' => 'bi-people', 'value' => 5, 'label' => 'Instructors'],
        ];
    }
    public function render()
    {
        return view('livewire.stats-section');
    }
}
