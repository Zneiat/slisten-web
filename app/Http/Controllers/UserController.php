<?php

namespace Slisten\Http\Controllers;

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
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->id = $this->user->id;
            
            return $next($request);
        });
    }
    
    public function index(Request $request)
    {
        $posts = Post::query();
        
        if (!$this->user->matchRole([User::ROLE_ADMIN])) {
            $posts = $posts->where(['user_id' => $this->id]);
        }
    
        $posts = $posts->paginate(15);
        
        return view('user.index', ['posts' => $posts]);
    }
    
    public function postView(Request $request, $postId)
    {
        $post = Post::query()->where(['id' => $postId])->first();
        
        if (!$post)
            abort(404);
        
        if ($post->user_id !== $this->id && !$this->user->matchRole([User::ROLE_ADMIN]))
            abort(403);
        
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
        
        $validator = Validator::make($request->all(), [
            'content'   => 'required|string',
            'signature' => 'sometimes|nullable|max:25|string',
        ]);
        
        if ($validator->fails())
            return response()->json([
                'success'      => false,
                'error_inputs' => $validator->messages(),
            ], 200);
        
        $input = $request->all();
        
        $post = new Post();
        $post->content = encrypt($input['content']);
        $post->sign = $input['sign'] ?? '';
        $post->user_id = $this->id;
        
        if ($post->save()) {
            return response()->json([
                'success' => true,
                'msg'     => '已成功提交',
                'post_id' => $post->id,
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'msg'     => '服务器异常，提交失败',
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