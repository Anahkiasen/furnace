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
     * The standard number of difficulty levels.
     */
    const STANDARD_DIFFICULTY_LEVELS = 5;

    /**
     * The max score a multichoice criteria can have
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
     * @param Tracker $tracker
     */
    public function forBlacksmith(Tracker $tracker)
    {
        $tracker->score = $this->computeBlacksmithScore($tracker);
        $tracker->save();
    }

    /**
     * @param Track $track
     * @param bool  $save
     *
     * @return int
     */
    public function forTrack(Track $track, $save = true)
    {
        // Update track's score
        $scores = [
            $this->computeTrackScore($track, $track->previousVersions->first()->ratings) * 0.25,
            $this->computeTrackScore($track, $track->version->ratings) * 0.75,
        ];

        $score        = array_sum($scores) / count($scores);
        $track->score = $score;
        if ($save) {
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
            'rr'                => $track->riff_repeater,
            'has_pc'            => $track->platforms['pc'],
            'platforms'         => count($track->platforms) / 4,
            'difficulty_levels' => min(1, round($track->difficulty_levels / static::STANDARD_DIFFICULTY_LEVELS)),
        ]);

        // Round up and ceil
        $rating = array_sum($components);
        $rating = round($rating, 1);
        $rating = min($rating, static::RATING_SCALE);

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
