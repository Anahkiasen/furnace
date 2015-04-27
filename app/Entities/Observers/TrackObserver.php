<?php
namespace Furnace\Entities\Observers;

use ElasticSearcher\ElasticSearcher;
use Furnace\Entities\Models\Track;
use Furnace\Services\ScoreComputer;

class TrackObserver
{
    /**
     * @type ScoreComputer
     */
    private $scoreComputer;

    /**
     * @type ElasticSearcher
     */
    private $search;

    /**
     * RatingObserver constructor.
     *
     * @param ScoreComputer   $scoreComputer
     * @param ElasticSearcher $search
     */
    public function __construct(ScoreComputer $scoreComputer, ElasticSearcher $search)
    {
        $this->scoreComputer = $scoreComputer;
        $this->search        = $search;
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

    /**
     * @param Track $track
     */
    public function saved(Track $track)
    {
        // Convert to ES document
        $document         = $track->toDocument();
        $documentsManager = $this->search->documentsManager();

        // Upsert document
        if ($documentsManager->exists('tracks', 'tracks', $track->id)) {
            $documentsManager->update('tracks', 'tracks', $track->id, $document);
        } else {
            $documentsManager->index('tracks', 'tracks', $document);
        }
    }
}
