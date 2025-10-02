<?php

namespace App\Http\Controllers;

use App\Models\DiyCategory;
use App\Models\DiyProduct;
use App\Models\DiyProductModifier;
use Illuminate\Http\Request;

class DiyController extends Controller
{
    public function index()
    {
        $categories = DiyCategory::with('diyProducts')->orderBy('order')->get();

        return view('pages.diy.index', compact('categories'));
    }

    public function category($id)
    {
        $category = DiyCategory::with([
            'diyProducts' => function ($query) {
                $query->orderBy('order');
            },
            'diyProducts.diyProductModifiers.availableColor',
            'diyProducts.diyProductModifiers.availableHeight',
            'diyProducts.diyProductModifiers.availableSpacing',
        ])->findOrFail($id);

        return view('pages.diy.category', compact('category'));
    }

    public function product($id)
    {
        $product = DiyProduct::with([
            'diyCategory',
            'diyProductPhotos',
            'diyProductModifiers.availableColor',
            'diyProductModifiers.availableHeight',
            'diyProductModifiers.availableSpacing',
        ])->findOrFail($id);

        return view('pages.diy.product', compact('product'));
    }
}