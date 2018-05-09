<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    //随机生成小段落文本
    $sentence=$faker->sentence();

    //随机生成一个月以内时间
    $updated_at=$faker->dateTimeThisMonth();

    //创建时间要比生成时间早
    $created_at=$faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $sentence,
        //大段文本
        'body' => $faker->text(),
        'excerpt' => $sentence,
        'updated_at' => $updated_at,
        'created_at' => $created_at,
    ];
});
