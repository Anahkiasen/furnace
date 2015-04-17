<?php namespace Furnace\Commands;

use Furnace\Commands\Command;

class UpsertTrackCommand
{
    /**
     * @type integer|null
     */
    public $ignition;

    /**
     * @type integer|null
     */
    public $track;

    /**
     * @param integer|null $track
     * @param integer|null $ignition
     */
    public function __construct($track = null, $ignition = null)
    {
        $this->track    = $track;
        $this->ignition = $ignition;
    }
}
