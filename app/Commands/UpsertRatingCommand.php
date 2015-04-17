<?php
namespace Furnace\Commands;

use Arrounded\ParameterBag;
use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\User;

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
     * @type User
     */
    public $user;

    /**
     * UpsertRatingCommand constructor.
     *
     * @param array       $attributes
     * @param User        $user
     * @param Rating|null $rating
     */
    public function __construct(array $attributes, User $user, Rating $rating = null)
    {
        $this->attributes = new ParameterBag($attributes);
        $this->rating     = $rating;
        $this->user       = $user;
    }
}
