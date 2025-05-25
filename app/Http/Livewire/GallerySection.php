<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\gallery;
class GallerySection extends Component
{
    public $galleryItems;

    public function mount()
    {
        $this->galleryItems = Gallery::all()->toArray() ?? [
            ['title' => 'Swimming Class', 'image' => 'assets/img/gallery/gallery-1.jpg'],
            ['title' => 'Group Training', 'image' => 'assets/img/gallery/gallery-2.jpg'],
            ['title' => 'Kids Swimming', 'image' => 'assets/img/gallery/gallery-3.jpg'],
        ];
    }
    public function render()
    {
        return view('livewire.gallery-section');
    }
}
