<?php
namespace Furnace\Commands;

class UpsertTrackCommand
{
    /**
     * @type int
     */
    public $ignition;

    /**
     * @param int $ignition
     */
    public function __construct($ignition)
    {
        $this->ignition = $ignition;
    }
}
