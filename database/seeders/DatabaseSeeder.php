<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $roles = ["Admin", "Customer", "Courier"];
        foreach ($roles as $role) {
            Role::create([
                "name" => $role,
                "guard_name" => "api"
            ]);
        }

        User::factory()->create([
            "email" => "admin@mailinator.com"
        ])->syncRoles(Role::findById(User::ADMIN, 'api')->first());
    }
}
