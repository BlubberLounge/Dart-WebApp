<?php

namespace App\Classes;


/**
 * Utillity
 */
class Utillity
{

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
    public static function map(float $x, float $in_min, float $in_max, float $out_min, float $out_max)
    {
        return ($x - $in_min) * ($out_max - $out_min) / ($in_max - $in_min) + $out_min;
    }
    
    /**
     * 
     */
    public static function CartesianToPolar(float $x, float $y)
    {
        // return [sqrt(($x**2)+($y**2)), atan($y/$x)];
        // same as
        return [sqrt(pow($x,2)+pow($y,2)), atan($y/$x)];
    }

    /**
     * 
     */
    public static function PolarToCartesian(float $r, float $theta)
    {
        return [$r*cos($theta), $r*sin($theta)];
    }

    /**
     * Transpose given array. Switch rows and columns
     * 
     * @param array $array
     * @return array that is transposed
     */
    public static function transpose(array $array)
    {
        return array_map(null, ...$array);
    }
}