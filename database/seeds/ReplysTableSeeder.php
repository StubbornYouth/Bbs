<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        //获得faker实例
        $faker=app(Faker\Generator::class);
        //所有用户
        $user_id=User::all()->pluck('id')->toArray();
        //所有话题
        $topic_id=Topic::all()->pluck('id')->toArray();

        $replys = factory(Reply::class)->times(50)->make()->each(function ($reply, $index) use($user_id,$topic_id,$faker) {
            //随机从数组中取一个id
            $reply->user_id=$faker->randomElement($user_id);

            $reply->topic_id=$faker->randomElement($topic_id);
        });

        Reply::insert($replys->toArray());
    }

}

