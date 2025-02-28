<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class NewsArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsArticle::factory()
            ->count(10)
            ->state(new Sequence(
                ['language_id' => 1],
                ['language_id' => 2],
            ))
            ->create();
    }
}
