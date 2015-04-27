<?php

namespace spec\Furnace\Services;

use Config;
use Furnace\Collection;
use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;
use Furnace\Entities\Models\Version;
use Furnace\Services\ScoreComputer;
use League\FactoryMuffin\Facade;
use Prophecy\Argument;
use spec\Furnace\FurnaceObjectBehavior;

/**
 * @mixin ScoreComputer
 */
class ScoreComputerSpec extends FurnaceObjectBehavior
{
    public function let()
    {
        parent::let();

        $this->beConstructedWith(
            Config::get('furnace.weights')
        );

        $this->setPersists(false);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ScoreComputer::class);
    }

    public function it_can_compute_score_of_single_version_track()
    {
        $version          = new Version(['name' => '1.0']);
        $version->ratings = new Collection([
            $this->getDummyRating(1),
            $this->getDummyRating(3),
        ]);

        $track = Facade::instance(Track::class, [
            'platforms'         => 'pc,mac,xbox360,ps3',
            'riff_repeater'     => true,
            'dd'                => true,
            'difficulty_levels' => ScoreComputer::STANDARD_DIFFICULTY_LEVELS,
        ]);

        $track->previousVersions = new Collection();
        $track->versions         = new Collection([$version]);

        $score = $this->forTrack($track, false);
        $score->shouldBeLike(ScoreComputer::RATING_SCALE);
    }

    public function it_can_compute_score_of_multiple_versions_track()
    {
        $previousVersion          = new Version(['name' => '1.0']);
        $previousVersion->ratings = new Collection([
            $this->getDummyRating(1),
            $this->getDummyRating(1),
        ]);

        $version          = new Version(['name' => '2.0']);
        $version->ratings = new Collection([
            $this->getDummyRating(1),
            $this->getDummyRating(3),
        ]);

        $track = Facade::instance(Track::class, [
            'platforms'         => 'pc,mac,xbox360,ps3',
            'riff_repeater'     => true,
            'dd'                => true,
            'difficulty_levels' => ScoreComputer::STANDARD_DIFFICULTY_LEVELS,
        ]);

        $track->previousVersions = new Collection([$previousVersion]);
        $track->versions         = new Collection([$version]);

        $score = $this->forTrack($track, false);
        $score->shouldBeLike(5.9);
    }

    public function it_can_compute_blacksmith_score()
    {
        $blacksmith         = Facade::instance(Tracker::class);
        $blacksmith->tracks = new Collection([
            new Track(['score' => 5]),
            new Track(['score' => 10]),
        ]);

        $score = $this->forBlacksmith($blacksmith);
        $score->shouldBeLike(7.5);
    }
}
