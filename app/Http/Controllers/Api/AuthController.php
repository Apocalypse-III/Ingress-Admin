<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\ApiBaseController;
use App\Mail\RegisterConfirm;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Auth\AuthenticationException;
use Mail;
use Validator;

class AuthController extends ApiBaseController
{
    public function register()
    {
        $validate = Validator::make($this->request->all(), [
            'name' => ['required', 'min:4', 'max:16', 'bail'],
            'email' => ['required', 'max:255', 'email', 'unique:users', 'bail'],
            'password' => ['required', 'min:5', 'max:255', 'confirmed', 'bail']
        ], [
            'name.required' => '名字不能为空',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
            'name.unique' => '邮箱已被注册',
            'password.required' => '密码不能为空',
            'password.confirmed' => '密码验证失败',
        ]);

        if ($validate->fails()) return $this->errorResponse(40001, $validate->errors()->first());

        $params = $this->request->all();

        Mail::to('genesis489449701@gmail.com')->send(new RegisterConfirm());

        return $this->jsonResponse($params);
    }

    public function login()
    {
        $validate = Validator::make($this->request->all(), [
            'email' => ['required', 'email', 'bail'],
            'password' => ['required', 'bail']
        ], [
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
            'password.required' => '密码不能为空',
        ]);

        if ($validate->fails()) return $this->errorResponse(40000, $validate->errors()->first());

        $credentials = $this->request->only(['email', 'password']);

        if(! Auth::attempt($credentials)) {
            throw new AuthenticationException(
                'Unauthenticated.'
            );
        }

        $user = $this->request->user();

        $tokenResult = $user->createToken('Authorization');

        return $this->jsonResponse($tokenResult->accessToken);
    }

    public function logout()
    {
        $this->request->user()->token()->revoke();
        return $this->jsonResponse(null, '退出成功');
    }

    public function userinfo()
    {
        return $this->jsonResponse($this->request->user());
    }
}
