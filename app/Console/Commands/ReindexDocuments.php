<?php namespace Furnace\Console\Commands;

use Furnace\Entities\Models\Track;
use Illuminate\Database\Eloquent\Model;

class ReindexDocuments extends AbstractCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'elastic:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex the ES database.';

    /**
     * The models to reindex
     *
     * @type array
     */
    protected $models = [Track::class];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        foreach ($this->models as $model) {
            $entries = $model::all();
            $this->progressIterator($entries, function (Model $entry) {
                $entry->save();
            });
        }
    }
}
