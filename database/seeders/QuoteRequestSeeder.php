<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuoteRequest;

class QuoteRequestSeeder extends Seeder
{
    public function run(): void
    {
        if (QuoteRequest::query()->exists()) return;

        QuoteRequest::factory()->count(8)->create();
    }
}
