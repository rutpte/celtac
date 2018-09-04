<?php
/******************************************************************************
 * 
 * Name: DateTimeFormat.class.php
 * Purpose: Formate date time with PHP classes.
 * Author:  Narong Rammanee
 *
 ******************************************************************************
 *
 * Copyright 2011 Narong <ranarong@live.com>
 *      
 * This class is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *      
 * This class is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *      
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 ******************************************************************************/
 
class DateTimeFormat
{
    /**
	 * Day
	 * @var string
	 */
	public $_day;
    
    /**
	 * Month
	 * @var string
	 */
    public $_month;
    
    /**
	 * Year
	 * @var string
	 */
    public $_year;
    
    /**
	 * Hour
	 * @var string
	 */
    public $_hour;
    
    /**
	 * Minute
	 * @var string
	 */
    public $_minute;
    
    /**
	 * Second
	 * @var string
	 */
    public $_second;
    
    /**
	 * DateTime format
	 * @var string
	 */
    public $_format;
    
    /**
	 * DateTime separator
	 * @var string
	 */
    public $_separator;
    
    /**
	 * Language
	 * @var string
	 */
    public $_lang;
    
    /**
	 * Constructor
	 * Initialization that the object may need before it is used.
	 *  
	 * @param $datetime
	 * @param $format
	 * @param $separator
	 * @param $lang
	 * @return void.
	 */
    public function __construct($datetime=null, $format=null, $separator='/', $lang='th') 
	{
		self::setDateTime($datetime, $format, $separator, $lang);
	}
    
    /**
	 * Set DateTime.
	 *  
	 * @param $datetime
	 * @param $format
	 * @param $separator
	 * @param $lang
	 * @return void.
	 */
    public function setDateTime($datetime=null, $format=null, $separator='', $lang='th')
    {
        $pdate = date_parse($datetime);
        
        $this->_day       = $pdate['day'];
        $this->_month     = $pdate['month'];
        $this->_year      = $pdate['year'];
        $this->_hour      = $pdate['hour'];
        $this->_minute    = $pdate['minute'];
        $this->_second    = $pdate['second'];
        $this->_format    = $format;
        $this->_lang      = $lang;
        $this->_separator =  $separator == '' ? $this->_separator : $separator;
        
        $formatArray = explode(" ", $this->_format);
        
        $formatDate = isset($formatArray[0]) ? $formatArray[0] : '';
        $formatTime = isset($formatArray[1]) ? $formatArray[1] : '';
        
        $formatDateArray = explode("-", $formatDate);
        $date = self::date($formatDateArray, $this->_separator);
        
        $time = '';
        if(!empty($formatTime)) {
            $formatTimeArray = explode(":", $formatTime);
            $time = self::time($formatTimeArray);
        }
        
        $datetime = $date . ' เวลา ' . $time;
        
		return $datetime;
    }
    
    /**
	 * Render DateTime.
	 *
	 * @return String DateTime.
	 */
	public function render()
	{        
        $formatArray = explode(" ", $this->_format);
        
        $formatDate = $formatArray[0];
        $formatTime = $formatArray[1];
        
        $formatDateArray = explode("-", $formatDate);
        $date = self::date($formatDateArray, $this->_separator);
        
        $time = '';
        if(!empty($formatTime)) {
            $formatTimeArray = explode(":", $formatTime);
            $time = self::time($formatTimeArray);
        }
        
        $datetime = $date . ' ' . $time;
        
		return $datetime;
	}
    
    /**
	 * Format day.
	 *
	 * @return String Day.
	 */
    private function day($format='')
    {
        $fullday  = array(
            1 => 'จันทร์', 2 => 'อังคาร', 3 => 'พุธ', 4 => 'พฤหัสบดี', 
            5 => 'ศุกร์', 6 => 'เสาร์', 7 => 'อาทิตย์'
        );
        $shortday = array(
            1 => 'จ.', 2 => 'อ.', 3 => 'พ.', 4 => 'พฤ.',
            5 => 'ศ.', 6 => 'ส.', 7 => 'อา.'
        );
        
        switch ($format) {
            case 'd'  : $day = $this->_day; break;
            case 'dd' : $day = self::zeroFill($this->_day); break;
            case 'sd' : $day = $shortday[$this->_day]; break;
            case 'fd' :
                if (self::isThaiLang()) {
                    $d = date("N", mktime(0, 0, 0, $this->_month, $this->_day, $this->_year));
                    $day = 'วัน' . $fullday[$d] . 'ที่ ' . $this->_day;
                } else {
                    $d = date("l", mktime(0, 0, 0, $this->_month, $this->_day, $this->_year));
                    $day = $d . ' of';
                }
                break;
            case 'fD' :
                $day = 'วัน' . $fullday[$d] . 'ที่ ' . self::numeral($this->_day);
                break;
            case 'D'  : $month = self::numeral($this->_day); break;
            case 'DD' : $day = self::numeral(self::zeroFill($this->_day)); break;
            default : $day = self::zeroFill($this->_day);
        }
        
        return $day;
    }
    
