<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\User as UserResource;


class UsersController extends ApiController
{
    public function store(UserRequest $request)
    {
        // $verifyData = \Cache::get($request->verification_key);

        // if (!$verifyData) {
        //     return $this->response->error('验证码已失效', 422);
        // }

        // if (!hash_equals($verifyData['code'], $request->verification_code)) {
        //     // 返回401
        //     return $this->response->errorUnauthorized('验证码错误');
        // }

        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        // \Cache::forget($request->verification_key);

        return $this->created('创建成功');
    }

    public function me()
    {
        return $this->success(new UserResource(\Auth::guard('api')->user()));
    }

    public function update(UserRequest $request)
    {
        $user = \Auth::guard('api')->user();

        $attributes = $request->only(['name', 'email']);

        // if ($request->avatar_image_id) {
        //     $image = Image::find($request->avatar_image_id);

        //     $attributes['avatar'] = $image->path;
        // }
        $user->update($attributes);

        return $this->success(new UserResource($user));
    }

}
