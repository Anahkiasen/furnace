<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\FavoriteEntityCommand;
use Furnace\Entities\Models\Favorite;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use Furnace\Entities\Models\User;
use Furnace\Handlers\Commands\FavoriteEntityCommandHandler;
use League\FactoryMuffin\Facade;
use Prophecy\Argument;
use spec\Furnace\FurnaceObjectBehavior;

/**
 * @mixin FavoriteEntityCommandHandler
 */
class FavoriteEntityCommandHandlerSpec extends FurnaceObjectBehavior
{
    public function let()
    {
        parent::let();

        $this->beConstructedWith(new Favorite());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FavoriteEntityCommandHandler::class);
    }

    public function it_can_favorite_item()
    {
        $item = $this->getDummyTrack();
        $user    = User::first();

        $command  = new FavoriteEntityCommand($user, Track::class, $item->id);
        $favorite = $this->handle($command);

        $favorite->shouldHaveType(Favorite::class);
        $favorite->user_id->shouldBeLike($user->id);
        $favorite->favoritable_type->shouldEqual(Track::class);
        $favorite->favoritable_id->shouldBeLike($item->id);
    }

    public function it_can_toggle_favorite()
    {
        $item = $this->getDummyTrack();
        $user    = User::first();

        $command = new FavoriteEntityCommand($user, Track::class, $item->id);
        $first = $this->handle($command);
        unset($user->favorites);
        $second = $this->handle($command);

        $second->shouldBe(true);
    }
}
