<?php
namespace Furnace\Services\Search\Fragments;

use ElasticSearcher\Abstracts\AbstractFragment;

class ScoreFilter extends AbstractFragment
{
    /**
     * @param integer $score
     */
    public function __construct($score)
    {
        $this->body = [
            'range' => [
                'score' => [
                    'gte' => $score,
                ]
            ]
        ];
    }
}
