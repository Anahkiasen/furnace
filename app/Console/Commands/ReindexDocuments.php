<?php
namespace Furnace\Console\Commands;

use ElasticSearcher\ElasticSearcher;
use Furnace\Entities\Models\Track;
use Illuminate\Database\Eloquent\Model;

class ReindexDocuments extends AbstractCommand
{
    /**
     * The console command name.
     *
     * @type string
     */
    protected $name = 'elastic:reindex';

    /**
     * The console command description.
     *
     * @type string
     */
    protected $description = 'Reindex the ES database.';

    /**
     * The models to reindex.
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
        $this->recreateIndex('tracks');

        foreach ($this->models as $model) {
            $this->onModel($model, function (Model $entry) {
                $entry->save();
            });
        }
    }

    /**
     * @param string $index
     */
    protected function recreateIndex($index)
    {
        $this->search->indicesManager()->delete($index);
        $this->search->indicesManager()->create($index);
    }
}
