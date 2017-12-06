<?php

namespace Slisten\Http\Controllers\User;

use Slisten\Comment;
use Slisten\User;
use Validator;
use Auth;
use Illuminate\Http\Request;
use Slisten\Post;

class UserController extends UserControllerBase
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index(Request $request)
    {
        $posts = Post::query();
        
        if (!$this->isGod)
            $posts = $posts->where(['user_id' => $this->userId]);
        
        $posts = $posts->latest()->paginate(15);
        
        return view('user.index', [
            'posts' => $posts,
            'isGod' => $this->isGod,
        ]);
    }
    
    public function postView(Request $request, $postId)
    {
        /** @var Post $post */
        $post = Post::query()->where(['id' => $postId])->first();
        
        if (!$post)
            abort(404);
        
        if (($post->user_id !== $this->userId) && (!$this->isGod))
            abort(403);
    
        $comments = Comment::query()->where(['post_id' => $post->id])->get();
        
        if ($this->isGod) {
            // 标为已读
            $post->setHasRead();
        }
        
        return view('user.post-view', ['post' => $post, 'comments' => $comments]);
    }
    
    public function writeForm(Request $request)
    {
        return view('user.write');
    }
}