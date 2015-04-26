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
                    'artist'            => ['type' => 'string'],
                    'album'             => ['type' => 'string'],
                    'name'              => ['type' => 'string'],
                    'slug'              => ['type' => 'string'],
                    'parts'             => ['type' => 'string'],
                    'tuning'            => ['type' => 'string'],
                    'version'           => ['type' => 'string'],
                    'dd'                => ['type' => 'boolean'],
                    'riff_repeater'     => ['type' => 'boolean'],
                    'difficulty_levels' => ['type' => 'integer'],
                    'platforms'         => ['type' => 'string'],
                    'score'             => ['type' => 'integer'],
                ],
            ]
        ];
    }
}
