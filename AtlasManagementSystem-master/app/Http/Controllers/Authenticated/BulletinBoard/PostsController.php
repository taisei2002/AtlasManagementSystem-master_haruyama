<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\sub_categoryRequest;
use App\Http\Requests\BulletinBoard\main_categoryRequest;
use App\Http\Requests\BulletinBoard\commentRequest;

use Auth;

class PostsController extends Controller
{
public function show(Request $request){
    $posts = Post::with('user', 'postComments')->get();
    $categories = MainCategory::get();
    $like = new Like;
    $post_comment = new Post;
    $subCategoryId = $request->input('subCategoryId');

  if (!empty($request->keyword)) {
        // キーワードによる検索
        $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();
    } elseif ($request->category_word) {
        // カテゴリーによる検索
        $w = $request->category_word;
        $posts = Post::with('user', 'postComments')->get();
    } elseif ($request->like_posts) {
        // いいねした投稿の検索
        $likes = Auth::user()->likePostId()->get('like_post_id');
        $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
    } elseif ($request->my_posts) {
        // 自分の投稿の検索
        $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
    } elseif (!empty($subCategoryId)) {
        // サブカテゴリーの完全一致検索
        $posts = Post::whereHas('subCategories', function ($query) use ($subCategoryId) {
            $query->where('sub_category_id', $subCategoryId);
        })->get();
    }

    return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment', 'subCategoryId'));
}

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){

        $main_categories = MainCategory::get();
        $sab_categories = subCategory::get();

        return view('authenticated.bulletinboard.post_create', compact('main_categories','sab_categories'));
    }

    public function postCreate(PostFormRequest $request){
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body,
     ]);
        $post = Post::findOrFail($post->id);//post_id　投稿のID
        $post_sub_category = $request->post_category_id; //sub_category_id サブカテゴリーID
        $post->subCategories()->attach($post_sub_category);
        return redirect()->route('post.show');
    }

    //ポスト編集
    public function postEdit(PostFormRequest $request){

         $validatedData = $request->validated();

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }


    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(main_categoryRequest $request){
        MainCategory::create([
        'main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }
        public function subCategoryCreate(sub_categoryRequest $request){
        SubCategory::create([
       'sub_category' => $request->sub_category_name,
       'main_category_id' => $request -> main_category_id,
        ]);
        return redirect()->route('post.input');
    }


    //掲示板　投稿

public function commentCreate(commentRequest $request){
    // バリデーションを通過したデータを取得
    $validatedData = $request->validated();

    // バリデーションを通過したデータを使用してコメントを作成
    PostComment::create([
        'post_id' => $validatedData['post_id'],
        'user_id' => Auth::id(),
        'comment' => $validatedData['comment']

    ]);

    // リダイレクト
    return redirect()->route('post.detail', ['id' => $validatedData['post_id']]);
}

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        Auth::user()->likes()->attach($request->post_id);
        return response()->json();
    }

    public function postUnLike(Request $request){
        Auth::user()->likes()->detach($request->post_id);
        return response()->json();
    }
}
