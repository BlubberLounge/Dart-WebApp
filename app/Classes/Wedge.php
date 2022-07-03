<?php

namespace App\Classes;


/**
 * Field / Wedge
 */
class Wedge
{

    /**
     *
     * @var null|string
     */
    public $prefix;
    
    /**
     *
     * @var null|int
     */
    public $value;


    /**
     * - null = Single;
     * - D = Double;
     * - T = Tripple;
     * - Bull = Green;
     * - Bullseye = Red;
     * 
     * @var array
     */
    public const PREFIXES = [null, "D", "T", "Bull", "Bullseye"];

    /**
     *
     * @param null|string $wedgeString
     * @return this
     */
    public function __construct(string $wedgeString = null, string $prefixID = null, int $value = 0)
    {
        if(!is_null($wedgeString)) {
            $wedgeParts = $this::splitString($wedgeString);
            $this->prefix = $wedgeParts[0];
            $this->value = $wedgeParts[1];

        } else if(!is_null($prefixID) || !is_null($prefixID)) {
            $this->prefix = $prefixID;
            $this->value = $value;

        } else {
            $this->prefix = null;
            $this->value = 0;
        }

        return $this;
    }

    /**
     * create a wedge string based on the prefixID and a value
     * 
     * @param int $prefixID wedge prefix
     * @param int $value wedge value
     * @return null|int|string wedge string
     */
    private function toWedgeString(int $value, int $prefixID = null)
    {
        // not a meaningful throw
        if($value < 1)
            return null;

        if($value > 60)
            return null;

        // translate Bullseye
        if($value == 25 && $prefixID == 1) {
            $prefixID = 4;
            $value = null;
        }

        // translate Bull
        if($value == 25 && $prefixID == 0) {
            $prefixID = 3;
            $value = null;
        }
                
        if($value >= 60) {

            return;
        }

        $prefix = $this->resolvePrefix($prefixID);
        return $prefix ? $prefix.$value : $value;
    }

    /**
     * 
     * @param int $prefixID
     * @return null|string|(null|string)[] resolved wedgename. when null is returned field is normal single value
     */
    private function resolvePrefix(int $prefixID)
    {
        return is_null($prefixID) ? null : $this->PREFIXES[$prefixID];
    }

    /**
     * Split a wedge string in prefix and its value
     * 
     * @param string|null $wedgeString
     * @return array
     */
    public static function splitString(string|null $wedgeString)
    {
        $wedgeParts = preg_split('/(?<=[a-z])(?=\d)/i', $wedgeString);
        
        if(sizeOf($wedgeParts) == 1) {
            $wedgeParts[0] = intval($wedgeParts[0]);
            $wedgeParts[] = null;
            $wedgeParts = array_reverse($wedgeParts);
        } else {
            $wedgeParts[1] = intval($wedgeParts[1]);
        }

        return [$wedgeParts[0], $wedgeParts[1] ? $wedgeParts[1] : null ];
    }

    /**
     * 
     * @param string|null $wedgeString
     * @return bool true when valid, false when invalid
     */
    public function isValid(string|null $wedgeString)
    {
        $wedgeParts = $this->splitString($wedgeString);

        if($wedgeParts[0])
            if(!in_array($wedgeParts[0], $this->PREFIXES))
                return false;

        if($wedgeParts[1] > 20 || $wedgeParts[0] < 0)
            return false;


        return true;
    }
}