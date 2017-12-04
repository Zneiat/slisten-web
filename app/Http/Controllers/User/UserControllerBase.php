<?php

namespace Slisten\Http\Controllers\User;

use Auth;
use Slisten\Http\Controllers\Controller;
use Slisten\User;

class UserControllerBase extends Controller
{
    /** @var User|null */
    protected $user;
    protected $userId;
    protected $isAdmin;
    protected $isGod;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->userId = $this->user->id;
            $this->isAdmin = $this->user->matchRole([User::ROLE_ADMIN]);
            $this->isGod = $this->user->matchRole([User::ROLE_GOD]);
            
            return $next($request);
        });
    }
}
