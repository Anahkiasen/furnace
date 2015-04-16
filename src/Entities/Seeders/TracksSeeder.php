<?php
namespace Notetracker\Entities\Seeders;

use Illuminate\Support\Arr;
use Notetracker\Entities\Models\Track;
use Notetracker\Entities\Models\Tracker;
use Symfony\Component\Console\Helper\ProgressBar;

class TracksSeeder extends AbstractSeeder
{
    /**
     * Run the seeder.
     */
    public function run()
    {
        $tracks   = $this->getFixture('tracks');
        $progress = new ProgressBar($this->output, count($tracks));
        $progress->start();

        foreach ($tracks as $track) {
            if ($track['file']) {
                $track = $this->container->get('ignition')->complete($track);
                Track::firstOrCreate($track);
            }

            $progress->advance();
        }

        $progress->finish();
    }
}
