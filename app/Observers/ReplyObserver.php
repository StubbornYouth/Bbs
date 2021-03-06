<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //过滤XSS攻击 第二个参数是过滤规则
        $reply->content=clean($reply->content,'user_topic_body');
    }


    public function created(Reply $reply)
    {
        //当回复时,topic的回复数量自增 第一个是参数名 第二个参数是增加数
        $reply->topic->increment('reply_count',1);

        //通知作者话题被回复了
        $reply->topic->user->notify(new TopicReplied($reply));
    }


    public function updating(Reply $reply)
    {
        //
    }

    public function deleted(Reply $reply){
        //回复被删除时,话题回复数减1
        $reply->topic->decrement('reply_count',1);
    }
}