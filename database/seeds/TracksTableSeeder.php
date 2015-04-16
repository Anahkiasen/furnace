<?php

use Furnace\Entities\Models\Track;
use Furnace\Entities\Seeders\AbstractSeeder;
use Symfony\Component\Console\Helper\ProgressBar;

class TracksTableSeeder extends AbstractSeeder
{

    public function run()
    {
        $tracks   = $this->getFixture('tracks');
        $progress = new ProgressBar($this->output, count($tracks));
        $progress->start();

        foreach ($tracks as $track) {
            if ($track['file']) {
                $track = $this->container->make('ignition')->complete($track);
                Track::firstOrCreate($track);
            }

            $progress->advance();
        }

        $progress->finish();
    }
}
