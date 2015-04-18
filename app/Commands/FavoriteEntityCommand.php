<?php namespace Furnace\Commands;

use Furnace\Commands\Command;
use Furnace\Entities\Models\User;

class FavoriteEntityCommand
{
    /**
     * @type integer
     */
    public $favoritable;

    /**
     * @type string
     */
    public $type;

    /**
     * @type User
     */
    public $user;

    /**
     * Create a new command instance.
     *
     * @param User    $user
     * @param string  $type
     * @param integer $favoritable
     */
    public function __construct(User $user, $type, $favoritable)
    {
        $this->favoritable = $favoritable;
        $this->type        = $type;
        $this->user        = $user;
    }
}
