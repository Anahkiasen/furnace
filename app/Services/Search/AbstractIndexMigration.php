<?php
namespace Furnace\Services\Search;

use ElasticSearcher\ElasticSearcher;
use Illuminate\Database\Migrations\Migration;

abstract class AbstractIndexMigration extends Migration
{
    /**
     * @type string
     */
    protected $index;

    /**
     * @type ElasticSearcher
     */
    protected $search;

    /**
     * Build the migration
     */
    public function __construct()
    {
        $this->search = app(ElasticSearcher::class);
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!$this->search->indicesManager()->exists($this->index)) {
            $this->search->indicesManager()->create($this->index);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $this->search->indicesManager()->delete($this->index);
    }
}
