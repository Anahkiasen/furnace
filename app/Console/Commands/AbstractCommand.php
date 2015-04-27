<?php
namespace Furnace\Console\Commands;

use Furnace\Entities\Models\Track;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

abstract class AbstractCommand extends Command
{
    /**
     * Execute an action on all tracks.
     *
     * @param callable $callback
     */
    protected function onTracks(callable $callback)
    {
        $this->onModel(Track::class, $callback);
    }

    /**
     * @param string   $model
     * @param callable $callback
     */
    protected function onModel($model, callable $callback)
    {
        $tracks = $model::all();
        $this->progressIterator($tracks, $callback);
    }

    /**
     * Displays progress as an iterator is looped over.
     *
     * @param array    $items
     * @param callable $callback
     */
    protected function progressIterator($items, callable $callback)
    {
        $progress = new ProgressBar($this->output, count($items));
        $progress->start();
        foreach ($items as $item) {
            $callback($item);
            $progress->advance();
        }

        $progress->finish();
    }
}
