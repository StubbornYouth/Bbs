<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         $categories = [
            [
                'name'        => '分享',
                'description' => '分享知识，分享经验',
            ],
            [
                'name'        => '教程',
                'description' => '获取技巧、汲取知识',
            ],
            [
                'name'        => '问答',
                'description' => '互相促进，互帮互助',
            ],
            [
                'name'        => '公告',
                'description' => '站点公告',
            ],
        ];
        //插入基础数据
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //清空数据表
        DB::table('categories')->truncate();
    }
}
