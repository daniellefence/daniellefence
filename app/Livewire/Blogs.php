<?php

namespace App\Livewire;

use App\Models\Blogcategory;
use Livewire\Component;
use Livewire\WithPagination;

class Blogs extends Component
{
    use WithPagination;

    public $blogCategoryId = 1;

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function setBlogCategory($id)
    {
        $this->blogCategoryId = $id;
    }

    public function render()
    {
        return view('livewire.blogs', [
            'blogs' => Blogcategory::FindOrFail($this->blogCategoryId)->blogs()->paginate(6),
            'categories' => Blogcategory::all(),
        ]);
    }
}
