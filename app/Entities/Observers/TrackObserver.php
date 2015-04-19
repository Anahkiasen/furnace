<?php
namespace Furnace\Entities\Observers;

use Furnace\Entities\Models\Track;
use Furnace\Services\ScoreComputer;

class TrackObserver
{
    /**
     * @type ScoreComputer
     */
    protected $scoreComputer;

    /**
     * RatingObserver constructor.
     *
     * @param ScoreComputer $scoreComputer
     */
    public function __construct(ScoreComputer $scoreComputer)
    {
        $this->scoreComputer = $scoreComputer;
    }

    /**
     * @param Track $track
     */
    public function saving(Track $track)
    {
        if (!$track->isDirty('score')) {
            $track->score = $this->scoreComputer->forTrack($track, false);
        }
    }
}
