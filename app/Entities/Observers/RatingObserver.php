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
    public function saving(Rating $rating)
    {
        $rating->total = array_sum([
            $rating->presilence,
            $rating->normalized_volume,
            $rating->playable,
            $rating->tone,
            $rating->audio,
            $rating->sync,
            $rating->techniques,
            $rating->tab,
        ]);
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
