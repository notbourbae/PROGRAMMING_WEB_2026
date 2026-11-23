<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Brillian Daniar',
            'email' => 'brilliandaniarkautama@webmail.umm.ac.id',
        ]);

        Media::create([
            'title' => 'Attack on Titan',
            'type' => 'Anime',
            'genre' => 'Action/Fantasy',
            'rating' => 92.5,
            'episodes' => 87,
            'studio' => 'MAPPA',
        ]);

        Media::create([
            'title' => "Frieren: Beyond Journey's End",
            'type' => 'Anime',
            'genre' => 'Adventure/Drama',
            'rating' => 95.0,
            'episodes' => 28,
            'studio' => 'Madhouse',
        ]);

        Media::create([
            'title' => 'Vincenzo',
            'type' => 'Drama',
            'genre' => 'Crime/Drama',
            'rating' => 88.0,
            'episodes' => 20,
            'studio' => 'Studio Dragon',
        ]);
    }
}
