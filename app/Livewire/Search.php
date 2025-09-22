<?php

namespace App\Livewire;

use App\Models\Photo;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public $q;

    public $categoryQuery = [];

    public $subcategoryQuery = [];

    public $photosQuery = [];

    public function mount($q)
    {
        $this->q = $q;
        $this->calculate();
    }

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function calculate()
    {
        $this->resetPage();
        $this->photosQuery = $this->createQuery(['title', 'keywords']);
    }

    public function createQuery(array $parameters)
    {
        $items = explode(' ', $this->q);
        $queries = [];
        foreach ($parameters as $param) {
            $query = [];
            foreach ($items as $item) {
                $query[] = [
                    $param, 'like', '%'.$item.'%',
                ];
            }
            $queries[] = $query;
        }

        return $queries;
    }

    public function getPhotos()
    {
        return Photo::where($this->photosQuery[0])->orWhere($this->photosQuery[1])->whereNotNull('product_id')->paginate(12);
    }

    public function render()
    {
        $photos = $this->getPhotos();

        return view('livewire.search', [
            'photos' => $photos,
        ]);
    }
}
