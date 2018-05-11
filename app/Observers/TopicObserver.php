<?php

namespace App\Observers;

use App\Models\Topic;
use App\Jobs\TranslateSlug;
//生命周期时间点进行监控
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
//话题模型观察器 需要在 AppServiceProvider类中进行注册
class TopicObserver
{
    //模型首次创建时会触发creating和updating
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }
    //模型已经存在数据库并且调用save方法 将会触发 updated和updating事件
    //saved和saving会在以上两种情况下被触发
    //Eloquent 观察器允许我们对给定模型中进行事件监控，观察者类里的方法名对应 Eloquent 想监听的事件。每种方法接收 model 作为其唯一的参数。
    public function saving(Topic $topic)
    {
        //在保存话题前使用clean()方法过滤话题内容的XSS攻击 第二个参数指明使用配置文件中的哪个设置
        $topic->body = clean($topic->body,'user_topic_body');

        //make_excerpt() 是我们自定义的辅助方法
        $topic->excerpt = make_excerpt($topic->body);

         // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        //$this->app 属性访问容器。

            //$topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);


    }

    //实例创建或编辑数据入库后触发
    public function saved(Topic $topic){
        //任务分发 在saved方法中，避免创建时实例id不存在，无法分发给队列
        if ( ! $topic->slug) {
            dispatch(new TranslateSlug($topic));
        }
    }
}