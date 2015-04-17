<?php
namespace Furnace\Commands;

use Furnace\Commands\Command;
use Furnace\Entities\Models\Rating;

class UpsertRatingCommand
{
    /**
     * @type array
     */
    public $attributes = [];

    /**
     * @type Rating
     */
    public $rating;

    /**
     * UpsertRatingCommand constructor.
     *
     * @param array  $attributes
     * @param Rating $rating
     */
    public function __construct(array $attributes, Rating $rating)
    {
        $this->attributes = $attributes;
        $this->rating     = $rating;
    }
}
