<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num = 8;

        for ($i=1; $i <= $num ; $i++) { 
            DB::table('question_topics')->insert([
                'question_id' => 5,
                'topic_id' => $i
            ]);
        }

        for ($i=1; $i <= $num ; $i++) { 
            DB::table('question_topics')->insert([
                'question_id' => 6,
                'topic_id' => $i
            ]);
        }

        for ($i=1; $i <= $num ; $i++) { 
            DB::table('question_topics')->insert([
                'question_id' => 7,
                'topic_id' => $i
            ]);
        }

    }
}
