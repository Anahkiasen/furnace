<?php
namespace Furnace\Console;

use Furnace\Console\Commands\ReindexDocuments;
use Furnace\Console\Commands\UpdateInformations;
use Furnace\Console\Commands\UpdateScores;
use Furnace\Console\Commands\UpdateSlugs;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @type array
     */
    protected $commands = [
        UpdateScores::class,
        UpdateInformations::class,
        UpdateSlugs::class,
        ReindexDocuments::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('furnace:scores')->daily();
    }
}
