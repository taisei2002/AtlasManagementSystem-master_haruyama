<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");
  // 過去の日か今日以降の日付かを判断
       if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          $html[] = '<td class="calendar-td past-day border">'; //今日までの日付を暗くする
        } else {
          $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
        }
        $html[] = $day->render();

        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'. $reservePart .'</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{

      $html[] = '<button type="submit" form="deleteParts" class="btn btn-danger delete-modal-open p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve .
       $day->authReserveDate($day->everyDay())->first()->deleteParts .
      '">' . $reservePart . '</button>';

          //   $html[] = '<button type="submit" form="deleteParts" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">' . $reservePart . '</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';

            // モーダルオープン
    $html[] ='<div class="modal js-modal">';
    $html[] = '<div class="modal__bg js-modal-close"></div>';
    $html[] = '<div class="modal__content">';
    $html[] = '<div class="w-100">';
    $html[] = '<div class="modal-inner-title w-50 m-auto">';
    $html[] = '</div>';
    $html[] = '<div class="modal-inner-body w-50 m-auto pt-3 pb-3">';
    $html[] = '<a>予約をキャンセルしますか？</a>';
    $html[] = '</div>';
    $html[] = '<div class="w-50 m-auto edit-modal-btn d-flex">';
    $html[] = '<a class="js-modal-close btn btn-primary d-inline-block" href="">閉じる</a>';
    $html[] = '<input class="setting_reserve" type="hidden" name="delete_date" form="deleteParts" value="">'; //setting_reserve
    $html[] = '<input class="setting_part" type="hidden" name="deleteParts" form="deleteParts" value="">'; //setting_part　
    $html[] ='<input type="submit" class="btn btn-danger d-block " value="キャンセル" form="deleteParts"">';
    $html[] = '</div>';
    $html[] = '</div>';
    $html[] = '</div>';
    $html[] ='</div>';


          }
        }else{
            //受付終了
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
            $html[] = '受付終了';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{

          $html[] = $day->selectPart($day->everyDay());
        }

    }
    //
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';// キャンセル

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
