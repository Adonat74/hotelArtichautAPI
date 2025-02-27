<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'role_name' => 'user',
            'priority' => 1
        ]);

        DB::table('roles')->insert([
            'role_name' => 'employee',
            'priority' => 2
        ]);

        DB::table('roles')->insert([
            'role_name' => 'manager',
            'priority' => 3
        ]);

        DB::table('roles')->insert([
            'role_name' => 'master',
            'priority' => 4
        ]);
    }
}
