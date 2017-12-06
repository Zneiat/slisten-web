<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 登录 控制器
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * 登录成功重定向
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * 处理请求数据为一个可用凭证
     *
     * @inheritdoc
     */
    protected function credentials(Request $request)
    {
        // $field = filter_var($request->get('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $field = $this->username();
        
        return [
            'name' => $request->get($this->username()),
            'password' => $request->input('password'),
        ];
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @inheritdoc
     */
    public function username()
    {
        return 'username';
    }
    
    /**
     * 登录 成功响应
     *
     * @inheritdoc
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        
        $this->clearLoginAttempts($request);
    
        if ($request->expectsJson()) {
            // 响应 Json
            return response()->json($this->guard()->user(), 200);
        }
        
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}