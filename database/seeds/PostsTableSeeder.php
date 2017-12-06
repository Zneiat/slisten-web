<?php

use Illuminate\Database\Seeder;
use App\Comment;
use App\Message;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($o = 0; $o < rand(10, 50); $o++) {
            $faker = Faker\Factory::create();
            $userid = rand(1, 3);
            $post = new Post();
            $post->content = $faker->text(rand(300, 1000));
            $post->user_id = $userid;
            if ($post->save()) {
                for ($i = 0; $i < rand(0, 5); $i++) {
                    $comment = new Comment();
                    $comment->comment = $faker->text(rand(10, 40));
                    $comment->post_id = $post->id;
                    $comment->user_id = $userid;
                    $comment->save();
                }
            }
        }
    }
}
