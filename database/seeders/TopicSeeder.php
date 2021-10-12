<?php

namespace Database\Seeders;

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
            'Food'
        ];

        for ($i=0; $i < count($topics); $i++) { 
            DB::table('topics')->insert([
                'name' => $topics[$i],
            ]);
        }

    }
}
