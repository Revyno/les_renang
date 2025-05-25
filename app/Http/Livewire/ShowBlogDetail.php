<?php

namespace App\Livewire;

use App\Models\Blogs;
use App\Models\Categories;
use Livewire\Component;

class ShowBlogDetail extends Component
{      
    public $id;
    public function mount($id)
    {
        $this->id = $id;
    }
    public function render()
    {       
        $blog = Blogs::findOrFail($this->id);
        $category = Categories::findorFail($blog->categories_id);
        return view('livewire.show-blog-detail',[
            'blog'=>$blog,
            'category'=>$category
        ]);
    }
}
