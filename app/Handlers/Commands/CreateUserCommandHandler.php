<?php
namespace Furnace\Handlers\Commands;

use Furnace\Commands\CreateUserCommand;
use Furnace\Entities\Models\User;
use Illuminate\Contracts\Hashing\Hasher;

class CreateUserCommandHandler
{
    /**
     * @type User
     */
    private $repository;

    /**
     * @type Hasher
     */
    private $hasher;

    /**
     * @param User   $repository
     * @param Hasher $hasher
     */
    public function __construct(User $repository, Hasher $hasher)
    {
        $this->repository = $repository;
        $this->hasher     = $hasher;
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
            'password' => $this->hasher->make($command->password),
        ]);
    }
}
