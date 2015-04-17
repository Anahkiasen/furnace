<?php namespace Furnace\Commands;

use Laravel\Socialite\AbstractUser;

class SocializeUserCommand
{
    /**
     * @type string
     */
    public $provider;

    /**
     * @type AbstractUser
     */
    public $user;

    /**
     * SocializeUserCommand constructor.
     *
     * @param string       $provider
     * @param AbstractUser $user
     */
    public function __construct($provider, AbstractUser $user)
    {
        $this->provider = $provider;
        $this->user     = $user;
    }
}
