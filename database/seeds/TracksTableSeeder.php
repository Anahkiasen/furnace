<?php

use Furnace\Entities\Models\Artist;
use Furnace\Entities\Models\Track;
use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Symfony\Component\Console\Helper\ProgressBar;

class TracksTableSeeder extends Seeder
{
    public function run()
    {
        $tracks   = $this->getTracks();
        $progress = new ProgressBar($this->command->getOutput(), count($tracks));
        $progress->start();

        foreach ($tracks as $track) {
            if ($track['file']) {
                $track  = $this->container->make('ignition')->complete($track);
                Track::firstOrCreate($track);
            }

            $progress->advance();
        }

        $progress->finish();
    }

    /**
     * @return array
     */
    protected function getTracks()
    {
        $tracks = database_path('fixtures/tracks.csv');
        $tracks = Reader::createFromPath($tracks);
        $tracks = $tracks->fetchAssoc(0);

        return $tracks;
    }
}
