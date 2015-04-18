<?php
namespace Furnace\Http\Controllers\Api;

use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Furnace\Commands\FavoriteEntityCommand;
use Furnace\Entities\Models\Favorite;
use Furnace\Http\Controllers\AbstractController;
use Illuminate\Contracts\Auth\Authenticatable;

class FavoritesController extends AbstractController
{
    /**
     * @Post("api/favorites/{type}/{favoritable}", as="api.favorites.store")
     * @param string          $type
     * @param integer         $favoritable
     * @param Authenticatable $user
     *
     * @return Favorite
     */
    public function store($type, $favoritable, Authenticatable $user)
    {
        return $this->dispatchFromArray(FavoriteEntityCommand::class, [
            'user'        => $user,
            'type'        => $type,
            'favoritable' => $favoritable,
        ]);
    }
}
