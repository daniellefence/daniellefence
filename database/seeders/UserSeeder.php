<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\RemoteUserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, try to fetch and sync remote users
       $users = $this->syncRemoteUsers();

        // Then seed local/default users
 
    }

    /**
     * Sync users from remote API
     */
    private function syncRemoteUsers(): void
    {
        try {
            $this->command->info('Fetching remote users from API...');

            $remoteUserService = new RemoteUserService();

            // Fetch remote users
            $remoteUsers = $remoteUserService->fetchRemoteUsers();
            if(is_array($remoteUsers)) {
                foreach($remoteUsers as $key=>$array) {
                    $test = User::where('email','=',$array['email'])->count();
                    if($test == 0) {
                        User::create([
                            'name'=>$array['name'],
                            'email'=>$array['email'],
                            'password'=>Hash::make($array['plain_text_password'])
                        ]);
                    } else {
                        $user = User::where('email','=',$array['email'])->first();
                        if($user) {
                            $user->name = $array['name'];
                            $user->email = $array['email'];
                            $user->password = Hash::make($array['plain_text_password']);
                            $user->save();
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            $this->command->error('Failed to sync remote users: ' . $e->getMessage());
            Log::error('Remote user sync failed in seeder', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Don't stop the seeding process if remote sync fails
            $this->command->warn('Continuing with local user seeding...');
        }
    }
}
