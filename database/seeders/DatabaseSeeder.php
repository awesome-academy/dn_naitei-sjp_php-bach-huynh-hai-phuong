<?php

namespace Database\Seeders;

use App\Models\Enums\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'role' => Role::SUPERVISOR,
        ]);

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@email.com',
            'role' => Role::TRAINEE,
        ]);
    }
}
