<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    //使用 now() 和 toDateTimeString() 来创建格式如 2017-10-13 18:42:40 的时间戳
    $now=Carbon::now()->toDateTimeString();
    //返回数组填充数据
    return [
        //生成名称
        'name' => $faker->name,
        //生成安全邮箱
        'email' => $faker->unique()->safeEmail,
        //生成加密密码
        'password' => $password ?: $password=bcrypt('secret'), // secret
        //生成记住我的令牌
        'remember_token' => str_random(10),
        //随机生成小段落文本
        'introduction' => $faker->sentence(),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});