    /**
	 * Format month.
	 *
	 * @return String Month.
	 */
    private function month($format='')
    {
        
        $fullmonth = array(
			1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
			5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
			9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
		);
		$shortmonth = array(
			1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.', 
			5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
			9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
		);
        
        switch ($format) {
            case 'm'  : $month = $this->_month; break;
            case 'mm' : $month = self::zeroFill($this->_month); break;
            case 'sm' : 
                if (self::isThaiLang()) {
                    $month = $shortmonth[$this->_month];
                } else {
                    $m = $this->_month + 1;
                    if($m == 13) $m = 1;
                    $month = date("M", mktime(0, 0, 0, $m, 0, 0));
                }
                break;
            case 'fm' :
                if (self::isThaiLang()) {
                    $month = $fullmonth[$this->_month];
                } else {
                    $m = $this->_month + 1;
                    if($m == 13) $m = 1;
                    $month = date("F", mktime(0, 0, 0, $m, 0, 0));
                }
                break;
            case 'fM' : $month = $fullmonth[$this->_month]; break;
            case 'M'  : $month = self::numeral($this->_month); break;
            case 'MM' : $month = self::numeral(self::zeroFill($this->_month)); break;
            default: $month = self::zeroFill($this->_month);
        }
        
        return $month;
    }
    
    /**
	 * Format year.
	 *
	 * @return String Year.
	 */
    private function year($format='')
    {
        $year = $this->_lang == 'en' ? $this->_year : $this->_year + 543;
        
        switch ($format) {
            case 'yy' : $year = substr($year, -2); break;
            case 'YY' : $year = substr($year, -2);
                $year = self::numeral($year);
                break;
            case 'yyyy' : $year; break;
            case 'YYYY' : 
                $year = self::numeral($year);
                break;
            default:
                $year = $this->_year;
        }
        
        return $year;
    }
    
    /**
	 * Format hour.
	 *
	 * @return String Hour.
	 */
    public function hour($format='')
    {
        switch ($format) {
            case 'h'  : $hour = $this->_hour; break;
            case 'hh' : $hour = self::zeroFill($this->_hour); break;
            case 'H'  : $hour = self::numeral($this->_hour); break;
            case 'HH' : $hour = self::numeral(self::zeroFill($this->_hour)); break;
            default: $hour = '';
        }
        
        return $hour;
    }
    
    /**
	 * Format minute.
	 *
	 * @return String Minute.
	 */
    public function minute($format='')
    {
        switch ($format) {
            case 'm'  : $minute = $this->_minute; break;
            case 'mm' : $minute = self::zeroFill($this->_minute); break;
            case 'M'  : $minute = self::numeral($this->_minute); break;
            case 'MM' : $minute = self::numeral(self::zeroFill($this->_minute)); break;
            default: $minute = '';
        }
        
        $minute = $minute != '' ? ':' . $minute : '';
        
        return $minute;
    }
    
    /**
	 * Format second.
	 *
	 * @return String Second.
	 */
    public function second($format='')
    {
        switch ($format) {
            case 's'  : $second = $this->_second; break;
            case 'ss' : $second = self::zeroFill($this->_second); break;
            case 'S'  : $second = self::numeral($this->_second); break;
            case 'SS' : $second = self::numeral(self::zeroFill($this->_second)); break;
            default: $second = '';
        }
        
        $second = $second != '' ? ':' . $second : '';
        
        return $second;
    }
    
    /**
	 * Format Date.
	 *
	 * @return String Date.
	 */
    public function date($format, $separator)
    {
        $date = '';
        $index = 0;
        $lastIndex = count($format) - 1;

        foreach ($format as $key => $value) {
            
            if($value == 'sd' || $value == 'fd' 
                || $value == 'fD' || $value == 'fM')
                $separator = " ";
        
            $tmp = substr($value, -1);
    
            if($tmp == 'd' || $tmp == 'D') {
                $day = self::day($value);
                $date .= $day;
                $date .= ($index != $lastIndex) ? $separator : '';
            }
            else if($tmp == 'm' || $tmp == 'M' ) {
                $month = self::month($value);
                $date .= $month;
                $date .= ($index != $lastIndex) ? $separator : '';
            }
            else {
                $year  = self::year($value);
                $date .= $year;
                $date .= ($index != $lastIndex) ? $separator : '';
            }
            
            $index++;
        }
        
        if($lastIndex == 0) {
            $day   = self::day();
            $month = self::month();
            $year  = self::year();
            
            $date = $year . $separator . $month . $separator . $day;
        }
        
        return $date;
    }
    
    /**
	 * Format time.
	 *
	 * @return String Time.
	 */
    public function time($format=null)
    {
        $end = $this->_lang == 'th' ? ' น.' : '';
        
        $formatHour   = isset($format[0]) ? $format[0] : '';
        $formatMinute = isset($format[1]) ? $format[1] : '';
        $formatSecond = isset($format[2]) ? $format[2] : '';
        
        $hour   = self::hour($formatHour);
        $minute = self::minute($formatMinute);
        $second = self::second($formatSecond);
        
        $time = $hour . $minute .$second . $end;
        
        return $time;
    }
    
    /**
	 * Thai numeral.
	 *
	 * @return String Thai numeral.
	 */
    private static function numeral($n)
	{
        $thNumber = array('๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙');
        $arNumber = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
		
        $number = str_replace($arNumber, $thNumber, $n);
        
		return $number;
	}
	
    /**
	 * Zero fill.
	 *
	 * @return String with zero fill.
	 */
	private static function zeroFill($n)
	{
		return $n < 10 ? '0' . $n : $n;
	}
    
    private function isThaiLang()
    {
        $thaiLang = $this->_lang == 'th' ? true : false; 
        return $thaiLang;
    }
}
