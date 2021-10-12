<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->insert([
            'user_id' => 2,
            'question_id' => 8,
            'text' => 'test new answer user2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answers')->insert([
            'user_id' => 3,
            'question_id' => 8,
            'text' => 'test new answer user3',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answers')->insert([
            'user_id' => 1,
            'question_id' => 9,
            'text' => 'test new answer user1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answers')->insert([
            'user_id' => 3,
            'question_id' => 9,
            'text' => 'test new answer user3',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answers')->insert([
            'user_id' => 1,
            'question_id' => 10,
            'text' => 'test new answer user1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answers')->insert([
            'user_id' => 2,
            'question_id' => 10,
            'text' => 'test new answer user2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
