<?php
namespace Notetracker\Console;

use Silly\Application;

class Console extends Application
{
    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct('Notetracker', $version);

        $this->command('greet [name]', function ($name) {

        });
    }
}
