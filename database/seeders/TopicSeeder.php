<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = [
            'Web Programming',
            'Studying',
            'Fine Art',
            'Actor',
            'Anime',
            'Fitness',
            'Clothing',
            'Movies',
            'Writers',
            'Author',
            'Books',
            'Science',
            'Biology',
            'Brands',
            'Branding',
            'Cameras',
            'Computer',
            'Cards',
            'Motorcycle',
            'Engines',
            'Web',
            'Digital',
            'Marketing',
            'Music',
            'Pets',
            'Medical',
            'Dreams',
            'Recipes',
            'Experiences',
            'English',
            'Literature',
            'Facts',
            'Food',
            'Data Science'
        ];

        for ($i=0; $i < count($topics); $i++) { 
            DB::table('topics')->insert([
                'name' => $topics[$i],
                'name_slug' => Str::of($topics[$i])->slug('-'),
            ]);
        }

    }
}
