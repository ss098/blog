<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Paper;
use App\User;
use DB;
use Parsedown;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $category_name = $request->input('category_name');

        if (!empty($title)) {
            // 返回指定文章
            $paper = Paper::where('title', $title)->first();
            return $paper;
        } else if (!empty($category_name)) {
            // 返回指定分类下的文章列表
            $category = Category::where('name', $category_name)->first();
            return $category->paper()->where('page', false)->orderBy('created_at', 'desc')->paginate(5);
        } else {
            return Paper::where('page', false)->orderBy('created_at', 'desc')->paginate(5);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input_paper = $request->input('paper');
        $token = $request->input('token');

        $user = User::where('token', $token)->first();

        if (empty($user) || ($user->token != $token))
        {
            return [
                'success' => false,
                'message' => [
                    "授权码：{$token} 是无效的"
                ]
            ];
        }

        $category_id = Category::where('name', $input_paper['category'])->value('id');

        if (empty($category_id))
        {
            return [
                'success' => false,
                'message' => [
                    "分类：{$category} 是无效的"
                ]
            ];
        }

        $parsedown = new Parsedown();

        $paper = new Paper();
        $paper->title = $input_paper['title'];
        $paper->page = $input_paper['page'] ? 1 : 0;
        $paper->category_id = $category_id;
        $paper->content = $parsedown->text($input_paper['content']);
        $paper->markdown = $input_paper['content'];
        $paper->save();

        return [
            'success' => true,
            'paper' => $paper
        ];
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Device::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $token = $request->input('token');
        $user = User::where('token', $token)->first();
        if (empty($user) || ($user->token != $token))
        {
            return [
                'success' => false,
                'message' => [
                    "授权码是无效的"
                ]
            ];
        }

        $paper = $request->input('paper');
        $parsedown = new Parsedown();

        Paper::where('id', $id)->update([
            'title' => $paper['title'],
            'markdown' => $paper['markdown'],
            'content' => $parsedown->text($paper['markdown']),
            'page' => $paper['page'],
            'category_id' => $paper['category_id']
        ]);

        return [
            'success' => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = $request->input('token');
        $user = User::where('token', $token)->first();
        if (empty($user) || ($user->token != $token))
        {
            return [
                'success' => false,
                'message' => [
                    "授权码是无效的"
                ]
            ];
        }

        Paper::where('id', $id)->delete();

        return [
            'success' => true
        ];
    }
}
