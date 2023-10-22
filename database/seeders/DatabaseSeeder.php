<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin 1',
            'username_slug' => 'admin-1',
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'admin 2',
            'username_slug' => 'admin-2',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
        ]);

        DB::table('users')->insert([
            'username' => 'user 1',
            'username_slug' => 'user-1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
        ]);

        $topic_names = [
            'Anime',
            'Advertising',
            'Art',
            'Actor',
            'Author',
            'Book',
            'BTS',
            'C',
            'C++',
            'Cooking',
            'Camera',
            'Cannon',
            'Digital',
            'Design',
            'Dream',
            'English',
            'Engineer',
            'Eating',
            'Electrical',
            'Fact',
            'Food',
            'Fast',
            'Fashion',
            'Google',
            'Galaxy',
            'Game',
            'Gasoline',
            'Genetic',
            'Hypothetical',
            'Hotel',
            'Human',
            'History',
            'Healthy',
            'Homework',
            'Indonesian',
            'India',
            'Jakarta',
            'Jean',
            'Juice',
            'Jazz',
            'Javascript',
            'Legal',
            'Life',
            'Living',
            'Loss',
            'Literature',
            'Making',
            'Money',
            'Message',
            'Messaging',
            'Mind',
            'New',
            'Online',
            'Of',
            'Probability',
            'Proton',
            'Pet',
            'Philosophy',
            'Psychology',
            'Particle',
            'Physic',
            'Painting',
            'Programming',
            'Question',
            'Quotation',
            'Quote',
            'Quantum',
            'Quran',
            'R',
            'Reading',
            'Rock',
            'Roll',
            'Software',
            'Self',
            'Studying',
            'SEO',
            'Search',
            'Stock',
            'UI',
            'UX',
            'User',
            'University',
            'United',
            'V',
            'Vegan',
            'Vegas',
            'Venture',
            'Video',
            'VS',
            'Viral',
            'World',
            'War',
            'Weight',
            'Writing',
            'Xbox',
            'Zoology',
            'Zero',
        ];

        for ($i = 0; $i < count($topic_names); $i++) {
            DB::table('topics')->insert([
                'name' => $topic_names[$i],
                'total_followers' => 1,
                'created_at' => now(),
            ]);

            $title = 'Example question: what is '.$topic_names[$i].'?';

            DB::table('questions')->insert([
                'user_id' => 1,
                'title' => $title,
                'title_slug' => str()->slug($title),
                'created_at' => now(),
            ]);

            DB::table('answers')->insert([
                'user_id' => 2,
                'question_id' => $i + 1,
                'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor, magnam! Ipsam dolore numquam eos praesentium, a fuga nostrum perspiciatis reprehenderit! Quas deserunt numquam est explicabo sint nostrum quod, inventore perspiciatis.',
                'created_at' => now(),
            ]);

            DB::table('answers')->insert([
                'user_id' => 3,
                'question_id' => $i + 1,
                'answer' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dolor, magnam! Ipsam dolore numquam eos praesentium, a fuga nostrum perspiciatis reprehenderit! Quas deserunt numquam est explicabo sint nostrum quod, inventore perspiciatis.',
                'created_at' => now(),
            ]);

            DB::table('topic_follows')->insert([
                'user_id' => 2,
                'topic_id' => $i + 1,
                'created_at' => now(),
            ]);
        }
    }
}
