<?php
namespace Furnace\Handlers\Commands;

use Furnace\Commands\CreateUserCommand;
use Furnace\Entities\Models\User;

class CreateUserCommandHandler
{
    /**
     * @type User
     */
    private $repository;

    /**
     * @param User $repository
     */
    public function __construct(User $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the command.
     *
     * @param CreateUserCommand $command
     *
     * @return User
     */
    public function handle(CreateUserCommand $command)
    {
        return $this->repository->create([
            'name'     => $command->name,
            'email'    => $command->email,
            'password' => $command->password,
        ]);
    }
}
