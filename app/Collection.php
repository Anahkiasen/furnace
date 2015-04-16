<?php
namespace Furnace;

class Collection extends \Illuminate\Database\Eloquent\Collection
{
    /**
     * Get the average of an attribute.
     *
     * @param string $attribute
     * @param int    $precision
     *
     * @return float
     */
    public function average($attribute, $precision = 1)
    {
        $items   = $this->lists($attribute);
        $average = array_sum($items) / count($items);
        $average = round($average, $precision);

        return $average;
    }
}
