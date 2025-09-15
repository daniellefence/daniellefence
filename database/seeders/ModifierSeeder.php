<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modifier;

class ModifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modifiers = [
            [
                'product_id' => 1,
                'type' => 'add',
                'attribute' => 'color',
                'value' => 'white',
                'operation' => 'fixed',
                'amount' => 0.00,
            ],
            [
                'product_id' => 1,
                'type' => 'add',
                'attribute' => 'height',
                'value' => '8ft',
                'operation' => 'percent',
                'amount' => 25.00,
            ],
            [
                'product_id' => 1,
                'type' => 'add',
                'attribute' => 'picket_width',
                'value' => '3in',
                'operation' => 'fixed',
                'amount' => 15.00,
            ],
            [
                'product_id' => 1,
                'type' => 'subtract',
                'attribute' => 'color',
                'value' => 'brown',
                'operation' => 'percent',
                'amount' => 5.00,
            ],
        ];

        foreach ($modifiers as $modifier) {
            Modifier::create($modifier);
        }
    }
}
