<?php

namespace Database\Seeders;

use App\Models\User;
use App\RolesEnum;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@email.com'
        ])->assignRole(RolesEnum::User->value);

        User::factory()->create([
            'name' => 'Vendor',
            'email' => 'vendor@email.com'
        ])->assignRole(RolesEnum::User->value);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@email.com'
        ])->assignRole(RolesEnum::User->value);
    }
}
