<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 找回密码 之 发送重置密码邮件 控制器
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * 发送重置密码邮件 成功响应
     *
     * @inheritdoc
     */
    protected function sendResetLinkResponse($response)
    {
        $msg = ['success' => true, 'status' => trans($response)];
        
        if (request()->expectsJson()) {
            // 响应 Json
            return response()->json($msg, 200);
        }
        
        return back()->with($msg);
    }
    
    /**
     * 发送重置密码邮件 错误响应
     *
     * @inheritdoc
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $errors = ['email' => trans($response)];
        
        if ($request->expectsJson()) {
            // 响应 Json
            return response()->json($errors, 422);
        }
        
        return back()->withErrors($errors);
    }
}
