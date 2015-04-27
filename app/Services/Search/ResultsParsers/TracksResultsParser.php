<?php
namespace Furnace\Services\Search\ResultsParsers;

use ElasticSearcher\Abstracts\AbstractResultParser;
use Furnace\Entities\Models\Track;

class TracksResultsParser extends AbstractResultParser
{
    /**
     * Parse the raw results and convert to usable results.
     * This could for example fetch models in an ORM, based on the hits.
     */
    public function getResults()
    {
        $results = $this->getHits();
        $order   = array_column($results, '_id');

        // Retrieve and sort the results by score
        $tracks = Track::find($order);
        $tracks->sort(function ($a, $b) use ($order) {
            $positionB = array_search($b->id, $order, true);
            $positionA = array_search($a->id, $order, true);

            return $positionA - $positionB;
        });

        return $tracks;
    }
}
