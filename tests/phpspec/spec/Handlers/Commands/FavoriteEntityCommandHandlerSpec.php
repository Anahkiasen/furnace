<?php

namespace spec\Furnace\Handlers\Commands;

use Furnace\Commands\FavoriteEntityCommand;
use Furnace\Entities\Models\Favorite;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use Furnace\Entities\Models\User;
use Furnace\Handlers\Commands\FavoriteEntityCommandHandler;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin FavoriteEntityCommandHandler
 */
class FavoriteEntityCommandHandlerSpec extends LaravelObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new Favorite());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FavoriteEntityCommandHandler::class);
    }

    public function it_can_favorite_item()
    {
        $tracker = Tracker::create([]);
        $item    = Track::create(['tracker_id' => $tracker->id]);
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
        $tracker = Tracker::create([]);
        $item    = Track::create(['tracker_id' => $tracker->id]);
        $user    = User::first();

        $command = new FavoriteEntityCommand($user, Track::class, $item->id);

        $this->handle($command);
        $second = $this->handle($command);

        $second->shouldBe(true);
    }
}
