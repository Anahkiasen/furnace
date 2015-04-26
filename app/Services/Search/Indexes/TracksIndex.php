<?php
namespace Furnace\Services\Search\Indexes;

use ElasticSearcher\Abstracts\AbstractIndex;

class TracksIndex extends AbstractIndex
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'tracks';
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return [
            'tracks' => [
                'properties' => [

                ],
            ]
        ];
    }
}
