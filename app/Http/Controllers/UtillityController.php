<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Dartboard;


/**
 * UtillityController
 */
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
     * Show all possible checkouts with a given score
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
        $highlightBestOption = $request->input('highlightBestOption', !$default);
        $showWeights = $request->input('showWeights', false);

        $maxResults = $limitResults ? 150 : null;
        $bestOption = null;

        $time_pre = microtime(true);
        $checkouts = $this->calculateCheckouts($score, true, $maxResults, $singleOut, $doubleOut, $trippleOut);
        $time_post = microtime(true);

        $checkoutNumOfPossibilities = sizeof($checkouts);

        $this->sortCheckouts($checkouts);
        $bestOption = $this->evaluateCheckouts($checkouts);
        

        

        $checkoutsChunked = array();

        if($checkoutNumOfPossibilities >= 10) {
            if($checkoutNumOfPossibilities % 2 == 0 ) {
                $checkoutsChunked = array_chunk($checkouts, $checkoutNumOfPossibilities/2, true);
            } else {
                $checkoutsChunked = array_chunk($checkouts, ($checkoutNumOfPossibilities-1)/2, true);
                $checkoutsChunked[1][$checkoutNumOfPossibilities-1] = $checkouts[$checkoutNumOfPossibilities-1];
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
        $data["limitResults"] = $limitResults;
        $data["highlightBestOption"] = $highlightBestOption;
        $data["showWeights"] = $showWeights;
        $data["singleOut"] = $singleOut;
        $data["doubleOut"] = $doubleOut;
        $data["trippleOut"] = $trippleOut;

        return view('utillity.checkoutCalculator', $data);
    }

    /**
     * evaluate each checkout option by calculating and appyling a weight
     * 
     * @param array &$checkouts to evaluate 
     * @return int index with the best checkout option
     */
    private function evaluateCheckouts(array &$checkouts)
    {
        $highestValue = 0.0;
        $bestOption = 0;

        $good = ["20", "D20", "T20", "3", "T3", "Bull", "Bullseye"];
        $goodValue = .25;

        $okay = ["T14", "T11", "T8", "T13", "T6", "T10", "T19", "T18", "T12", "9", "1", "T1", "5", "T5"];
        $okayValue = .1;

        $bad = ["2", "D2", "T2", "7", "D7", "T7", "D3", "4", "D4", "T4", "6", "D6", "15", "D15", "T15", "D17", "T17"];
        $badValue = -.1;

        foreach($checkouts as $i => $co) {
            $weightPos = count($co)-1;
            $weight = &$checkouts[$i][$weightPos];

            foreach($co as $j => $val) {
                if($j >= $weightPos)
                    continue;
                
                if(empty($val))
                    $weight += $goodValue*2;

                if($j > 0)
                    if($val === $co[$j-1])
                        $weight += $goodValue*1.10;

                if(in_array($val, $good))
                    $weight += $goodValue;
                
                else if(in_array($val, $okay))
                    $weight += $okayValue;

                else if(in_array($val, $bad))
                    $weight += $badValue;

                else {

                }
            }

            if($highestValue < $weight) {
                $highestValue = $weight;
                $bestOption = $i;
            }
        }

        return $bestOption;
    }

    /**
     * sort by
     * 1. low throw count first
     * 2. low throw value first
     * 
     * @param array &$checkouts
     * @return void
     */
    private function sortCheckouts(array &$checkouts)
    {
        if(empty($checkouts))
            return $checkouts;

        $preSortedThrows = array();
        $tmp = array();
        $maxThrows = count($checkouts[0])-1;

        // usort($checkouts, function($a, $b)
        // {
        //     $counterA = count($a) - count(array_filter($a, 'is_null'));
        //     $counterB = count($b) - count(array_filter($b, 'is_null'));

        //     return $counterA <=> $counterB;
        // });

        foreach($checkouts as $i => $co) {
            $numOfThrows = $maxThrows - count(array_filter($co, 'is_null'));

            $preSortedThrows[$numOfThrows][$i] = $co;
        }
        
        // sort ascending
        for($i=$maxThrows; $i>=0; $i--) {
            if(!array_key_exists($i, $preSortedThrows))
                continue;

            $prefixes = $this->resolveFieldPrefix();

            usort($preSortedThrows[$i], function($a, $b) use ($prefixes)
            {
                // sort by value of first throw
                return $this->splitFieldName($a[0])[1] <=> $this->splitFieldName($b[0])[1];
                
                // sort by weight
                // return $a[3] <=> $b[3];
            });

            $tmp = array_merge($preSortedThrows[$i], $tmp);
        }

        $checkouts = $tmp;
    }

    /**
     * fill empty array spaces by moving values forward 
     * 
     * @param array $checkouts
     * @return array with filtered checkouts
     */
    private function getFilteredCheckouts(array $checkouts) 
    {
        for($i=0; $i<=count($checkouts)-1; $i++){
            $len = count($checkouts[$i])-2;
            for($j=0; $j<=$len; $j++){
                if(!$checkouts[$i][$j]) {
                    for($k=$j; $k<=$j+($len-$j); $k++) {
                        if(!empty($checkouts[$i][$k])) {
                            $checkouts[$i][$j] = $checkouts[$i][$k];
                            $checkouts[$i][$k] = null;
                            break;
                        }
                    }
                }
            }
        }
                
        return $checkouts;
    }

    /**
     * Calculate checkouts with a given score
     *
     * @param  int $score
     * @param  bool $filter
     * @param  int $maxResults
     * @param  bool $singleOut
     * @param  bool $doubleOut
     * @param  bool $TrippleOut
     * @return array with all possible checkouts (3 Darts)
     */
    private function calculateCheckouts(int $score, bool $filter = true, int $maxResults = 0, bool $singleOut = false, bool $doubleOut = true, bool $TrippleOut = false)
    {
        $checkouts = array();
        $counter = 0;
        $defaultWeight = 1.01;

        for($b = 2; $b <= 76; $b += 1 + ($b == 62) * 12) 
            for($a = 2; $a <= 76; $a += 1 + ($a == 62) * 12) 
            {
                if($maxResults > 0 && $counter >= $maxResults)
                    break 2; // stop inner and outer for loop

                (int)$l = (int)($a / 3) * ($a % 3+1);
                (int)$k = (int)($b / 3) * ($b % 3+1);
                (int)$c = $score - $l - $k;

                if($c>0 & $c<21 | $c == 25 && $a >= $b && $singleOut) {
                    $checkouts[] = [$this->resovleFieldName($a%3, $a/3), $this->resovleFieldName($b%3, $b/3), $this->resovleFieldName(0, $c), $defaultWeight];
                    $counter++;
                }

                if($c>1 & $c<41 | $c == 50 && $c % 2 == 0 & $a >= $b && $doubleOut) {
                    $checkouts[] = [$this->resovleFieldName($a%3, $a/3), $this->resovleFieldName($b%3, $b/3), $this->resovleFieldName(1, $c/2), $defaultWeight];
                    $counter++;
                }

                if($c>2 & $c<61 && $c % 3 == 0 & $a >= $b & $a >= $c &&$TrippleOut) {
                    $checkouts[] = [$this->resovleFieldName($a%3, $a/3), $this->resovleFieldName($b%3, $b/3), $this->resovleFieldName(2, $c/3), $defaultWeight];
                    $counter++;
                }
            }

        return $filter ? $this->getFilteredCheckouts($checkouts) : $checkouts;
    }

    /**
     * resolve score / field names
     * 
     * @param int $prefixId field prefix
     * @param int $value field value
     * @return null|int|string Fieldname
     */
    private function resovleFieldName(int $prefixId, int $value)
    {
        // no useful throw
        if($value < 1)
            return null;

        // translate Bullseye
        if($value == 25 && $prefixId == 1) {
            $prefixId = 4;
            $value = null;
        }

        // translate Bull
        if($value == 25 && $prefixId == 0) {
            $prefixId = 3;
            $value = null;
        }

        $prefix = $this->resolveFieldPrefix($prefixId);
        return $prefix ? $prefix.$value : $value;
    }

    /**
     * null = Single;
     * D = Double;
     * T = Tripple;
     * Bull = Green;
     * Bullseye = Red;
     * 
     * @param int $prefixId
     * @return null|string|(null|string)[] resolved fieldname. when null is returned field is normal single value
     */
    private function resolveFieldPrefix(int $prefixId = null)
    {
        $fieldPrefixes = [null, "D", "T", "Bull", "Bullseye"];

        return is_null($prefixId) ? $fieldPrefixes : $fieldPrefixes[$prefixId];
    }

    /**
     * Split a given dartboard fieldname
     * 
     * @param string|null $field
     * @return array
     */
    public function splitFieldName(string|null $field)
    {
        $fieldParts = preg_split('/(?<=[a-z])(?=\d)/i', $field);
        
        if(sizeOf($fieldParts) == 1) {
            $fieldParts[0] = intval($fieldParts[0]);
            $fieldParts[] = null;
            $fieldParts = array_reverse($fieldParts);
        } else {
            $fieldParts[1] = intval($fieldParts[1]);
        }

        return [$fieldParts[0], $fieldParts[1] ? $fieldParts[1] : null ];
    }   

    /**
     * 
     * @param string|null $field
     * @return bool true when valid, false when invalid
     */
    public function isValidField(string|null $field)
    {
        $fieldParts = $this->splitFieldName($field);

        if($fieldParts[0])
            if(!in_array($fieldParts[0], $this->resolveFieldPrefix()))
                return false;

        if($fieldParts[1] > 20 || $fieldParts[0] < 0)
            return false;


        return true;
    }

    /**
     * 
     */
    public function viewDartboard()
    {
        $dartboard = new Dartboard();
        $avg = $dartboard->calculateBoardAverages();

        $data = array();
        $data["dartboard"] = $dartboard->board;
        $data["dartboardAverages"] = $avg;
        $data["dartboardHeat"] = $dartboard->getHeat($dartboard->board, true);
        $data["dartboardAveragesHeat"] = $dartboard->getHeat($avg, true, 18, 1.5);

        return view('utillity.dartboard', $data);
    }
}