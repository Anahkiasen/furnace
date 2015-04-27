<?php
namespace Furnace\Services\Search\Fragments;

use ElasticSearcher\Abstracts\AbstractFragment;

class MoreLikeTheseKeysQuery extends AbstractFragment
{
    /**
     * MoreLikeTheseKeysQuery constructor.
     *
     * @param integer[] $keys
     * @param string[]  $fields
     * @param int       $boost
     */
    public function __construct(array $keys, $fields, $boost = 1)
    {
        $this->body = [
            'more_like_this' => [
                'fields'        => $fields,
                'ids'           => $keys,
                'min_term_freq' => 1,
                'min_doc_freq'  => 1,
                'boost'         => $boost,
            ],
        ];
    }
}
