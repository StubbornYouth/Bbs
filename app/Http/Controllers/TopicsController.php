<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Handlers\ImageUploadHandler;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
        //使用with方法提前加载关联属性，并做缓存 之后数据会被预加载并缓存
        //静态页面循环调用一对一关系，导致执行的数据库语句太多
		//$topics = Topic::with('user','category')->paginate();
        //$request->Order获得url地址上的order参数
        $topics=$topic->withOrder($request->order)->paginate(20);
		return view('topics.index', compact('topics'));
	}
    //当话题有 Slug 的时候，我们希望用户一直使用正确的链接
    public function show(Request $request,Topic $topic)
    {
        // URL 矫正 slug不为空并且不等于当前地址的slug
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            // 301 永久重定向到正确的 URL 上。
            return redirect($topic->link(), 301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories=Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request,Topic $topic)
	{
        //$topic->fill($request->all()); fill 方法会将传参的键值数组填充到模型的属性中，如以上数组
		$topic->fill($request->all());
        $topic->user_id=Auth::user()->id;
        $topic->save();
        //to(跳转地址)
		return redirect()->to($topic->link())->with('success', '新建话题成功。');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories=Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('success', '更新话题成功。');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('success', '删除话题成功。');
	}

    //编辑器上传图片
    public function uploadImage(Request $request,ImageUploadHandler $uploader)
    {
        //初始化数据，默认失败
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}