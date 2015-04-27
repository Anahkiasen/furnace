<?php
namespace Furnace\Services;

use Furnace\Collection;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\Tracker;

class ScoreComputer
{
    /**
     * @type array
     */
    protected $weights;

    /**
     * @type bool
     */
    protected $persists = true;

    /**
     * The standard number of difficulty levels.
     */
    const STANDARD_DIFFICULTY_LEVELS = 5;

    /**
     * The max score a multichoice criteria can have.
     */
    const INTEGER_CRITERIA_SCALE = 3;

    /**
     * @type int
     */
    const RATING_SCALE = 12;

    /**
     * ScoreComputer constructor.
     *
     * @param array $weights
     */
    public function __construct(array $weights)
    {
        $this->weights = $weights;
    }

    //////////////////////////////////////////////////////////////////////
    ////////////////////////////// OPTIONS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return array
     */
    public function getWeights()
    {
        return $this->weights;
    }

    /**
     * @param array $weights
     */
    public function setWeights($weights)
    {
        $this->weights = $weights;
    }

    /**
     * @return bool
     */
    public function isPersists()
    {
        return $this->persists;
    }

    /**
     * @param bool $persists
     */
    public function setPersists($persists)
    {
        $this->persists = $persists;
    }

    //////////////////////////////////////////////////////////////////////
    /////////////////////////////// SCORES ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @param Tracker $tracker
     *
     * @return float
     */
    public function forBlacksmith(Tracker $tracker)
    {
        $score          = $this->computeBlacksmithScore($tracker);
        $tracker->score = $score;

        if ($this->persists) {
            $tracker->save();
        }

        return $score;
    }

    /**
     * @param Track $track
     *
     * @return float
     */
    public function forTrack(Track $track)
    {
        if (!$track->version) {
            return 0;
        }

        // Compute track's score from its versions
        $score = $this->computeTrackScore($track, $track->version->ratings);
        if ($track->previousVersions->count()) {
            $previousScore = $this->computeTrackScore($track, $track->previousVersions->first()->ratings);
            $score         = ($previousScore * 0.25 + $score * 0.75) / 2;
        }

        // Round up and ceil
        $score = round($score, 1);
        $score = min($score, static::RATING_SCALE);

        // Assign score and save
        $track->score = $score;
        if ($this->persists) {
            $track->save();
        }

        // Update Blacksmith's score
        if ($track->tracker) {
            $this->forBlacksmith($track->tracker);
        }

        return $score;
    }

    //////////////////////////////////////////////////////////////////////
    ////////////////////////////// HELPERS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @param Track      $track
     * @param Collection $ratings
     *
     * @return float|int
     */
    protected function computeTrackScore(Track $track, Collection $ratings)
    {
        $components = $this->applyWeights([
            'tone'              => $ratings->average('tone') / static::INTEGER_CRITERIA_SCALE,
            'audio'             => $ratings->average('audio') / static::INTEGER_CRITERIA_SCALE,
            'tab'               => $ratings->average('tab') / static::INTEGER_CRITERIA_SCALE,
            'sync'              => $ratings->average('sync'),
            'techniques'        => $ratings->average('techniques'),
            'normalized_volume' => $ratings->average('normalized_volume'),
            'presilence'        => $ratings->average('presilence'),
            'playable'          => $ratings->average('playable'),
            'dd'                => $track->dd,
            'riff_repeater'     => $track->riff_repeater,
            'has_pc'            => $track->platforms['pc'],
            'platforms'         => count($track->platforms) / 4,
            'difficulty_levels' => min(1, round($track->difficulty_levels / static::STANDARD_DIFFICULTY_LEVELS)),
        ]);

        return array_sum($components);
    }

    /**
     * @param Tracker $tracker
     *
     * @return float
     */
    protected function computeBlacksmithScore(Tracker $tracker)
    {
        $ratings = $tracker->tracks->lists('score');
        if (!$ratings) {
            return 0;
        }

        $ratings = array_sum($ratings) / count($ratings);
        $rating  = round($ratings, 1);

        return $rating;
    }

    /**
     * Apply weights to the formula's components.
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
