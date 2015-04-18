<?php
namespace Furnace\Entities\Observers;

use Furnace\Entities\Models\Rating;
use Furnace\Services\ScoreComputer;

class RatingObserver
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
     * @param Rating $rating
     */
    public function created(Rating $rating)
    {
        $this->scoreComputer->forTrack($rating->track);
    }

    /**
     * @param Rating $rating
     */
    public function updated(Rating $rating)
    {
        $this->scoreComputer->forTrack($rating->track);
    }

    /**
     * @param Rating $rating
     */
    public function deleted(Rating $rating)
    {
        $this->scoreComputer->forTrack($rating->track);
    }
}
