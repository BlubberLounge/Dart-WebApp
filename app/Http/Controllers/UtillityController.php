<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtillityController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show possible checkouts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewCheckouts(Request $request, int $score = null)
    {
        $default = $request->input('score');
        $score = $score ? $score : $request->input('score', rand(0, 170));
        $singleOut = $request->input('singleOut', false);
        $doubleOut = $request->input('doubleOut', !$default);
        $trippleOut = $request->input('trippleOut', false);

        $limitResults = $request->input('limitResults', !$default);        
        $highlightBestOption = $request->input('highlightBestOption', false);

        $maxResults = $limitResults ? 150 : null;

        $time_pre = microtime(true);
        $checkouts = $this->calculateCheckouts($score, true, $maxResults, $singleOut, $doubleOut, $trippleOut);
        $time_post = microtime(true);

        $bestOption = $this->evaluateCheckouts($checkouts);
        $checkoutNumOfPossibilities = sizeof($checkouts);

        $checkoutsChunked = array();

        if($checkoutNumOfPossibilities >= 10) {
            if($checkoutNumOfPossibilities % 2 == 0 ) {
                $checkoutsChunked = array_chunk($checkouts, $checkoutNumOfPossibilities/2, true);
            } else {
                $checkoutsChunked = array_chunk($checkouts, ($checkoutNumOfPossibilities-1)/2, true);;
            }
        } else {
            $checkoutsChunked[0] = $checkouts;
            $checkoutsChunked[1] = array();
        }

        $data["checkouts"] = $checkouts;
        $data["checkoutNumOfPossibilities"] = $checkoutNumOfPossibilities;
        $data["checkoutBestOption"] = $bestOption;
        $data["checkouts_0"] = $checkoutsChunked[0];
        $data["checkouts_1"] = $checkoutsChunked[1];
        $data["score"] = $score;
        $data["execTime"] = round($time_post - $time_pre, 2);
        $data["highlightBestOption"] = $highlightBestOption;
        $data["limitResults"] = $limitResults;
        $data["singleOut"] = $singleOut;
        $data["doubleOut"] = $doubleOut;
        $data["trippleOut"] = $trippleOut;

        return view('utillity.checkoutCalculator', $data);
    }

    /**
     * 
     * @param array &$checkouts to evaluate 
     * @return int index with the best checkout option
     */
    private function evaluateCheckouts(array &$checkouts)
    {
        $highestValue = 0.0;
        $bestOption = 0;

        $good = ["20", "D20", "T20", "3", "D3", "T3", "Bull", "Bullseye"];
        $goodValue = .5;

        $okay = ["T14", "T11", "T8", "T13", "T6", "T10", "T19", "T18", "T12", "9", "1", "D1", "T1", "5", "T5"];
        $okayValue = .2;

        $bad = ["2", "D2", "T2", "7", "D7", "T7", "4", "D4", "T4", "6", "D6", "15", "D15", "T15", "D17", "T17"];
        $badValue = -.25;

        foreach($checkouts as $i => $co) {
            $weightPos = count($co)-1;
            foreach($co as $j => $val) {
                if($j == $weightPos)
                    break;
                
                if(in_array($val, $good))
                    $checkouts[$i][$weightPos] += $goodValue;
                
                else if(in_array($val, $okay))
                    $checkouts[$i][$weightPos] += $okayValue;

                else if(in_array($val, $bad))
                    $checkouts[$i][$weightPos] += $badValue;

                else {

                } 
            }

            if($highestValue < $checkouts[$i][$weightPos]) {
                $highestValue = $checkouts[$i][$weightPos];
                $bestOption = $i;
            }

        }

        return $bestOption;
    }

    /**
     * Remove null values and move forward the values when last throw is null
     * 
     *
     * @return array with filtered checkouts
     */
    private function getFilteredCheckouts(array $checkouts) 
    {
        for($i=0;$i<=count($checkouts)-1;$i++) {
            $len = count($checkouts[$i])-1;
            for($j=0;$j<=$len;$j++) {
                if(!$checkouts[$i][$len-$j]) {
                    $checkouts[$i][$len-$j] = $checkouts[$i][$j%$len==0?1:$j%$len]; // OR index=$len-$j+1
                    $checkouts[$i][$len-$j+1] = null;
                }
            }
        }
                
        return $checkouts;
    }

    /**
     * 
     * @param int $score Score of a player (between 2 and 170; 2 = lowest possible checkout, 170 = highest possible checkout)
     * @return array with all possible checkouts with 3 Darts
     */
    private function calculateCheckouts(int $score, bool $filter = true, int $maxResults = null, bool $singleOut = false, bool $doubleOut = true, bool $TrippleOut = false)
    {
        $checkouts = array();
        $counter = 0;
        $defaultWeight = 1.0;

        for($b = 2; $b <= 76; $b += 1 + ($b == 62) * 12) 
            for($a = 2; $a <= 76; $a += 1 + ($a == 62) * 12) 
            {
                if($maxResults)
                    if($counter >= $maxResults)
                        break 2; // stop inner and outer for loop

                (int)$l = (int)($a / 3) * ($a % 3+1);
                (int)$k = (int)($b / 3) * ($b % 3+1);
                (int)$c = $score - $l - $k;

                if($c>0 & $c<61 && $c % 3 == 0 | $c == 1 & $a >= $b && $singleOut)
                    $checkouts[] = [$this->resovleFieldName($a%3, $a/3), $this->resovleFieldName($b%3, $b/3), $this->resovleFieldName($c==1?0:$c%3, $c), $defaultWeight];

                if($c>1 & $c<41 | $c == 50 && $c % 2 == 0 & $a >= $b && $doubleOut) 
                    $checkouts[] = [$this->resovleFieldName($a%3, $a/3), $this->resovleFieldName($b%3, $b/3), $this->resovleFieldName(1, $c/2), $defaultWeight];

                if($singleOut || $doubleOut || $TrippleOut)
                    $counter++;
            }

        return $filter ? $this->getFilteredCheckouts($checkouts) : $checkouts;
    }

    /**
     * resolve score / field names
     * 
     * @param int $symboleId field prefix
     * @param int $value field value
     * @return String|null
     */
    private function resovleFieldName(int $symboleId, int $value)
    {
        /*
         * null = Single
         * D = Double
         * T = Tripple
         * Bull = Green
         * Bullseye = Red
         */
        $s = [null, "D", "T", "Bull", "Bullseye"];

        // no useful throw
        if($value < 1) {
            $symboleId = 0;
            $value = null;
        }

        // translate Bullseye
        if($value == 25 && $symboleId == 1) {
            $symboleId = 4;
            $value = null;
        }

        // translate Bull
        if($value == 25) {
            $symboleId = 3;
            $value = null;
        }

        return $s[$symboleId].$value;
    }
}