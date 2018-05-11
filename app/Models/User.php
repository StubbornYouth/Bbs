<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
