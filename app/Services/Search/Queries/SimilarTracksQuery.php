<?php
namespace Furnace\Services\Search\Queries;

use ElasticSearcher\Abstracts\AbstractQuery;
use Furnace\Services\ScoreComputer;
use Furnace\Services\Search\Fragments\ExcludeKeysFilter;
use Furnace\Services\Search\Fragments\MoreLikeTheseKeysQuery;
use Furnace\Services\Search\Fragments\ScoreFilter;
use Furnace\Services\Search\ResultsParsers\TracksResultsParser;

class SimilarTracksQuery extends AbstractQuery
{
    /**
     * The field to look for similarities in.
     *
     * @type array
     */
    protected $fields = [
        'artist'  => 1,
        'tracker' => 1.5,
        'tags'    => 2,
    ];

    /**
     * Prepare the query. Add filters, sorting, ....
     */
    protected function setup()
    {
        $this->searchIn('tracks', 'tracks');
        $this->parseResultsWith(new TracksResultsParser());
        $tracks = $this->getData('tracks');

        // Build queries
        $queries = [];
        foreach ($this->fields as $field => $boost) {
            $queries[] = new MoreLikeTheseKeysQuery($tracks, [$field], $boost);
        }

        $this->body['size']  = 25;
        $this->body['query'] = [
            'filtered' => [
                'query'  => [
                    'dis_max' => [
                        'queries' => $queries,
                    ],
                ],
                'filter' => [
                    'and' => [
                        'filters' => [
                            new ExcludeKeysFilter($tracks),
                            new ScoreFilter(ScoreComputer::RATING_SCALE / 2),
                        ]
                    ]
                ]
            ]
        ];
    }
}
