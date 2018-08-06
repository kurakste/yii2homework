<?php 

namespace app\objects;

use app\models\Event;

class CalendarHelper 
{
    public static function renderCalendar
            (
                string $strMonth, $strYear, 
                array $eventsCountByDay
            ) : string 
    {
        $strDate = '1.'.$strMonth.'.'.$strYear;

        $date = new \DateTime($strDate);
        $firstDayOfWeek = date('w', $date->getTimestamp());
        $countOfDay = \cal_days_in_month(CAL_GREGORIAN, $strMonth, $strYear);
        $str ='';
        $day = 1;
        $max_str =  ceil (($firstDayOfWeek + $countOfDay)/7);
        $str = "<div>$strMonth / $strYear </div>";
        $str .='<style> 
            td 
                {width: 50px; 
                 height: 50px;
                 position: relative;} 
            .badge {
                position: absolute;
                padding: 7px;
                top: 3px;
                right: 10px;
                background-color: green;
                width: 22px;
                height: 22px;
                border-radius: 12px; 
            }
            
         </style>';
        $str .='<table><tr>';
        $str .= '<th>вс</th><th>пн</th><th>вт</th><th>ср</th><th>чт</th><th>пт</th><th>сб</th>';
        $str .= '</tr>';
        for ($i=0; $i<7; $i++) {
            if ($i < $firstDayOfWeek) {
                $str .= '<td> </td> '; 
            } else {

                $str .= "<td>$day </td>  "; 
                $day++;
            }
        }
        $str .= '</tr>';

        for ($row = 1; $row < $max_str; $row++) {
            $str .= '<tr>';
            for ($i=0; $i<7; $i++) {

                if (isset($eventsCountByDay[$day])) {
                    $badge = "<div class = 'badge'>".$eventsCountByDay[$day]."</div>";
                } else {
                    $badge ='';
                }
                if ($day <= $countOfDay) {
                    $str .= "<td>$day ".$badge."</td>  "; 
                } else {
                    $str .= "<td> </td>  "; 
                }
                $day++;
            }
            $str .= '</tr>';
        }

        $str .= '</table>';

        return $str;
    }

    public static function getEvents($month, $year)
    {
        $countOfDay = \cal_days_in_month(CAL_GREGORIAN, $month, $year);
        // Получаем все события этого месяца/года
        $start = $year.'.'.$month.'.01';
        $end = $year.'.'.$month.'.'.($countOfDay+1);
        $events = Event::find()
            ->where(['>=', 'start_at', $start])
            ->andWhere(['<', 'start_at', $end])
            ->all();

        $eventsCountByDay = [];
        foreach ($events as $event) {
            $day = date_parse($event->start_at)['day'];
            if (array_key_exists($day, $eventsCountByDay)) {
                $eventsCountByDay[$day]++; 
            } else {
                $eventsCountByDay[$day] = 1; 
            }
        }

        return $eventsCountByDay;
    }

}

