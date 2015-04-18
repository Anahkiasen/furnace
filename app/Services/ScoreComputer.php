<?php
namespace Furnace\Services;

use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;

class ScoreComputer
{
    /**
     * @type array
     */
    protected $weights;

    /**
     * ScoreComputer constructor.
     *
     * @param array $weights
     */
    public function __construct(array $weights)
    {
        $this->weights = $weights;
    }

    /**
     * @param Tracker $tracker
     */
    public function forBlacksmith(Tracker $tracker)
    {
        $tracker->score = $this->computeBlacksmithScore($tracker);
        $tracker->save();
    }

    /**
     * @param Track $track
     *
     * @return int
     */
    public function forTrack(Track $track)
    {
        // Update track's score
        $track->score = $this->computeTrackScore($track);
        $track->save();

        // Update Blacksmith's score
        if ($track->tracker) {
            $this->forBlacksmith($track->tracker);
        }
    }

    //////////////////////////////////////////////////////////////////////
    ////////////////////////////// HELPERS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @param Track $track
     *
     * @return float|int
     */
    protected function computeTrackScore(Track $track)
    {
        if (!$track->isPlayable) {
            return 0;
        }

        $components = $this->applyWeights([
            $track->ratings->average('tone'),
            $track->ratings->average('audio'),
            $track->ratings->average('tab'),
            $track->ratings->average('normalized_volume'),
            $track->ratings->average('presilence'),
            $track->dd,
            $track->riff_repeater,
            round($track->difficulty_levels / Track::STANDARD_DIFFICULTY_LEVELS),
        ]);

        // Round up and ceil
        $rating = array_sum($components);
        $rating = round($rating, 1);
        $rating = min($rating, Track::$ratingScale);

        return $rating;
    }

    /**
     * @param Tracker $tracker
     *
     * @return float
     */
    protected function computeBlacksmithScore(Tracker $tracker)
    {
        $ratings = $tracker->tracks()->lists('score');
        if (!$ratings) {
            return 0;
        }

        $ratings = array_sum($ratings) / count($ratings);
        $rating  = round($ratings, 1);

        return $rating;
    }

    /**
     * Apply weights to the formula's components
     *
     * @param array $components
     *
     * @return array
     */
    private function applyWeights($components)
    {
        foreach ($this->weights as $name => $weight) {
            if (array_key_exists($name, $components)) {
                $components[$name] = $components[$name] * $weight;
            }
        }

        return $components;
    }
}
