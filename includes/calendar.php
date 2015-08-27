<?php
/**
 *@author  Xu Ding
 *@email   thedilab@gmail.com
 *@website http://www.StarTutorial.com
 **/
class Calendar {

    /**
     * Constructor
     */
    public function __construct(){

    }

    /********************* PROPERTY ********************/
    private $dayLabels = array("S","M","T","W","T","F","S");
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;

    /********************* PUBLIC **********************/

    /**
     * print out the calendar
     */
    public function show() {
        $year = null;
        $month = null;

        if(null == $year && isset($_GET['year'])) {
            $year = $_GET['year'];
        } else if(null == $year) {
            $year = date("Y", time());
        }

        if(null == $month && isset($_GET['month'])) {
            $month = $_GET['month'];
        } else if(null == $month) {
            $month = date("m", time());
        }

        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->daysInMonth = $this->_daysInMonth($month, $year);

        $content  = "<div id=\"calendar\">\n";
        $content .= "<div class=\"box\">\n";
        $content .= "<div class=\"header\"><span class=\"title\">" . date('F Y', strtotime($this->currentYear . '-' . $this->currentMonth . '-1')) . "</span></div>\n";
        $content .= "</div>\n";
        $content .= "<div class=\"box-content\">\n";
        $content .= "<ul class=\"label\">\n";
        foreach($this->dayLabels as $index => $label){
            $content .= "<li class=\"" . ($index == 0 ? 'start' : ($index == 6 ? 'end' : '')) . (($index == 1) || ($index == 2) || ($index == 3) || ($index == 4) || ($index == 5) ? 'mask' : '') . " title\">" . $label . "</li>\n";
        }
        $content .= "</ul>\n";
        $content .= "<div class=\"clear\"></div>\n";
        $content .= "<ul class=\"dates\">\n";

        $weeksInMonth = $this->_weeksInMonth($month, $year);
        // Create weeks in a month
        for( $i=0; $i < $weeksInMonth; $i++ ){
            //Create days in a week
            for($j=0; $j <= 6; $j++){
                $cellNumber = $i*7+$j;

                if($this->currentDay == 0) {
                    $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));
                    if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                        $this->currentDay=1;
                    }
                }

                if( ($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth) ) {
                    $this->currentDate = date('mdY',strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
                    $cellContent = $this->currentDay;
                    $this->currentDay++;
                } else {
                    $this->currentDate = null;
                    $cellContent = null;
                }

                get_events($this->currentDate, $event_today, $event, $multi_event);

                $content .= "<li id=\"li-" . $this->currentDate . "\" class=\"" . ($cellNumber%7==0?'start':($cellNumber%7==6?'end':'')) . ($event_today ?' event':'') . ($cellContent==date("j", time())?' today':'') . ($cellContent==null?' mask':'') . "\">";
                if ($event_today) {
                    if ($multi_event["count"] > 1) {
                        $content .= "<a href=\"view_day.php?date=" . $this->currentDate . "\">" . $cellContent . "</a>";
                    } else {
                        $content .= "<a href=\"view_event.php?event_id=" . $event["event_id"] . "\">" . $cellContent . "</a>";
                    }
                } else {
                    $content .= $cellContent;
                }
                $content .= "</li>\n";
            }
        }
        $content .= "</ul>\n";
        $content .= "<div class=\"clear\"></div>\n";
        $content .= "</div>\n";
        $content .= "</div>\n";

        return $content;
    }

    /**
     * calculate number of weeks in a particular month
     */
    private function _weeksInMonth($month = null, $year = null){

        if( null == ($year) ) {
            $year =  date("Y",time());
        }

        if(null == ($month)) {
            $month = date("m",time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay = date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));

        if($monthEndingDay < $monthStartDay){
            $numOfweeks++;
        }

        return $numOfweeks;
    }

    /**
     * calculate number of days in a particular month
     */
    private function _daysInMonth($month = null, $year = null){

        if(null == ($year))
            $year =  date("Y",time());

        if(null == ($month))
            $month = date("m",time());

        return date('t',strtotime($year.'-'.$month.'-01'));
    }
}

function get_events($date, &$event_today, &$event, &$multi_event) {
    if ($date != null) {
        $query  = "select event_id, event_date";
        $query .= "  from " . TABLE_PREFIX . "events";
        $query .= "  where DATE_FORMAT(FROM_UNIXTIME(event_date), '%m%d%Y') = '" . $date . "'";

        query_db($query, $event);

        $query  = "select event_id, event_date";
        $query .= "  from " . TABLE_PREFIX . "events";
        $query .= "  where DATE_FORMAT(FROM_UNIXTIME(event_date), '%m%d%Y') = '" . $date . "'";

        $multi_event["count"] = query_db($query, $multi_event, true);

        if ($event["event_id"]) {
            $event_today = true;
        } else {
            $event_today = false;
        }
    }
}

?>