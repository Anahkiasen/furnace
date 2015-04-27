<?php
namespace Furnace\Services\Search\Fragments;

use ElasticSearcher\Abstracts\AbstractFragment;

class ExcludeKeysFilter extends AbstractFragment
{
    /**
     * ExcludeKeysFilter constructor.
     *
     * @param integer[] $keys
     */
    public function __construct(array $keys)
    {
        $this->body = [
            'not' => [
                'filter' => [
                    'ids' => [
                        'values' => $keys,
                    ],
                ],
            ],
        ];
    }
}
