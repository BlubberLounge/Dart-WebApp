<?php

namespace App\Classes;

class Dartboard {

    public const FIELD_VALUES = [20, 1, 18, 4, 13, 6, 10, 15, 2, 17, 3, 19, 7, 16, 8, 11, 14, 9 ,12, 5];
    public $board;

    public function __construct()
    {
        $this->board = $this->generateBoard();
    }

    /**
     * auto generate getter and setter
     * 
     */
    function __call($method, $params)
    {
        $var = lcfirst(substr($method, 3));
   
        if (strncasecmp($method, "get", 3) === 0) {
            return $this->$var;
        }
        if (strncasecmp($method, "set", 3) === 0) {
            $this->$var = $params[0];
        }
   }

    /**
     * 
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

        return true;
    }

    /**
     * 
     */
    public function getHeat(array $board) 
    {
        $heat = array();

        foreach($board as $i => $r)
            foreach($r as $j => $c)
                $heat[$i][$j] = $this->map($board[$i][$j], 0, $this->getMaxValue($board), 0, 100);
        
        return $heat;
    }

    /**
     * 
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

        // for($i=1; $i <= sizeof($newBoard)-3; $i++) {
        //     echo 'Field: ' . $board[$i][1] . ' --- ';
        //     // echo '<ol>';
        //     for($j=0; $j <= sizeof($newBoard[$i])-2; $j++)
        //         echo '<span style="color:rgba(255,0,0,'.$this->map($newBoard[$i][$j], 0, 35, 0, 100).')">'.$newBoard[$i][$j] ."</span> - ";
        //     echo '<br>';
        // }

        return $newBoard;
    }

    /**
     * Get max value of a 2D-Array
     * 
     */
    public function getMaxValue(array $arr)
    {
        $max = 0;

        foreach($arr as $val)
            foreach($val as $key => $val1)
                if ($val1 > $max)
                    $max = $val1;

        return $max;
    }

    /**
     * 
     */
    public function map(float $x, float $in_min, float $in_max, float $out_min, float $out_max)
    {
        return (($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min)/100;
    }

    public function transpose($array)
    {
        return array_map(null, ...$array);
    }
}