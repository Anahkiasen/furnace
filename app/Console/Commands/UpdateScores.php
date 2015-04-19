<?php
namespace Furnace\Console\Commands;

use Furnace\Entities\Models\Track;
use Furnace\Services\ScoreComputer;

class UpdateScores extends AbstractCommand
{
    /**
     * @type string
     */
    protected $name = 'furnace:scores';

    /**
     * @type string
     */
    protected $description = 'Updates all the scores at once';

    /**
     * @type ScoreComputer
     */
    protected $scoresComputer;

    /**
     * UpdateScores constructor.
     *
     * @param ScoreComputer $scoresComputer
     */
    public function __construct(ScoreComputer $scoresComputer)
    {
        parent::__construct();

        $this->scoresComputer = $scoresComputer;
    }

    /**
     * Run the command.
     */
    public function handle()
    {
        $tracks = Track::all();
        $this->progressIterator($tracks, function (Track $track) {
            $this->scoresComputer->forTrack($track);
        });
    }
}
