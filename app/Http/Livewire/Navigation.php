<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Navigation extends Component
{
    public $menuItems;
    
    public function mount()
    {
        $this->menuItems = Page::where('in_menu', true)
                             ->orderBy('menu_order')
                             ->get();
    }
    
    public function render()
    {
        return view('livewire.navigation');
    }
}
