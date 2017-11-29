<?php

namespace Slisten\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Slisten\User;
use Slisten\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 注册 控制器
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * 注册成功重定向
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
     * 表单验证器
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * 表单验证成功后创建新的用户
     *
     * @param  array  $data
     * @return \Slisten\User|mixed
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'     => $data['username'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role'     => User::ROLE_USER,
        ]);
        
        return $user;
    }
    
    /**
     * 处理申请的注册申请
     *
     * @inheritdoc
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        event(new Registered($user = $this->create($request->all())));
        
        // $this->guard()->login($user); // 注册后随即登录
        
        return $this->registered($request, $user);
    }
    
    /**
     * 注册成功 响应
     *
     * @inheritdoc
     */
    protected function registered(Request $request, $user)
    {
        $msg = ['success' => true, 'status' => '注册成功！<br>请查阅我们发送的邮件并激活帐号'];
        
        if ($request->expectsJson()) {
            // 响应 Json
            return response()->json($msg, 200);
        }
    
        return back()->with($msg);
    }
}