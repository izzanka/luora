<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = array(
            array('id' => '1','name' => 'admin','name_slug' => 'admin','credential' => NULL,'description' => NULL,'email' => 'admin@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=admin&background=868e96&color=fff','country' => NULL,'role' => 'admin','remember_token' => 'PF1GH30K1wBAsuwBdKqbBZPS99ZBZ940aSywrnkPnHYhfX6WkjecNflhlwGn','created_at' => '2022-09-04 21:12:11','updated_at' => NULL),
            array('id' => '2','name' => 'IzzanKA','name_slug' => 'izzanka','credential' => NULL,'description' => NULL,'email' => 'user1@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$6yUbMKg1hNLPSS7gcqDoculoq9I07tYYyiVAwoqKfIbKZ4mwBgkoS','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=user1&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-01-01 10:52:14','updated_at' => '2023-09-21 13:10:41'),
            array('id' => '3','name' => 'user2','name_slug' => 'user2','credential' => NULL,'description' => 'a human','email' => 'user2@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$xo2D6TrJ7NbgZOWSQ9F4Iuk91y7axHrjdyaZ8npEGRhW9B.25UpVO','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=user2&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-01-01 10:53:47','updated_at' => '2022-01-01 11:01:57'),
            array('id' => '4','name' => 'user3','name_slug' => 'user3','credential' => NULL,'description' => NULL,'email' => 'user3@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$pwbysRd0.Gg8T7HdH27vDuCh4KqkdH24GAOFCpi8yocaZn.K5BOii','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=user3&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-01-01 10:55:07','updated_at' => '2022-01-01 10:55:07'),
            array('id' => '7','name' => 'test tetst','name_slug' => 'test-tetst','credential' => NULL,'description' => NULL,'email' => 'tarun.zip@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$EsNb4id1HleYhjLps4iUBekzhHqfgTFnPr4jI3lvYGU6.8N0l7WbK','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=test tetst&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-02-01 22:24:46','updated_at' => '2022-02-01 22:24:46'),
            array('id' => '8','name' => 'Bambang','name_slug' => 'bambang','credential' => NULL,'description' => NULL,'email' => 'bam@mail.com','email_verified_at' => NULL,'password' => '$2y$10$sL2GkzUUGHWt0tKcOzF32uIgoD1eievoCkzKt.fyL7DUC9PCwbIHK','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Bambang&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-04-09 08:02:33','updated_at' => '2022-04-09 08:02:33'),
            array('id' => '9','name' => 'kadan fsfsewwe','name_slug' => 'kadan-fsfsewwe','credential' => NULL,'description' => NULL,'email' => 'akrekadan@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$s8n7Xxtv34vQ04JBmUDFGeKq9TyBtOYDmBhRBF6RsvuToyNBiGQJG','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=kadan fsfsewwe&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-07-05 23:14:42','updated_at' => '2022-07-05 23:14:42'),
            array('id' => '12','name' => 'user','name_slug' => 'user','credential' => NULL,'description' => NULL,'email' => 'user@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$RfCyhmTtjZ.PhgcUQ3ly1uLbBd1W1Y7.zbhEkFJ./17pvl/cZQyLS','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=user&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-09-25 09:57:37','updated_at' => '2022-09-25 09:57:37'),
            array('id' => '15','name' => 'Elisyah Mutmainnah','name_slug' => 'elisyah-mutmainnah','credential' => NULL,'description' => NULL,'email' => 'mutmainnahelisyah@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$zY2NyfqI8NvhRJIGslByEOEGdYzynZEK0fwOwX0hIJRVcFHHM89Sa','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Elisyah Mutmainnah&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-10-21 09:05:37','updated_at' => '2022-10-21 09:05:37'),
            array('id' => '16','name' => 'Firza Yusri Ghausa','name_slug' => 'firza-yusri-ghausa','credential' => NULL,'description' => NULL,'email' => 'firzayusrighausa@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$pG93Q.o506fJXrZZVSYrR.VsNsly0NDiqWNvjfWtvd8mrSXXrdwEm','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Firza Yusri Ghausa&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-10-21 09:05:50','updated_at' => '2022-10-21 09:05:50'),
            array('id' => '18','name' => 'sad1','name_slug' => 'sad1','credential' => NULL,'description' => NULL,'email' => 'sad@yand.com','email_verified_at' => NULL,'password' => '$2y$10$8/VEbumKm0G0OWtoMQ4rFeNU2pyXfgm4.L95xmvBXeFHylwZsRPJ.','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=sad1&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-11-11 07:31:52','updated_at' => '2022-11-11 07:31:52'),
            array('id' => '20','name' => 'deneme1','name_slug' => 'deneme1','credential' => NULL,'description' => NULL,'email' => 'deneme1@ya.com','email_verified_at' => NULL,'password' => '$2y$10$iC/iHy36NEKlBFmEK0zQHulsBEKggbsa.85v9IbC7lNYSx/vI6Pp.','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=deneme1&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-11-26 16:42:49','updated_at' => '2022-11-26 16:42:49'),
            array('id' => '21','name' => 'fg','name_slug' => 'fg','credential' => NULL,'description' => NULL,'email' => 'dgdfdsq@fc.com','email_verified_at' => NULL,'password' => '$2y$10$tvIgoqdztrJ57TPDQI0ydeUU5R5ExvUcEjcWfBFMLi99K92chfDe2','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=fg&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2022-12-05 17:45:55','updated_at' => '2022-12-05 17:45:55'),
            array('id' => '22','name' => 'Waqar Ali','name_slug' => 'waqar-ali','credential' => NULL,'description' => NULL,'email' => 'homeremedytc@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$Dc/jVe8aSSPxjDp.Q2mbE.EJnPY1KYiF3kcIgygreFinxVcu88vHu','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Waqar Ali&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-01-28 12:10:42','updated_at' => '2023-01-28 12:10:42'),
            array('id' => '32','name' => 'ardyan','name_slug' => 'ardyan','credential' => NULL,'description' => NULL,'email' => 'ojankontol@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$z5QlaSe/Rg0MZfL5orCQDO92GIJIxV6aa7.xEbTH/ZeBptBYhHxRC','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=ardyan&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-03-09 21:26:47','updated_at' => '2023-03-09 21:26:47'),
            array('id' => '35','name' => 'Jesunifemi Oluwafemi','name_slug' => 'jesunifemi-oluwafemi','credential' => NULL,'description' => NULL,'email' => 'swinsonfire@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$q75QoIW9rTQAu4RmPKstneXJzj4UxlMjYp606KBvEVi2ektga7d3u','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Jesunifemi Oluwafemi&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-04-12 17:28:28','updated_at' => '2023-04-12 17:28:28'),
            array('id' => '36','name' => 'whoa','name_slug' => 'whoa','credential' => NULL,'description' => NULL,'email' => 'whoa@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$LDmvTeI.vPcuGxjvSOMv2O162T8FrH3GfIsSh.6woWjrx0alnkgse','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=whoa&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-04-14 14:40:47','updated_at' => '2023-04-14 14:40:47'),
            array('id' => '37','name' => 'Rashed','name_slug' => 'rashed','credential' => NULL,'description' => NULL,'email' => 'admin@demo.com','email_verified_at' => NULL,'password' => '$2y$10$PSxgTSPtaxrLEYgQZNQW7.Zc0Ca5LLd8T6ygL6V1XNxUEsNOcd1FC','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Rashed&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-04-17 11:23:43','updated_at' => '2023-04-17 11:23:43'),
            array('id' => '38','name' => 'raj','name_slug' => 'raj','credential' => NULL,'description' => NULL,'email' => 'rajeev@grandviewresearch.com','email_verified_at' => NULL,'password' => '$2y$10$c74sXasFtI1hbstiFrG.Hu0UCW01depWWq1VU6e6DGNVHJf4olYYm','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=raj&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-05-24 15:07:15','updated_at' => '2023-05-24 15:07:15'),
            array('id' => '39','name' => 'ojanbgst','name_slug' => 'ojanbgst','credential' => NULL,'description' => NULL,'email' => 'ojanbgst@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$O3cmAM4eVq26HUTYIaSlDOSc1zeL0ptAscHQKdF9uZY9IrHTdUW6q','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=ojanbgst&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-05-28 10:52:52','updated_at' => '2023-05-28 10:52:52'),
            array('id' => '41','name' => 'hello1212','name_slug' => 'hello1212','credential' => NULL,'description' => NULL,'email' => 'yatojey813@msback.com','email_verified_at' => NULL,'password' => '$2y$10$FTP6gL3h1Bk.yaWliNj5/e2CPIbNKb1u1C9UljkRe3y/1L/ACccka','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=hello1212&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-07-14 20:55:10','updated_at' => '2023-07-14 20:55:10'),
            array('id' => '42','name' => 'Testing','name_slug' => 'testing','credential' => NULL,'description' => NULL,'email' => 'ngetesajadulu@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$GBXxf3N6Cy00bl5ojtdw1.VI/zNF6mvPULBw1r86upSpLkjMfegMW','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Testing&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-07-20 14:22:04','updated_at' => '2023-07-20 14:22:04'),
            array('id' => '43','name' => 'lemrisinaga@gmail.com','name_slug' => 'lemrisinaga-at-gmailcom','credential' => NULL,'description' => NULL,'email' => 'lemrisinaga@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$rTqAY9zGXNU4gUJ/588PfeVBH9NrmKhyY2RFQKOxBVdGVXhqYhZp6','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=lemrisinaga@gmail.com&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-07-21 09:37:11','updated_at' => '2023-07-21 09:37:11'),
            array('id' => '46','name' => 'Aditiya Mahendra','name_slug' => 'aditiya-mahendra','credential' => NULL,'description' => NULL,'email' => 'aditiyamahendra08@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$J4CMSaUkC/t7rNXsJxbOCOMzzIm3upmgVZ..FLqyx6h/6.Y8zxeZe','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Aditiya Mahendra&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-08-14 10:17:04','updated_at' => '2023-08-14 10:17:04'),
            array('id' => '48','name' => 'Ibeta','name_slug' => 'ibeta','credential' => NULL,'description' => NULL,'email' => 'iremsuoz15@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$N9uLtqAcqqZinyoiFGTPK.meJRQe0Llf.VNeRkwk7QFSmI.2zVPXm','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Ibeta&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-09-27 03:50:43','updated_at' => '2023-09-27 03:50:43'),
            array('id' => '49','name' => 'RC Po','name_slug' => 'rc-po','credential' => NULL,'description' => NULL,'email' => 'kayom52702@estudys.com','email_verified_at' => NULL,'password' => '$2y$10$A8HJw7fOb9DzXgt2z02zxueah5/69oNmKANfI5KuMsgh2dNIVe.Fm','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=RC Po&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-10-04 14:28:31','updated_at' => '2023-10-04 14:28:31'),
            array('id' => '50','name' => 'gilang','name_slug' => 'gilang','credential' => NULL,'description' => NULL,'email' => 'gilang@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$jdgyYHhMdEWshA7H8YO2lOiP4N6vqvUI/RcmAVSsqWxYB319grQhu','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=gilang&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-10-15 21:28:43','updated_at' => '2023-10-15 21:28:43'),
            array('id' => '52','name' => 'Imam Nuralim','name_slug' => 'imam-nuralim','credential' => NULL,'description' => NULL,'email' => 'imamalim@gmail.com','email_verified_at' => NULL,'password' => '$2y$10$YxtjKWkYqvzyLTa8dOKQXONTwWmYKMLuq6jpbck1GAnap8/j6us9O','provider_id' => NULL,'avatar' => 'https://ui-avatars.com/api/?name=Imam Nuralim&background=868e96&color=fff','country' => NULL,'role' => 'user','remember_token' => NULL,'created_at' => '2023-10-22 03:46:02','updated_at' => '2023-10-22 03:46:02'),
        );

        for ($i=0; $i < count($users); $i++) {
            DB::table('users')->insert([
                'username' => $users[$i]['name'],
                'username_slug' => $users[$i]['name_slug'],
                'credential' => $users[$i]['credential'],
                'description' => $users[$i]['description'],
                'email' => $users[$i]['email'],
                'password' => $users[$i]['password'],
                'image' => null
            ]);
        }

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

            $title = 'Generated example question: what is '.$topic_names[$i].'?';

            DB::table('questions')->insert([
                'user_id' => 1,
                'title' => $title,
                'title_slug' => str()->slug($title),
                'created_at' => now(),
            ]);
        }
    }
}
