<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获取faker实例
        $faker=app(Faker\Generator::class);

          // 头像假数据
        $avatars = [
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];

        //生成数据集合
        //factory()方法通过指定模型加载其工厂设置 times()生成模型的数量 make()将结果生成为集合对象 each()集合对象的一个方法 迭代集合并将它返回给匿名函数
        //use()方法是匿名函数提供的本地变量传递机制，将要使用的本地变量通过use传递
        $users = factory(User::class)->times(10)->make()->each(function ($user,$index) use ($faker,$avatars){
            //从数组中随机选择一个赋值
            $user->head = $faker->randomElement($avatars);
        });

         // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        //插入到数据库中
        User::insert($user_array);

        // 单独处理第一个用户的数据
        $user = User::find(1);
        $user->name = 'Stubborn';
        $user->email = 'stubbornyouth@163.com';
        $user->head = 'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200';
        $user->save();

        //初始化用户角色 将1号用户指派为站长
        //assignRole() 是HasRoles中定义的 User模型加载了它
        $user->assignRole('Founder');

        //将2号指派为管理员
        $user = User::find(2);
        $user->assignRole('Maintainer');

        //$user->hasRole('角色名') 判断是否是该角色
        //$user->hasAnyRole(Role::all()) 是否拥有至少一个角色
        //$user->hasAllRoles(Role::all()) 是否拥有所有角色

        //$user->can('权限名') 检查是否拥有某个权限
        //$role->hasPermissonTo('权限名') 检查角色是否拥有摸个属性
        //$user->givePermissionTo('权限名') 为用户添加直接权限
        //$user->getDirectPermissions() 为用户获取所有直接权限
    }
}
