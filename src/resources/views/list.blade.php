@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__content">
  <p>
	  {{$date}}
  </p>
</div>

<div class="attendance__content">
  <div class="attendance-table">
    <table class="attendance-table__inner">
      <tr class="attendance-table__row">
        <th class="attendance-table__header">名前</th>
        <th class="attendance-table__header">勤務開始</th>
        <th class="attendance-table__header">勤務終了</th>
        <th class="attendance-table__header">休憩時間</th>
        <th class="attendance-table__header">勤務時間</th>
      </tr>

      @foreach ($lists as $list)
        <tr class="attendance-table__row">
          <td class="attendance-table__item">{{$list->name}}</td>
          <td class="attendance-table__item">{{$list->work_start_time}}</td>
          <td class="attendance-table__item">{{$list->work_end_time}}</td>
          <td class="attendance-table__item">{{$list->total_rest_time}}</td>
          <td class="attendance-table__item">{{$list->work_time}}</td>
        </tr>
      @endforeach

    </table>
  </div>
</div>
@endsection
