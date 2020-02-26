<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.3
*  International Registered Trademark & Property of SmatDataSoft
*/

class UniteEmRev
{

    const DEFAULT_FILTER = "none";

    public static function isEventsExists()
    {
        if (defined("EM_VERSION") && defined("EM_PRO_MIN_VERSION")) {
            return(true);
        }

        return(false);
    }

    public static function getArrFilterTypes()
    {
        $arrEventsSort = array("none" => __("All Events", REVSLIDER_TEXTDOMAIN),

                                   "today" => __("Today", REVSLIDER_TEXTDOMAIN),

                                   "tomorrow"=>__("Tomorrow", REVSLIDER_TEXTDOMAIN),

                                   "future"=>__("Future", REVSLIDER_TEXTDOMAIN),

                                   "past"=>__("Past", REVSLIDER_TEXTDOMAIN),

                                   "month"=>__("This Month", REVSLIDER_TEXTDOMAIN),

                                   "nextmonth"=>__("Next Month", REVSLIDER_TEXTDOMAIN)

            );

        return($arrEventsSort);
    }

    public static function getWPQuery($filterType, $sortBy)
    {
        $dayMs = 60*60*24;
        $response = array();


        $time = current_time('timestamp');

        $todayStart = strtotime(date('Y-m-d', $time));

        $todayEnd = $todayStart + $dayMs-1;

        $tomorrowStart = $todayEnd+1;

        $tomorrowEnd = $tomorrowStart + $dayMs-1;



        //dmp(UniteFunctionsRev::timestamp2DateTime($tomorrowStart));exit();



        $start_month = strtotime(date('Y-m-1', $time));

        $end_month = strtotime(date('Y-m-t', $time)) + 86399;

        $next_month_middle = strtotime('+1 month', $time); //get the end of this month + 1 day

        $start_next_month = strtotime(date('Y-m-1', $next_month_middle));

        $end_next_month = strtotime(date('Y-m-t', $next_month_middle)) + 86399;



        $query = array();



        switch ($filterType) {

            case self::DEFAULT_FILTER:    //none

                break;

            case "today":

                $query[] = array( 'key' => '_start_ts', 'value' => $todayEnd, 'compare' => '<=' );

                $query[] = array( 'key' => '_end_ts', 'value' => $todayStart, 'compare' => '>=' );

                break;

            case "future":

                $query[] = array( 'key' => '_start_ts', 'value' => $time, 'compare' => '>' );

                break;

            case "tomorrow":

                $query[] = array( 'key' => '_start_ts', 'value' => $tomorrowEnd, 'compare' => '<=' );

                $query[] = array( 'key' => '_end_ts', 'value' => $todayStart, 'compare' => '>=' );

                break;

            case "past":

                $query[] = array( 'key' => '_end_ts', 'value' => $todayStart, 'compare' => '<' );

                break;

            case "month":

                $query[] = array( 'key' => '_start_ts', 'value' => $end_month, 'compare' => '<=' );

                $query[] = array( 'key' => '_end_ts', 'value' => $start_month, 'compare' => '>=' );

                break;

            case "nextmonth":

                $query[] = array( 'key' => '_start_ts', 'value' => $end_next_month, 'compare' => '<=' );

                $query[] = array( 'key' => '_end_ts', 'value' => $start_next_month, 'compare' => '>=' );

                break;

            default:

                UniteFunctionsRev::throwError("Wrong event filter");

                break;

        }



        if (!empty($query)) {
            $response["meta_query"] = $query;
        }



        //convert sortby

        switch ($sortBy) {

            case "event_start_date":

                $response["orderby"] = "meta_value_num";

                $response["meta_key"] = "_start_ts";

                break;

            case "event_end_date":

                $response["orderby"] = "meta_value_num";

                $response["meta_key"] = "_end_ts";

                break;

        }



        return($response);
    }

    public static function getArrSortBy()
    {
        $arrSortBy = array();

        $arrSortBy["event_start_date"] = __("Event Start Date", REVSLIDER_TEXTDOMAIN);

        $arrSortBy["event_end_date"] = __("Event End Date", REVSLIDER_TEXTDOMAIN);

        return($arrSortBy);
    }
}
