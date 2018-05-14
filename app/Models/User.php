<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    //Notifiable包含着用来发送通知的方法notify()
    use Notifiable {
        notify as protected laravelNotify;
    }
    //重写发送通知方法
    public function notify($instance){
        //如果通知的用户是当前用户,就不必通知了
        if($this->id==Auth::id()){
            return;
        }
        //未读消息加一
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    //未读消息设置为已读
    public function markAsRead(){
        $this->notification_count=0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','head','introduction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //获取当前用户的话题
    public function topics(){
        //一对多关系
        return $this->hasMany(Topic::class);
    }

    //为了简化授权策略
    public function isAuthorOf($model){
        return $this->id === $model->user_id;
    }
    //一个用户对应多个回复
    public function replies(){
        return $this->hasMany(Reply::class);
    }
}
