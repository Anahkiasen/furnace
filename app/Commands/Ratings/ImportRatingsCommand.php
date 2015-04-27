<?php
namespace Furnace\Commands\Ratings;

use Furnace\Entities\Models\User;

class ImportRatingsCommand
{
    /**
     * @type array
     */
    public $ratings;

    /**
     * @type User
     */
    public $user;

    /**
     * @param User  $user
     * @param array $ratings
     */
    public function __construct(User $user, array $ratings)
    {
        $this->ratings = $ratings;
        $this->user    = $user;
    }
}
