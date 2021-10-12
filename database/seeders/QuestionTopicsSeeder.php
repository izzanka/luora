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
                'question_id' => 11,
                'topic_id' => $i
            ]);
        }

        for ($i=1; $i <= $num ; $i++) { 
            DB::table('question_topics')->insert([
                'question_id' => 12,
                'topic_id' => $i
            ]);
        }

        for ($i=1; $i <= $num ; $i++) { 
            DB::table('question_topics')->insert([
                'question_id' => 13,
                'topic_id' => $i
            ]);
        }

    }
}
