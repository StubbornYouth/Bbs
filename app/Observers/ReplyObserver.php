<?php

namespace App\Observers;

use App\Models\Reply;

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
    }


    public function updating(Reply $reply)
    {
        //
    }
}