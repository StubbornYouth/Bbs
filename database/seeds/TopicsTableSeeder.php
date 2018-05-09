<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        //获得faker实例
        $faker=app(Faker\Generator::class);
        //获取id列的所有id集合并将其转化为数组
        $user_ids=User::all()->pluck('id')->toArray();

        $category_ids=Category::all()->pluck('id')->toArray();

        $topics = factory(Topic::class)->times(50)->make()->each(function ($topic, $index) use($faker,$user_ids,$category_ids) {
            //话题模型的user_id 与 category_id随机从数组中选取
            $topic->user_id=$faker->randomElement($user_ids);
            $topic->category_id=$faker->randomElement($category_ids);

        });

        Topic::insert($topics->toArray());
    }

}

