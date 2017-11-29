<?php

namespace Slisten\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * 用户中心主页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('user.index');
    }
    
    public function admin(Request $request)
    {
        $request->user()->checkRole([User::ROLE_ADMIN]);
    
        return response()->json([
            'errors' => ['还在建设中...'],
        ])->setStatusCode(404);
    }
}