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
    public $board;

    /**
     * @var array
     */
    public const WEDGE_VALUES = [20, 1, 18, 4, 13, 6, 10, 15, 2, 17, 3, 19, 7, 16, 8, 11, 14, 9, 12, 5];

    /**
     * Radius = plural radii or radiuses
     * 
     * Field/Wedge thickness = 8
     * 
     * 1. Bull
     * 2. Bullseye
     * 3. (inner) Tripple
     * 4. (outer) Tripple
     * 3. (inner) Double
     * 4. (outer) Double
     * 
     * @var array
     */
    public const RING_RADII_RATIO = [3.75, 5.61, 48.89, 4.70, 32.35, 4.7];

    /**
     * 
     * 
     */
    public const MULTIPLIERS = [1, 1, 1, 2, 1, 3];
    
    /**
     * 
     */
    public $wireThickness = 0;

    /**
     * 
     */
    public $outerRadius = 170;

    /**
     * 
     */
    public $radiusScalar = 1;

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
     * @param array|null $wedge_values
     * @param bool $extra
     * @return array
     */
    public function generateBoard(array $wedge_values = null, bool $extra = false) 
    {
        $board = array();
        $values = $wedge_values ?? $this::WEDGE_VALUES;
        
        if($extra) {
            array_unshift( $values, $wedge_values ? end($wedge_values) : end($this::WEDGE_VALUES) );
            $values[] = $values[1];
        }

        foreach($values as $v) {
            $board[] = [
                new Wedge("D".$v*2), 
                new Wedge($v),
                new Wedge("T".$v*3), 
                new Wedge($v), 
                new Wedge(25),
                new Wedge(50)
            ];
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
                $mappedValue = (Utillity::map($board[$i][$j], $minThreshold, $this->getMaxValue($board)*$maxScalar, 0, 100))/100;
                $heat[$i][$j] = $mappedValue < 0 ? 0 : ($twoDecimal ? round($mappedValue, 2) : $mappedValue);
            }

        return $heat;
    }

    /**
     * Calculates average of nearest neighbour wedge values
     * 
     * @return array
     */
    public function calculateBoardAverages()
    {
        $board = $this->generateBoard($this::WEDGE_VALUES, true);
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
     * 
     */
    public function getRadii()
    {
        $sizes = array();
        $last = 0;
        $total = 0;

        // convert ratios to actual radii
        foreach($this::RING_RADII_RATIO as $ratio) {
            $radius = (( ($ratio*$this->outerRadius) / 100.0)  * $this->radiusScalar) + $last;
            $sizes[] = $radius; 
            $last = $radius;
        }

        return $sizes;
    }

    /**
     * 
     * 
     */
    public function raddiToRatios(array $radii) 
    {
        $ratios = array();
        $total = array_sum($radii);

        foreach($radii as $radius) {
            $ratios[] = ($radius / $total) * 100;
        }

        return $ratios;
    }

    
    /**
     * 
     * 
     */
    public function getWedgeValue(float $rORx, float $ThetaORy, bool $formatPolar = true)
    {

        if(!$formatPolar) {
            $polarCoords = Utillity::CartesianToPolar($rORx, $ThetaORy);
            $r = $polarCoords[0];
            $theta = $polarCoords[1];
        } else {
            $r = $rORx;
            $theta = $ThetaORy;
        }

        $radii = $this->getRadii();
        
        if($r <= $radii[0])
            return 50;

        // throw is out of bounds
        if($r > end($radii))
            return 0;
        
        if($theta > 360.0)
            $theta = fmod($theta, 360.0);

        $wedgeAngle = 360 / sizeOf($this::WEDGE_VALUES);
        $offset = $wedgeAngle / 2;
        $multiplier = 0;
        
        // wedge center
        $value = ( $theta / $wedgeAngle );

        // wedge right edge
        // $value = ( ( $theta+$offset ) / $wedgeAngle );

        // get the multiplier
        for($i = 0; $i <= sizeof($radii)-1; $i++) 
            if($r > $radii[$i] && $r <= $radii[$i+1]) {

                $multiplier = $this::MULTIPLIERS[$i+1];
                if($i == 0)
                    $value = 25;

                break;
            }

        return new Wedge(null, $multiplier);
    }
}