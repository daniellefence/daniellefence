<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (seeds()->products() as $category) {
            $categoryModel = $this->createCategory($category);
            if (isset($category['subcategories'])) {
                foreach ($category['subcategories'] as $subcategory) {
                    $subcategoryModel = $this->createSubcategory($categoryModel->id, $categoryModel, $subcategory);
                    if (isset($subcategory['subcategories'])) {
                        foreach ($subcategory['subcategories'] as $subcategory2) {
                            $subcategoryModel2 = $this->createSubcategory($categoryModel->id, $subcategoryModel,
                                $subcategory2);
                            if (isset($subcategory2['subcategories'])) {
                                foreach ($subcategory2['subcategories'] as $sub2) {
                                    $this->createSubcategory($categoryModel->id, $subcategoryModel2, $sub2);
                                }
                            }
                            if (isset($subcategory2['products'])) {
                                foreach ($subcategory2['products'] as $product) {
                                    $this->createProduct($categoryModel->id, $subcategoryModel2, $product);
                                }
                            }
                        }
                    } elseif (isset($subcategory['products'])) {
                        foreach ($subcategory['products'] as $product) {
                            $this->createProduct($categoryModel->id, $subcategoryModel, $product);
                        }
                    } else {
                        $title = $subcategory['title'];
                        $description = $subcategory['description'];
                        $key = seeds()->createKey($title);
                        $productModel = $categoryModel->products()->create([
                            'title' => $title,
                            'description' => $description,
                        ]);
                        //                        $files = glob('resources/images/default_slides/' . $key . '/*.*');
                        //                        foreach ($files as $file) {
                        //                            $path = Storage::putFile('photos',new File($file));
                        //                            $productModel->photos()->create([
                        //                                'title' => $productModel->title,
                        //                                'path' => $path
                        //                            ]);
                        //                        }
                    }
                }
            }

        }
    }

    public function createCategory($array)
    {
        $title = $array['title'];
        $description = $array['description'];
        $key = seeds()->createKey($title);
        $categoryModel = Category::create([
            'title' => $title,
            'description' => $description,
        ]);
        $path = Storage::disk('public')->putFile('resources/images/product-categories/'
            .$key.'.jpg');
        $categoryModel->photo()->create([
            'title' => $title,
            'path' => $path,
        ]);

        return $categoryModel;
    }

    public function createSubcategory($category_id, $model, $array)
    {
        $title = $array['title'];
        $description = $array['description'] ?? '';
        $key = seeds()->createKey($title);
        $subcategoryModel = $model->subcategories()->create([
            'title' => $title,
            'description' => $description,
        ]);
        $path = Storage::disk('public')->putFile('resources/images/product-subcategories/'.$key.'-min.jpg');
        $subcategoryModel->photos()->create([
            'title' => $title,
            'path' => $path,
        ]);

        return $subcategoryModel;
    }

    public function createProduct($category_id, $model, $array)
    {
        $title = $array['title'];
        $description = $array['description'];
        $key = seeds()->createKey($title);
        $productModel = $model->products()->create([
            'title' => $array['title'],
            'description' => $array['description'],
            'key' => $key,
        ]);
        $files = glob('resources/images/default_slides/'.$key.'/*.*');
        foreach ($files as $file) {
            $path = Storage::disk('public')->putFile($file);
            $productModel->photoRecords()->create([
                'title' => $productModel->title,
                'path' => $path,
            ]);
        }
        if (isset($array['pip'])) {
            $filename = $array['pip'];
            $path = Storage::disk('public')->putFile('resources/pip/'.$filename);
            $productModel->pip()->create([
                'title' => $productModel->title,
                'path' => $path,
            ]);
        }

    }
}
