<?php

namespace spec\Furnace;

use Furnace\Collection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Collection
 */
class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Collection::class);
    }

    public function it_can_compute_average_of_items()
    {
        $this->beConstructedWith([
            ['score' => 1],
            ['score' => 2],
            ['score' => 3],
        ]);

        $this->average('score')->shouldReturn((double) 2);
    }
}
