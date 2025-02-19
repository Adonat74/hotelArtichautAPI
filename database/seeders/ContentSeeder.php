<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Content::factory()
            ->count(15)
            ->state(new Sequence(
                ['language_id' => 1],
                ['language_id' => 2],
            ))
            ->create();
    }
}
