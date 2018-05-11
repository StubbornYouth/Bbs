<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;


class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Topic $topic)
    {
        $this->topic=$topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 请求百度 API 接口进行翻译
        $slug = app(SlugTranslateHandler::class)->translate($this->topic->title);

        //由于引入了 SerializesModels 模型实例会被序列化和反序列化，队列构造器只会序列化模型的id
        // 为了避免模型监控器死循环调用，我们使用 DB 类直接对数据库进行操作
        //handle 方法会在队列任务执行时被调用。
        //任务中要避免使用 Eloquent 模型接口调用，如：create(), update(), save() 等操作。否则会陷入调用死循环
        \DB::table('topics')->where('id', $this->topic->id)->update(['slug' => $slug]);
    }
}
