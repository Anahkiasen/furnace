<?php namespace Furnace\Console\Commands;

use ElasticSearcher\ElasticSearcher;
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
     * @type ElasticSearcher
     */
    protected $search;

    /**
     * ReindexDocuments constructor.
     *
     * @param ElasticSearcher $search
     */
    public function __construct(ElasticSearcher $search)
    {
        parent::__construct();

        $this->search = $search;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->search->indicesManager()->delete('tracks');
        $this->search->indicesManager()->create('tracks');

        foreach ($this->models as $model) {
            $entries = $model::all();
            $this->progressIterator($entries, function (Model $entry) {
                $entry->save();
            });
        }
    }
}
