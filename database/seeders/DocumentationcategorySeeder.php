<?php

namespace Database\Seeders;

use App\Models\Documentationcategory;
use Illuminate\Database\Seeder;

class DocumentationcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Documentationcategory;
        $category->order = 0;
        $category->title = 'General';
        $category->save();
    }
}
