<?php namespace Furnace\Commands;

use Furnace\Commands\Command;

class UpsertTrackCommand
{
    /**
     * @type integer
     */
    public $ignition;

    /**
     * @param integer $ignition
     */
    public function __construct($ignition)
    {
        $this->ignition = $ignition;
    }
}
