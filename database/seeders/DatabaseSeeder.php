<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=1; $i < 10 ; $i++) {
            DB::table('users')->insert([
                'username' => 'test' . $i,
                'username_slug' => 'test' . $i,
                'email' => 'test' . $i . '@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
            ]);
        }

        $title = 'example question from user';

        for ($i=1; $i < 10 ; $i++) {
            DB::table('questions')->insert([
                'user_id' => 1,
                'title' => $title . ' ' . $i,
                'title_slug' => str()->slug($title),
                'created_at' => now(),
            ]);
        }

        for ($i=1; $i < 10 ; $i++) {
            for ($j=1; $j < 10 ; $j++) {
                DB::table('answers')->insert([
                    'user_id' => $i + 1,
                    'question_id' => 1,
                    'answer' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem voluptates fugiat atque, voluptatibus fuga quos ab eligendi delectus ullam veniam. Sed ipsam fugit deserunt vero pariatur ad laboriosam itaque numquam?',
                    'created_at' => now(),
                ]);
            }
        }

    }
}
