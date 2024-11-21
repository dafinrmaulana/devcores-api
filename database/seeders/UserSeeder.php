<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private const TRUE = 1;
    private const FALSE = 0;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@show.com',
            'password' => bcrypt('admin'),
            'username' => 'username',
            'is_admin' => $this::TRUE,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@show.com',
            'password' => bcrypt('admin'),
            'username' => 'username',
            'is_admin' => $this::TRUE,
        ]);
    }
}
