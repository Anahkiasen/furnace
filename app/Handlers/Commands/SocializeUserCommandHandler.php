<?php namespace Furnace\Handlers\Commands;

use Furnace\Commands\SocializeUserCommand;
use Furnace\Entities\Models\User;

class SocializeUserCommandHandler
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
     * @param  SocializeUserCommand $command
     *
     * @return void
     */
    public function handle(SocializeUserCommand $command)
    {
        // Look for user with similar provider id
        $field = $command->provider.'_id';
        $user  = $this->repository->where($field, $command->user->getId())->first();
        if ($user) {
            return $user;
        }

        return $this->repository->create([
            'email' => $command->user->getEmail(),
            'name'  => $command->user->getNickname() ?: $command->user->getName(),
            $field  => $command->user->getId(),
        ]);
    }
}
