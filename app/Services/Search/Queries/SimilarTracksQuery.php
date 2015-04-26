<?php
namespace Furnace\Services\Search\Queries;

use ElasticSearcher\Abstracts\AbstractQuery;
use Furnace\Services\Search\ResultsParsers\TracksResultsParser;

class SimilarTracksQuery extends AbstractQuery
{
    /**
     * Prepare the query. Add filters, sorting, ....
     */
    protected function setup()
    {
        $this->searchIn('tracks', 'tracks');
        $this->parseResultsWith(new TracksResultsParser());

        $this->body['size']  = 25;
        $this->body['query'] = [
            'filtered' => [
                'query'  => [
                    'more_like_this' => [
                        'fields'        => [
                            'artist',
                            'tracker',
                            'tags',
                        ],
                        'ids'           => $this->getData('tracks'),
                        'min_term_freq' => 1,
                        'min_doc_freq'  => 1,
                    ]
                ],
                'filter' => [
                    'range' => [
                        'score' => ['gt' => 5],
                    ]
                ]
            ]
        ];
    }
}
