<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'user_id' => 3,
            'title' => 'Test question 1 without topics ?',
            'title_slug' => 'test-question-1-without-topics',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'user_id' => 4,
            'title' => 'Test question 2 without topics ?',
            'title_slug' => 'test-question-2-without-topics',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'user_id' => 5,
            'title' => 'Test question 3 without topics ?',
            'title_slug' => 'test-question-3-without-topics',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'user_id' => 3,
            'title' => 'Test question 1 with topics ?',
            'title_slug' => 'test-question-1-with-topics',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'user_id' => 4,
            'title' => 'Test question 2 with topics ?',
            'title_slug' => 'test-question-2-with-topics',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('questions')->insert([
            'user_id' => 5,
            'title' => 'Test question 3 with topics ?',
            'title_slug' => 'test-question-3-with-topics',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
