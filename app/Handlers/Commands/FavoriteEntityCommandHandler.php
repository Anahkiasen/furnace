<?php
namespace Furnace\Handlers\Commands;

use Furnace\Commands\FavoriteEntityCommand;
use Furnace\Entities\Interfaces\Favoritable;
use Furnace\Entities\Models\Favorite;
use Furnace\Entities\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

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
     * @param FavoriteEntityCommand $command
     *
     * @throws InvalidArgumentException
     * @return Favorite
     *
     */
    public function handle(FavoriteEntityCommand $command)
    {
        $type = str_replace('Furnace\Entities\Models\\', null, ucfirst($command->type));
        $type = sprintf('Furnace\Entities\Models\%s', $type);
        if (!class_exists($type)) {
            throw new InvalidArgumentException();
        }

        $entity = $type::find($command->favoritable);
        if (!$entity) {
            throw new ModelNotFoundException();
        }

        $favorite = $this->toggleFavorite($command->user, $entity);

        return $favorite;
    }

    /**
     * @param User        $user
     * @param Favoritable $entity
     *
     * @return Favorite|null
     */
    protected function toggleFavorite(User $user, Favoritable $entity)
    {
        $attributes = [
            'favoritable_type' => get_class($entity),
            'favoritable_id'   => $entity->id,
            'user_id'          => $user->id,
        ];

        // Toggle favorite
        if ($user->hasFavorited($entity)) {
            $favorite = $this->repository->where($attributes)->delete() === 1;
        } else {
            $favorite = $this->repository->create($attributes);
        }

        return $favorite;
    }
}
