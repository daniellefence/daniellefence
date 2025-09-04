<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        if (Contact::query()->exists()) return;

        Contact::factory()->count(10)->create();
    }
}
