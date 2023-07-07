<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;

class CalendarWeek{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  function getClassName(){
    return "week-" . $this->index;
  }

//日にち
  function getDays(){
    $days = [];
    $startDay = $this->carbon->copy()->startOfWeek(); //始まり
    $lastDay = $this->carbon->copy()->endOfWeek();//終わり
    $tmpDay = $startDay->copy();

    while($tmpDay->lte($lastDay)){ //それ以下
      if($tmpDay->month != $this->carbon->month){
        $day = new CalendarWeekBlankDay($tmpDay->copy());
        $days[] = $day;
        $tmpDay->addDay(1);
        continue;
       }
       $day = new CalendarWeekDay($tmpDay->copy());
       $days[] = $day;
       $tmpDay->addDay(1);
    }
    return $days;
  }
}
