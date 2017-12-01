<?php

namespace Slisten\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Slisten\Post;

class UserController extends Controller
{
    protected $user;
    protected $id;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->id   = $this->user->id;
            return $next($request);
        });
    }
    
    /**
     * 用户中心主页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $posts = Post::query()->where(['user_id' => $this->id])->get();
        
        return view('user.index', ['posts' => $posts]);
    }
    
    public function showWriteForm(Request $request)
    {
        return view('user.write');
    }
    
    public function write(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|string',
        ]);
    
        $input = $request->all();
        
        $post = new Post();
        $post->content = $input['content'];
        $post->user_id = $this->id;
        $post->save();
        
        return back()->with('success', '已发送 ID=' . $post->id);
    }
    
    public function admin(Request $request)
    {
        $request->user()->checkRole([User::ROLE_ADMIN]);
    
        return response()->json([
            'errors' => ['还在建设中...'],
        ])->setStatusCode(404);
    }
}