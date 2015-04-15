<?php
namespace Notetracker\Seeders;

use Illuminate\Support\Arr;
use Notetracker\Models\Track;
use Notetracker\Models\Tracker;
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
                $track = $this->getTrackInformations($track);
                Track::firstOrCreate($track);
            }

            $progress->advance();
        }

        $progress->finish();
    }

    //////////////////////////////////////////////////////////////////////
    ////////////////////////////// HELPERS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @param $track
     *
     * @return array|mixed
     */
    protected function getTrackInformations($track)
    {
        $meta = $this->container->get('ignition')->track($track['ignition_id']);

        // Create Tracker
        $tracker = Arr::get($meta, 'member');
        if ($tracker) {
            $tracker = Tracker::firstOrCreate(['name' => $tracker]);
        } else {
            dump($track);
            exit;
        }

        return array_merge(
            array_only($track, [
                'file',
                'presilence',
                'normalized_volume',
                'live',
                'playable',
                'tone',
                'track',
                'tab',
            ]),
            array_only($meta, [
                'artist',
                'album',
                'parts',
                'tuning',
                'version',
            ]),
            [
                'dd'         => array_get($meta, 'dd', 'no') == 'yes',
                'name'       => array_get($meta, 'title'),
                'tracker_id' => $tracker->id,
                'created_at' => array_get($meta, 'added'),
                'updated_at' => array_get($meta, 'updated'),

            ]
        );
    }
}
