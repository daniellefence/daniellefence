<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Contact;
use App\Models\QuoteRequest;
use App\Models\Modifier;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::firstOrCreate(['slug' => 'vinyl'], ['name' => 'Vinyl']);
        $prod = Product::firstOrCreate(
            ['slug' => 'vinyl-privacy'],
            [
                'product_category_id' => 1, // Use product_category_id instead
                'name' => 'Vinyl Privacy Panel',
                'base_price' => 100.00,
                'is_diy' => true,
                'available_colors' => ['white','tan','gray'],
                'available_heights' => ['4ft','6ft','8ft'],
                'available_picket_widths' => ['3in','4in'],
                'published' => true,
            ]
        );

        // Example modifiers
        Modifier::firstOrCreate([
            'product_id' => $prod->id,
            'attribute' => 'color',
            'value' => 'white',
            'type' => 'add',
            'operation' => 'percent',
            'amount' => 10,
        ]);
        Modifier::firstOrCreate([
            'product_id' => $prod->id,
            'attribute' => 'height',
            'value' => '6ft',
            'type' => 'add',
            'operation' => 'fixed',
            'amount' => 15,
        ]);

        $contact = Contact::firstOrCreate(['email' => 'customer@example.com'], ['first_name' => 'Test','last_name'=>'Customer']);
        QuoteRequest::firstOrCreate([
            'contact_id' => $contact->id,
            'product_id' => $prod->id,
            'status' => 'new',
            'color' => 'white',
            'height' => '6ft',
            'picket_width' => '3in',
            'base_price' => 100,
            'calculated_price' => 0, // observer will set real value
        ]);
    }
}
