<?php
namespace Furnace\Services\Search\ResultsParsers;

use ElasticSearcher\Abstracts\AbstractResultParser;
use Furnace\Collection;
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
        foreach ($results as $key => $result) {
            $results[$key] = Track::find($result['_id']);
        }

        return new Collection($results);
    }
}
