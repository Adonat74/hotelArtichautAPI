<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(15)
            ->state(new Sequence(
                ['role' => 'user'],
                ['role' => 'employee'],
                ['role' => 'manager'],
                ['role' => 'master'],
            ))
            ->state(new Sequence(
                ['status' => 'standard'],
                ['status' => 'pro'],
            ))
            ->state(new Sequence(
                ['isVIP' => 0],
                ['isVIP' => 1],
            ))
            ->create();
    }
}
