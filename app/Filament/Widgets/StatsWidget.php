<?php

namespace App\Filament\Widgets;

use App\Models\Program;
use Filament\Widgets\Widget;
use Livewire\Component;

class StatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.stats-widget';
    
    // Make the widget listen for the filter event
    protected $listeners = ['dashboardFiltersUpdated' => 'applyFilters'];
    
    public $filterData = [];
    public $stats = [];
    
    public function amount()
    {
        $this->loadStats();
    }
    
    public function applyFilters($filterData)
    {
        $this->filterData = $filterData;
        $this->loadStats();
    }
    
    protected function loadStats()
    {
        // Apply filters to your query
        $query = Program::query();
        
        if (isset($this->filterData['date_start'])) {
            $query->whereDate('created_at', '>=', $this->filterData['date_start']);
        }
        
        if (isset($this->filterData['date_end'])) {
            $query->whereDate('created_at', '<=', $this->filterData['date_end']);
        }
        
        if (!empty($this->filterData['status'])) {
            $query->whereIn('status', $this->filterData['status']);
        }
        
        if (isset($this->filterData['search']) && !empty($this->filterData['search'])) {
            $query->where('name', 'like', '%' . $this->filterData['search'] . '%');
        }
        
        // Calculate your stats based on filtered query
        $this->stats = [
            'total' => $query->count(),
            'average' => $query->avg('amount'),
            // other stats...
        ];
    }
}