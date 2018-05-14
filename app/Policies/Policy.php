<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before($user, $ability)
	{
	    // if ($user->isSuperAdmin()) {
	    // 		return true;
	    // }

        //授权策略的基类 before()方法在策略授权的其它方法之前调用
        //返回true 直接通过授权，无需在意其它授权方法
        //返回false 拒绝用户的所有授权
        //返回null 通过其它授权方法决定授权通过与否

        //如果用户拥有管理员权限，直接通过授权
        if($user->can('manage_contents')){
            return true;
        }
	}
}
