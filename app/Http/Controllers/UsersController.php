<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function __construct()
    {
        //权限控制 黑名单 允许未登录用户的访问的页面
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {
        //compact将user变量转为关联数组
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request,ImageUploadHandler $uploader,User $user)
    {
        $this->authorize('update', $user);
        //将数据传递给data
        $data=$request->all();
        //判断用户是否上传图片
        if ($request->head) {
            //调用图片上传类
            $result = $uploader->save($request->head, 'userHead', $user->id,396);
            //判断返回值
            if ($result) {
                $data['head'] = $result['path'];
            }
        }
        $user->update($data);
        //with() 即传递一个session信息
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
