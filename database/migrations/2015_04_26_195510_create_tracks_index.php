<?php

use Furnace\Services\Search\AbstractIndexMigration;

class CreateTracksIndex extends AbstractIndexMigration
{
    /**
     * @type string
     */
    protected $index = 'tracks';
}
