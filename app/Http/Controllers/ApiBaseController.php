<?php


namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiBaseController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 返回成功响应
     * @param mixed $data
     * @param string $message
     *
     * @return JsonResponse
     * */
    public function jsonResponse($data = [], $message = '请求成功')
    {
        return response()->json([
            'return_code' => '10000',
            'result_code' => 'SUCCESS',
            'data' => $data,
            'message' => $message,
        ]);
    }

    /**
     * 返回异常响应
     * @param string $code
     * @param string $message
     *
     * @return JsonResponse
     * */
    public function errorResponse($code = '', $message = '请求异常')
    {
        return response()->json([
            'return_code' => $code,
            'result_code' => 'FAILED',
            'data' => null,
            'message' => $message,
        ]);
    }
}
