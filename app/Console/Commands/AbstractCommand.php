<?php
namespace Furnace\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

abstract class AbstractCommand extends Command
{
    /**
     * Displays progress as an iterator is looped over
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
