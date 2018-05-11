@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img class="thumbnail img-responsive" src="{{ $user->head }}" width="300px" height="300px">
                    </div>
                    <div class="media-body">
                        <hr>
                        <h4><strong>个人简介</strong></h4>
                        <p>{{ $user->introduction }} </p>
                        <hr>
                        <h4><strong>注册于</strong></h4>
                        <p>{{$user->created_at->diffForHumans()}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <span>
                    <h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                </span>
            </div>
        </div>
        <hr>

        {{-- 用户发布的内容 --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    {{--if_query()是判断get参数是否与定义的相同--}}
                    <li class="{{ active_class(if_query('tab', null)) }}">
                        <a href="{{ route('users.show', $user->id) }}">Ta 的话题</a>
                    </li>
                    <li class="{{ active_class(if_query('tab', 'replies')) }}">
                        <a href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">Ta 的回复</a>
                    </li>
                </ul>
                @if (if_query('tab', 'replies'))
                    {{--rencent方法就是基类modle类的一个方法 本地作用域 接收当前的数据库语句 添加上排序的功能 with方法防止N+1--}}
                    @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
                @else
                    @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
                @endif
            </div>
        </div>

    </div>
</div>
@stop