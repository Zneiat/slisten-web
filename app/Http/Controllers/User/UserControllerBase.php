<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\Controller;
use App\User;

class UserControllerBase extends Controller
{
    /** @var User|null */
    protected $user;
    protected $userId;
    protected $userHavePower;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->userId = $this->user->id;
            $this->userHavePower = $this->user->matchRole([User::ROLE_ADMIN, User::ROLE_GOD]);
            
            return $next($request);
        });
    }
}
