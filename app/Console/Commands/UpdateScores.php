<?php
namespace Furnace\Console\Commands;

use Furnace\Entities\Models\Track;
use Furnace\Services\ScoreComputer;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class UpdateScores extends Command
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
        $tracks   = Track::all();
        $progress = new ProgressBar($this->output, count($tracks));
        $progress->start();
        foreach ($tracks as $track) {
            $this->scoresComputer->forTrack($track);
            $progress->advance();
        }

        $progress->finish();
    }
}
