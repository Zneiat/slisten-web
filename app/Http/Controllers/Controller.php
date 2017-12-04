<?php

namespace Slisten\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * 响应附加的 Header
     * @var array
     */
    private $withHeaders = [
        'X-Project-Link' => QWQ_PROJECT_LINK,
        'X-Author-Link' => QWQ_AUTHOR_LINK
    ];
    
    /**
     * 响应 - 正确结果
     *
     * @param string $msg 正确信息
     * @param array $data 附带正确数据
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function success($msg, array $data = [])
    {
        $response = [
            'success' => true,
            'status'  => 'success',
            'msg'     => $msg,
            'data'    => $data
        ];
        
        return response()
            ->json($response)
            ->withHeaders($this->withHeaders);
    }
    
    /**
     * 响应 - 错误结果
     *
     * @param string $msg 错误信息
     * @param array $data 附带错误数据
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    protected function error($msg, array $data = [])
    {
        $response = [
            'success' => false,
            'status'  => 'error',
            'msg'     => $msg,
            'data'    => $data
        ];
        
        return response()
            ->json($response)
            ->withHeaders($this->withHeaders);
    }
}
