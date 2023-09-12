<!-- reseve_detail.blade.php -->
@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{$date}}日</span><span class="ml-3">{{$part}}部</span></p>
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
              <th class="w-25">場所</th> <!-- 場所の追加 -->
        </tr>
        @foreach ($reservePersons as $reservePerson)
        <tr class="text-center">
          <td class="w-25">
            @if ($reservePerson->users)
              @foreach ($reservePerson->users as $user)
                {{$user->id}}<br>
              @endforeach
            @endif
          </td>
          <td class="w-25">
            @if ($reservePerson->users)
              @foreach ($reservePerson->users as $user)
                {{$user->over_name}} {{$user->under_name}}<br>
              @endforeach
            @endif
          </td>
           <td class="w-25">
            @if ($reservePerson->users)
              @foreach ($reservePerson->users as $user)
                リモート<br> <!-- 各ユーザーごとに「リモート」を表示 -->
              @endforeach
            @endif
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
