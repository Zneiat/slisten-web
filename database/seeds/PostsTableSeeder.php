<?php

use Illuminate\Database\Seeder;
use Slisten\Comment;
use Slisten\Post;

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
            $userid = rand(1, 3);
            $post = new Post();
            $post->content = encrypt(str_random(rand(300, 1000)));
            $post->user_id = $userid;
            if ($post->save()) {
                for ($i = 0; $i < rand(0, 5); $i++) {
                    $comment = new Comment();
                    $comment->comment = encrypt(str_random(rand(10, 40)));
                    $comment->post_id = $post->id;
                    $comment->user_id = $userid;
                    $comment->save();
                }
            }
        }
    }
}
