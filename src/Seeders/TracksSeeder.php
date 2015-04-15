<?php
namespace Notetracker\Seeders;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use League\Container\ContainerAwareTrait;
use League\Csv\Reader;
use Notetracker\Models\Track;
use Notetracker\Models\Tracker;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class TracksSeeder
{
    use ContainerAwareTrait;

    /**
     * @type OutputInterface
     */
    protected $output;

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        $tracks = $this->getFixtures();
        $progress = new ProgressBar($this->output, sizeof($tracks));
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
     * @return array|Collection|static
     */
    protected function getFixtures()
    {
        $reader = $this->container->get('paths.fixtures').'/tracks.csv';
        $reader = Reader::createFromPath($reader);

        return $reader->fetchAssoc(0);
    }

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
                'tab'
            ]),
            array_only($meta, [
                'artist',
                'album',
                'parts',
                'tuning',
                'version',
            ]),
            [
                'dd'                => array_get($meta, 'dd', 'no') == 'yes',
                'name'              => array_get($meta, 'title'),
                'tracker_id'        => $tracker->id,
                'created_at'        => array_get($meta, 'added'),
                'updated_at'        => array_get($meta, 'updated'),

            ]
        );
    }
}
