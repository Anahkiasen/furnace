<?php
namespace Furnace\Commands;

use Furnace\Entities\Models\User;

class FavoriteEntityCommand
{
    /**
     * @type int
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
     * @param User   $user
     * @param string $type
     * @param int    $favoritable
     */
    public function __construct(User $user, $type, $favoritable)
    {
        $this->favoritable = $favoritable;
        $this->type        = $type;
        $this->user        = $user;
    }
}
