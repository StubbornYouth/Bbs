<?php

//此方法会将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制
function route_class(){
    return str_replace('.','_',Route::currentRouteName());
}
//处理文本摘录 有利于seo优化
function make_excerpt($value, $length = 200)
{
    //strip_tags()去掉字符串中的html标签
    //preg_replace() 第三个参数字符串匹配正则的段落将其替换成空格
    //\r回车符 \n换行符
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    //str_limit laravel字符串辅助函数,限制字符串的长度
    return str_limit($excerpt, $length);
}