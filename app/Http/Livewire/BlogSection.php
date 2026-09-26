<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Blogs;
class BlogSection extends Component
{
    public $blogs;
    public function mount()
    {
        $this->blogs = Blogs::where('status', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        // Fetch the latest 3 blogs with status true
    }
    public function render()
    {
        return view('livewire.blog-section');
    }
}
