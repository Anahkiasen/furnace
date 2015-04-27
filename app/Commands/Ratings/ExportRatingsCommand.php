<?php namespace Furnace\Commands\Ratings;

use Furnace\Collection;
use Furnace\Commands\Command;

class ExportRatingsCommand
{
    /**
     * @type Collection
     */
    public $ratings;

    /**
     * @param Collection $ratings
     */
    public function __construct(Collection $ratings)
    {
        $this->ratings = $ratings;
    }
}
