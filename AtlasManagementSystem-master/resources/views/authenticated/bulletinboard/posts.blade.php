@extends('layouts.sidebar')

@section('content')
<!-- 掲示板投稿一覧　-->
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">

    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="bulletin_board_username"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a class="bulletin_board_posttitle" href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">
            {{ $post->postComments->Count($post->post_id) }}
          </div>

          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class="search-btn-main"><a class="btn-post" href="{{ route('post.input') }}">投稿</a></div>
      <div class="search-btn-main">
        <input class = "search-post"type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input class = "search-btn" type="submit" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="like-btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="my_post-btn" value="自分の投稿" form="postSearchRequest">
      <ul></ul>
<body>
<p>カテゴリー検索</p>
<div class="accordion-wrap">
    @foreach($categories as $category)
        <div class="accordion-item">
            <p class="accordion-header">{{ $category->main_category }} <i class="fa fa-angle-down arrow-icon" aria-hidden="true"></i></p>
            <div class="accordion-text">
                <select class="subCategory_pulldown" name="subCategoryId" onchange="event.stopPropagation(); searchPosts();">
                   
                    @foreach($category->subCategories as $subCategory)
                        <option class="subCategory_pulldown_2" value="{{ $subCategory->id }}" @if($subCategoryId == $subCategory->id) selected @endif>
                            {{ $subCategory->sub_category }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endforeach
</div>


<form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>

</body>


<script>
function searchPosts() {
    document.getElementById("postSearchRequest").submit();
}
</script>

@endsection
