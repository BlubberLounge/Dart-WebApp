<?php

namespace App\Classes;


/**
 * Dartboard
 */
class Dartboard
{
    /**
     * @var array
     */
    public const FIELD_VALUES = [20, 1, 18, 4, 13, 6, 10, 15, 2, 17, 3, 19, 7, 16, 8, 11, 14, 9 ,12, 5];
        
    /**
     * @var array
     */
    public $board;
    
    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->board = $this->generateBoard();
    }

    /**
     * auto generate getter and setter
     * 
     */
//     function __call($method, $params)
//     {
//         $var = lcfirst(substr($method, 3));
   
//         if (strncasecmp($method, "get", 3) === 0) {
//             return $this->$var;
//         }
//         if (strncasecmp($method, "set", 3) === 0) {
//             $this->$var = $params[0];
//         }
//    }

    /**
     * 
     * @param array|null $field_values
     * @param bool $extra
     * @return array
     */
    public function generateBoard(array $field_values = null, bool $extra = false) 
    {
        $board = array();
        $values = $field_values ? $field_values : $this::FIELD_VALUES;
        
        if($extra) {
            array_unshift($values, $field_values ? $field_values[sizeof($field_values)-1] : $this::FIELD_VALUES[sizeof($this::FIELD_VALUES)-1]);
            $values[] = $values[1];
        }

        foreach($values as $v) {
            $board[] = [$v*2, $v, $v*3, $v, 25, 50];
        }

        return $board;
    }
  
    /**
     * only use when board got generated with $extra flag = true
     *
     * @param array &$board
     * @return void
     */
    public function cleanGeneratedBoard(array &$board)
    {
        unset($board[0]);
        array_unshift($board, $board[1]);

        for($i=2; $i<=sizeOf($board)-1; $i++) {
            $board[$i-1] = $board[$i];
        }

        unset($board[sizeOf($board)-1]);
        unset($board[sizeOf($board)-1]);
    }

    /**
     * Generate a heatmap from the given dartboard
     * 
     * @param array $board
     * @param int $minThreshold
     * @param int $maxScalar
     * @return array with heat values
     */
    public function getHeat(array $board, bool $twoDecimal = false, int $minThreshold = 0, int $maxScalar = 1) 
    {
        $heat = array();

        foreach($board as $i => $r)
            foreach($r as $j => $c) {
                $mappedValue = ($this->map($board[$i][$j], $minThreshold, $this->getMaxValue($board)*$maxScalar, 0, 100))/100;
                $heat[$i][$j] = $mappedValue < 0 ? 0 : ($twoDecimal ? round($mappedValue, 2) : $mappedValue);
            }

        return $heat;
    }

    /**
     * Calculates average of nearest neighbour field values
     * 
     * @return array
     */
    public function calculateBoardAverages()
    {
        $board = $this->generateBoard($this::FIELD_VALUES, true);
        $newBoard = array();

        $row_size = sizeOf($board)-1;
        foreach($board as $key => $row) {
            $col_size = sizeOf($row)-1;
            $i = $key;

            foreach($row as $k => $col) {
                $j = $k;
                $numNeighbours = 0;
                $newValue = 0;
                for($x = max(0, $i-1); $x <= min($i+1, $row_size); $x++)
                    for($y = max(0, $j-1); $y <= min($j+1, $col_size); $y++)
                        if($x != $i || $y != $j) {
                            $numNeighbours++;
                            $newValue += $board[$x][$y];
                        }

                $newValue /= $numNeighbours;
                $newBoard[$i][$j] = $newValue;
            }
        }

        $this->cleanGeneratedBoard($newBoard);

        return $newBoard;
    }

    /**
     * Get max value of a 2D-Array
     * 
     * @param array $arr
     * @return int
     */
    public function getMaxValue(array $arr)
    {
        $max = 0;

        foreach($arr as $val)
            foreach($val as $key => $val1)
                if($val1 > $max)
                    $max = $val1;

        return $max;

        // modern solution
        // return max(array_column($arr, 0));
    }

    /**
     * Find the corresponding value from a certain domain to another domain
     * 
     * Example: 
     * - Input range: 0deg - 180deg
     * - desired Out range: 0 - 1023
     * - 0deg crresponds to 0 and 180deg corresponds to 1023
     * - When x is 180deg/2 then the method would return 1023/2
     * 
     * 
     * @param float $x
     * @param float $in_min
     * @param float $in_max
     * @param float $out_min
     * @param float $out_max
     * @return int|float value range [0, 1]
     */
    public function map(float $x, float $in_min, float $in_max, float $out_min, float $out_max)
    {
        return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
    }

    /**
     * Transpose given array. Switch rows and columns
     * 
     * @param array $array
     * @return array that is transposed
     */
    public function transpose(array $array)
    {
        return array_map(null, ...$array);
    }
}