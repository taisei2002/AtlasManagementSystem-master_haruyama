@extends('layouts.sidebar')

@section('content')

<div class="search_content w-100 border d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person">
      <div class="username_id_search">
        <span>ID : </span><span >{{ $user->id }}</span>
      </div>
      <div class="username_search"><span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div class="username_search">
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div class="username_search">
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        @else
        <span>性別 : </span><span>女</span>
        @endif
      </div>
      <div class="username_search">
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
    <div class="username_search">
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span>権限 : </span><span>講師(英語)</span>
        @else
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
         <div class="username_search"><span>選択科目 :</span>
        @foreach($user->subjects as $subject)
        <span>{{ $subject->subject }}</span>
        @endforeach
      </div>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25 border">
    <div class="">
      <div>
        <p>検索</p>
        <input type="text" class="free_word" name="keyword" placeholder="　キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <lavel>カテゴリ</lavel>
        <select class="category_select" form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
          <option value="subject">選択科目</option>
        </select>
      </div>
      <div>
        <label>並び替え</label>
        <select class="category_select" name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="">
        <p class="m-0 search_conditions js-search_conditions"><span>検索条件の追加</span></p><br>
        <div class="search_conditions_inner">
          <div>
            <label>性別</label><br>
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          <div>
            <label>権限</label>
            <select class="category_select"  name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label>選択科目</label><br>
          @foreach($subjects as $subject)
          <div class="subject_checkbox">
           <label> <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" form="userSearchRequest">
          {{ $subject->subject }}</label>
          </div>
          @endforeach
        </div>

          </div>
        </div>
      </div>
      <div>
       <input class="search_btn" type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
      <div>
       <input class="reset_btn" type="reset" value="リセット" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
