<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

//スクール予約画面
class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();
// 予約人数 reserve_setting_id　カレンダーid
    $html[] = '<div class="text-left">';
    if($one_part){
        
    $html[] = '<a href="' . route('calendar.admin.detail', ['id' => $one_part->id, 'data' => $ymd, 'part' =>$one_part->setting_part]) . '">';
    $html[] = '<p class="day_part m-0 pt-1">2部</p>';
    $html[] =  $one_part->users->count();
    $html[] = '</a>';

    }
    if($two_part){

   // $routeName = 'calendar.admin.detail';
   // $id = $two_part->id; // Get the id from $three_part
   // $data = $two_part->setting_reserve; // Get the data from $three_part
   // $part = '2';
   // $html[] = '<a href="' . route($routeName, ['id' => $id, 'data' => $data, 'part' => $part]) . '">';
    $html[] = '<a href="' . route('calendar.admin.detail', ['id' => $two_part->id, 'data' => $ymd, 'part' =>$two_part->setting_part]) . '">';
    $html[] = '<p class="day_part m-0 pt-1">2部</p>';
    $html[] =  $two_part->users->count();
    $html[] = '</a>';

    }
    if($three_part){

      $html[] = '<a href="' . route('calendar.admin.detail', ['id' => $three_part->id, 'data' => $ymd, 'part' => $three_part->setting_part]) . '">';
      $html[] = '<p class="day_part m-0 pt-1">3部</p>';
      $html[] =  $three_part->users->count();

    }
       $html[] = '</a>';
       $html[] = '</div>';

    return implode("", $html);
  }

  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
