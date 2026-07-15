<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            "name"      => "Admin",
            "prenom"    => "Principal",
            "email"     => "admin@agesp.local",
            "telephone" => "70000000",
            "role"      => "admin",
            "password"  => Hash::make("motdepasse123"),
        ]);
    }
}