<!-- reseve_detail.blade.php -->
@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{$date}}日</span><span class="ml-3">{{$part}}部</span></p>
    <div class="h-75 border">
      <table class="custom-w-25"> <!-- クラスを追加 -->
        <tr class="text-center bg-blue">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        @forelse ($reservePersons as $reservePerson)
          @php $users = $reservePerson->users @endphp
          @if ($users)
            @foreach ($users as $user)
              <tr class="text-center {{ $loop->odd ? 'bg-white' : 'bg-lightblue'}}">
                <td class="w-25">{{ $user->id }}</td>
                <td class="w-25">{{ $user->over_name }} {{ $user->under_name }}</td>
                <td class="w-25">リモート</td>
              </tr>
            @endforeach
          @endif
        @empty
          <tr>
            <td class="w-25" colspan="3">No data available</td>
          </tr>
        @endforelse
      </table>
    </div>
  </div>
</div>
@endsection
