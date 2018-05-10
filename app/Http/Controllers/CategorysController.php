<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Topic;

class CategorysController extends Controller
{
    public function show(Category $category,Request $request,Topic $topic){
        //获取分类下的话题
        $topics=$topic->withOrder($request->order)->where('category_id',$category->id)->paginate(10);
        return view('topics.index',compact('category','topics'));
    }
}
