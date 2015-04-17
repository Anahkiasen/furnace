<?php
namespace Furnace\Commands;

class CreateUserCommand
{
    /**
     * @type string
     */
    public $name;

    /**
     * @type string
     */
    public $email;

    /**
     * @type string
     */
    public $password;

    /**
     * CreateUserCommand constructor.
     *
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function __construct($email, $name, $password)
    {
        $this->email    = $email;
        $this->name     = $name;
        $this->password = $password;
    }
}
