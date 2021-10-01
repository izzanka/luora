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
            'user_id' => 4,
            'question_id' => 2,
            'text' => 'test new answer without images',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answers')->insert([
            'user_id' => 5,
            'question_id' => 3,
            'text' => 'test new answer without images',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('answers')->insert([
            'user_id' => 3,
            'question_id' => 4,
            'text' => 'test new answer without images',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
