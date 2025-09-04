<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'=>'Shane Barron',
            'email'=>'sbarron@daniellefence.net',
            'password'=>Hash::make('DFMGN@dm!n$'),
            'email_verified_at' => now()
        ]);

        // Assign SuperAdmin role if it exists
        if (\Spatie\Permission\Models\Role::where('name', 'SuperAdmin')->exists()) {
            $user->assignRole('SuperAdmin');
        }
    }
}
