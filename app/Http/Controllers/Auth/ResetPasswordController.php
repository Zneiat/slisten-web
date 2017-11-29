<?php

namespace Slisten\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Slisten\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 找回密码 之 重置密码 控制器
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * 重置密码成功重定向
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    
    /**
     * 重置密码 成功响应
     *
     * @inheritdoc
     */
    protected function sendResetResponse($response)
    {
        $msg = ['success' => true, 'status' => trans($response)];
        
        if (request()->expectsJson()) {
            // 响应 Json
            return response()->json($msg, 200);
        }
        
        return redirect($this->redirectPath())->with($msg);
    }
    
    /**
     * 重置密码 错误响应
     *
     * @inheritdoc
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        $errors = ['success' => true, 'email' => trans($response)];
        
        if ($request->expectsJson()) {
            // 响应 Json
            return response()->json($errors, 422);
        }
        
        return redirect()->back()
            ->withInput($request->only('email'))
            ->withErrors($errors);
    }
}
