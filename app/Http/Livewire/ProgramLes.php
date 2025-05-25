<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Program;
use Livewire\WithPagination;

class ProgramLes extends Component
{   
    // use WithPagination;

    // public $ageFilter = 'all';
    // public $perPage = 6;

    // public function updatedAgeFilter()
    // {
    //     $this->resetPage();
    // }

    public function render()
    {
        // $programs = Program::query()
        //     ->with(['class', 'instructor'])
        //     ->when($this->ageFilter !== 'all', fn($q) => $q->where('age_range', $this->ageFilter))
        //     ->where('is_active', true)
        //     ->paginate($this->perPage);

    // public function render()
    // {
        return view('livewire.program-les', [
            'programs' => Program::all()
        ]);
     }
}

