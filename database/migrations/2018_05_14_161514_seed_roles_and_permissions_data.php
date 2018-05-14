<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //清除缓存
        app()['cache']->forget('spatie.premission.cache');

        //先创建权限
        //管理站点内容 (管理员与用户的区别)
        Permission::create(['name'=>'manage_contents']);
        //管理用户 (管理员与站长区别)
        Permission::create(['name'=>'manage_users']);
        //站长独有权限 联系邮箱 seo设置等
        Permission::create(['name'=>'edit_settings']);
        //创建站长权限
        //角色
        $founder = Role::create(['name'=>'Founder']);
        //赋予角色权限
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_settings');

        //创建管理员角色,并赋予权限
        $maintainer=Role::create(['name'=>'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //清除缓存
        app()['cache']->forget('spatie.premission.cache');

        //清空所有数据表数据
        $tableNames=config('permission.table_names');
        //负责解除自动填充操作限制
        Model::unguard();
        //删除角色权限关联表
        DB::table($tableNames['role_has_permissions'])->delete();
        //删除模型角色关联表
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        //负责恢复限制
        Model::reguard();
    }
}
