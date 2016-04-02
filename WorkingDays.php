<?php

//namespace [];
use DateTime;

/**
 *  Class to get only working days
 *  @Author: Wilson Neto <wilson@willgomes.com> 
 */
class WorkingDays
{

    private $holidays;
    
    public function __construct(){
        $year = new DateTime();
        $day = 86400;
        $dates = array();        
        $dates['easter'] = easter_date($year->format('Y'));
        $dates['good_friday'] = $dates['easter'] - (2 * $day);
        $dates['carnival'] = $dates['easter'] - (47 * $day);
        $dates['corpus_christi'] = $dates['easter'] + (60 * $day);
        
		/**
		 * Only Brazil's nationals holidays
		 * For county holidays or day off, add date in $holidays array
		 * Format: d/m  
		 */
        $this->holidays = array(
            '01/01',
            date('d/m', $dates['carnival']),
            date('d/m', $dates['good_friday']),
            date('d/m', $dates['easter']),            
            '21/04',                       
            '07/09',
            date('d/m', $dates['corpus_christi']),
            '12/10',
            '02/11',
            '15/11',
            '25/12'
        );
        
    }
    
    private function checkWeekend($working_day)
    {        
        $working_dayOBJ = DateTime::createFromFormat('d/m/Y', $working_day);
        $weekday = $working_dayOBJ->format('w');
        if ($weekday == 0) {
            #if Sunday +1
            $working_dayOBJ->modify('+1 day');
        } else if ($weekday == 6) {
            #if Saturday +2
            $working_dayOBJ->modify('+2 day');             
        }
        return $working_dayOBJ->format('d/m/Y');
    }

    private function holiday($year, $position)
    {        
        return $this->holidays[$position] . "/" . $year;
    }

    /**
     * 
     * This method return only working day.
     * 
     * @param string $working_day  format 'd/m/Y'
     * @param int $ndays
     * @return string format 'd/m/Y'
     */
    public function working_day($working_day, $ndays)
    {
        for ($i = 1; $i <= $ndays; $i++) {
            $working_dayOBJ = DateTime::createFromFormat('d/m/Y', $working_day);
            if ($i !== 1) {
                $working_dayOBJ->modify('+1 day');
                $working_day = $working_dayOBJ->format('d/m/Y');                
            }
                        
            for ($j = 0; $j < count($this->holidays); $j++) {
                if ($working_day == $this->holiday(date("Y"), $j)) {
                    /**
                     * Add 1 more day if holiday is TRUE.
                     */
                    $working_dayOBJ->modify('+1 day');
                    $working_day = $working_dayOBJ->format('d/m/Y');
                } else {
                    /**
                     * Verify weekend.
                     */
                    $working_day = $this->checkWeekend($working_dayOBJ->format('d/m/Y'));
                }
            }
        }
        return $working_day;
    }
}
