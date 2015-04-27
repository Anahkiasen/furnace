<?php

use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\Track;
use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Symfony\Component\Console\Helper\ProgressBar;

class TracksTableSeeder extends Seeder
{
    public function run()
    {
        $rows     = $this->getTracks();
        $progress = new ProgressBar($this->command->getOutput(), count($rows));
        $progress->start();

        foreach ($rows as $row) {
            if (!$row['file']) {
                $progress->advance();
                continue;
            }

            $track = $this->container->make('ignition')->complete($row);
            $track = Track::firstOrCreate($track);

            Rating::create([
                'presilence'        => array_get($row, 'presilence'),
                'normalized_volume' => array_get($row, 'normalized_volume'),
                'playable'          => array_get($row, 'playable'),
                'tone'              => array_get($row, 'tone'),
                'audio'             => array_get($row, 'track'),
                'sync'              => array_get($row, 'sync', true),
                'techniques'        => array_get($row, 'techniques', true),
                'tab'               => array_get($row, 'tab'),
                'difficulty'        => array_get($row, 'difficulty', 1),
                'track_id'          => $track->id,
                'user_id'           => 1,
            ]);

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
