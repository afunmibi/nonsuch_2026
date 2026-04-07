<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
        ]);

        // Ensure a single administrator account exists and is updated with
        // the requested credentials.
        $existingAdmin = User::where('role', 'admin')->first();

        if ($existingAdmin) {
            $existingAdmin->update([
                'name' => 'Administrator',
                'email' => 'afunmibi@gmail.com',
                'password' => Hash::make('Ccampus'),
            ]);
        } else {
            User::updateOrCreate([
                'email' => 'afunmibi@gmail.com',
            ], [
                'name' => 'Administrator',
                'password' => Hash::make('Ccampus'),
                'role' => 'admin',
            ]);
        }
    }
}
