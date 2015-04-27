<?php
namespace Furnace\Console\Commands;

use Furnace\Entities\Models\Artist;
use Furnace\Entities\Models\Track;
use Furnace\Services\Ignition;

class UpdateInformations extends AbstractCommand
{
    /**
     * @type string
     */
    protected $name = 'furnace:reignite';

    /**
     * @type string
     */
    protected $description = 'Updates the tracks informations with the latest from Ignition';

    /**
     * @type Ignition
     */
    protected $ignition;

    /**
     * UpdateInformations constructor.
     *
     * @param Ignition $ignition
     */
    public function __construct(Ignition $ignition)
    {
        parent::__construct();

        $this->ignition = $ignition;
    }

    /**
     * Run the command.
     */
    public function handle()
    {
        $this->onModel(Artist::class, function (Artist $artist) {
            $artist->save();
        });

        $this->onTracks(function (Track $track) {
            $meta = $this->ignition->complete($track->toArray());

            $track->fill($meta);
            $track->save();
        });
    }
}
