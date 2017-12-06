<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Comment;
use App\Post;
use function foo\func;
use Validator;
use Illuminate\Http\Request;
use App\User;

class UserApiController extends UserControllerBase
{
    protected $inputs = [];
    
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware(function (Request $request, $next) {
            if (!$request->wantsJson()) {
                return $this->error('请求方式有误');
            }
    
            $this->inputs = $request->all();
            
            return $next($request);
        });
    }
    
    private function inputError($errorMessages)
    {
        return $this->error('输入有误', [
            'error_inputs' => $errorMessages,
        ]);
    }
    
    public function write(Request $request)
    {
        $validator = Validator::make($this->inputs, [
            'content'   => 'required|string',
            'signature' => 'sometimes|nullable|max:25|string',
        ]);
        
        if ($validator->fails()) {
            return $this->inputError($validator->messages());
        }
        
        $post = new Post();
        $post->content = $this->inputs['content'];
        $post->sign = $this->inputs['sign'] ?? '';
        $post->user_id = $this->userId;
        
        if ($post->save()) {
            return $this->success('已成功投递', [
                'post_id' => $post->id,
            ]);
        }
        else {
            return $this->error('服务器异常，投递失败');
        }
    }
    
    public function messageSend(Request $request)
    {
        $validator = Validator::make($this->inputs, [
            'post_id' => 'required|numeric',
            'content' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return $this->inputError($validator->messages());
        }
    
        /** @var Post $post */
        $post = Post::query()->where(['id' => $this->inputs['post_id']])->first();
        if (!$post || (!$post->isMine() && !$this->userHavePower)) {
            return $this->error('信件源未找到，也许已被删除');
        }
        
        $comment = new Comment();
        $comment->comment = $this->inputs['content'];
        $comment->post_id = $post->id;
        $comment->user_id = $this->userId;
        
        if ($comment->save()) {
            if ($this->user->matchRole([User::ROLE_ADMIN, User::ROLE_GOD])) { // 我是管理员
                $post->setHasRead($post->user_id, false); // 发信人 标记未读
            } else if ($this->userId === $post->user_id) { // 我是发信人
                User::all()->each(function (User $item, $key) use ($post) {
                    if ($item->matchRole([User::ROLE_ADMIN, User::ROLE_GOD])) {
                        $post->setHasRead($item->id, false); // 管理员 标记未读
                    }
                });
            }
                
            return $this->success('已成功发送', [
                'comment_id' => $comment->id,
            ]);
        }
        else {
            return $this->error('服务器异常，投递失败');
        }
    }
}
