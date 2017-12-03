<?php

namespace Slisten\Http\Controllers;

use Slisten\Comment;
use Slisten\User;
use Validator;
use Auth;
use Illuminate\Http\Request;
use Slisten\Post;

class UserController extends Controller
{
    /** @var User|null */
    protected $user;
    protected $id;
    protected $isAdmin;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->id = $this->user->id;
            $this->isAdmin = $this->user->matchRole([User::ROLE_ADMIN]);
            
            return $next($request);
        });
    }
    
    public function index(Request $request)
    {
        $posts = Post::query();
        
        if (!$this->isAdmin)
            $posts = $posts->where(['user_id' => $this->id]);
    
        $posts = $posts->latest()->paginate(15);
        
        return view('user.index', ['posts' => $posts, 'isAdmin' => $this->isAdmin]);
    }
    
    public function postView(Request $request, $postId)
    {
        $post = Post::query()->where(['id' => $postId])->first();
        
        if (!$post)
            abort(404);
        
        if ($post->user_id !== $this->id && !$this->isAdmin)
            abort(403);
        
        if ($this->isAdmin) {
            // 标为已读
            $post->setAdminHasRead();
        }
        
        return view('user.post-view', ['post' => $post]);
    }
    
    public function showWriteForm(Request $request)
    {
        return view('user.write');
    }
    
    public function write(Request $request)
    {
        if (!$request->wantsJson())
            return response()->json([
                'success' => false,
                'msg'     => '请求方式有误',
            ]);
    
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'content'   => 'required|string',
            'signature' => 'sometimes|nullable|max:25|string',
        ]);
        
        if ($validator->fails())
            return response()->json([
                'success'      => false,
                'error_inputs' => $validator->messages(),
            ], 200);
        
        $post = new Post();
        $post->content = encrypt($input['content']);
        $post->sign = $input['sign'] ?? '';
        $post->user_id = $this->id;
        
        if ($post->save()) {
            return response()->json([
                'success' => true,
                'msg'     => '已成功投递',
                'post_id' => $post->id,
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'msg'     => '服务器异常，投递失败',
            ]);
        }
    }
    
    public function sendMessage(Request $request)
    {
        if (!$request->wantsJson())
            return response()->json([
                'success' => false,
                'msg'     => '请求方式有误',
            ]);
    
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'post_id'   => 'required|numeric',
            'content'   => 'required|string'
        ]);
        
        $post = Post::query()->where(['id' => $input['post_id']])->first();
        if (!$post || (!$this->isAdmin && !$post->isMine())) {
            return [
                'success' => false,
                'msg'     => '没有找到信件',
            ];
        }
        
        if ($validator->fails())
            return response()->json([
                'success'      => false,
                'error_inputs' => $validator->messages(),
            ], 200);
    
        $comment = new Comment();
        $comment->comment = encrypt($input['content']);
        $comment->post_id = $post->id;
        $comment->user_id = $this->id;
        
        if ($comment->save()) {
            return response()->json([
                'success' => true,
                'msg'     => '已成功发送',
                'comment_id' => $comment->id,
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'msg'     => '服务器异常，投递失败',
            ]);
        }
    }
    
    public function admin(Request $request)
    {
        $request->user()->checkRole([User::ROLE_ADMIN]);
        
        return response()->json([
            'errors' => ['还在建设中...'],
        ])->setStatusCode(404);
    }
}