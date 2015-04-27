<?php

use Furnace\Commands\Ratings\ImportRatingsCommand;
use Furnace\Entities\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Bus\DispatchesCommands;
use League\Csv\Reader;

class TracksTableSeeder extends Seeder
{
    use DispatchesCommands;

    public function run()
    {
        $this->dispatchFromArray(ImportRatingsCommand::class, [
            'user'    => User::first(),
            'ratings' => $this->getTracks(),
        ]);
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
