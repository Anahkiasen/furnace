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
                '_id'        => [
                    'path' => 'id',
                ],
                'properties' => [
                    'id'                => ['type' => 'integer'],
                    'artist'            => ['type' => 'string'],
                    'album'             => ['type' => 'string'],
                    'name'              => ['type' => 'string'],
                    'slug'              => ['type' => 'string'],
                    'parts'             => [
                        'properties' => [
                            'lead'   => ['type' => 'boolean'],
                            'rhythm' => ['type' => 'boolean'],
                            'bass'   => ['type' => 'boolean'],
                            'vocals' => ['type' => 'boolean'],
                        ],
                    ],
                    'tuning'            => ['type' => 'string'],
                    'version'           => ['type' => 'string'],
                    'dd'                => ['type' => 'boolean'],
                    'riff_repeater'     => ['type' => 'boolean'],
                    'difficulty_levels' => ['type' => 'integer'],
                    'platforms'         => [
                        'properties' => [
                            'pc'      => ['type' => 'boolean'],
                            'mac'     => ['type' => 'boolean'],
                            'xbox360' => ['type' => 'boolean'],
                            'ps3'     => ['type' => 'boolean'],
                        ],
                    ],
                    'score'             => ['type' => 'float'],
                    'tracker'           => ['type' => 'string'],
                    'tags'              => ['type' => 'string'],
                ],
            ]
        ];
    }
}
