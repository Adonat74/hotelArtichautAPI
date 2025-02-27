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
                ['role_id' => 1],
                ['role_id' => 1],
                ['role_id' => 2],
                ['role_id' => 2],
                ['role_id' => 3],
                ['role_id' => 3],
            ))
            ->state(new Sequence(
                ['is_pro' => false],
                ['is_pro' => true],
                ['is_pro' => false],
            ))
            ->state(new Sequence(
                ['is_vip' => false],
                ['is_vip' => true],
            ))
            ->create();
    }
}
