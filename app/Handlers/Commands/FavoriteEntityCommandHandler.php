<?php namespace Furnace\Handlers\Commands;

use Furnace\Commands\FavoriteEntityCommand;
use Furnace\Entities\Models\Favorite;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FavoriteEntityCommandHandler
{
    /**
     * @type Favorite
     */
    private $repository;

    /**
     * Create the command handler.
     *
     * @param Favorite $repository
     */
    public function __construct(Favorite $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the command.
     *
     * @param  FavoriteEntityCommand $command
     *
     * @return Favorite
     * @throws InvalidArgumentException
     */
    public function handle(FavoriteEntityCommand $command)
    {
        $type = sprintf('Furnace\Entities\Models\%s', ucfirst($command->type));
        if (!class_exists($type)) {
            throw new InvalidArgumentException;
        }

        $entity = $type::find($command->favoritable);
        if (!$entity) {
            throw new ModelNotFoundException;
        }

        $favorite = $this->repository->create([
            'favoritable_type' => get_class($entity),
            'favoritable_id'   => $entity->id,
            'user_id'          => $command->user->id,
        ]);

        return $favorite;
    }
}
