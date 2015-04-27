<?php
namespace Furnace\Http\Controllers;

use ElasticSearcher\Abstracts\AbstractQuery;
use Furnace\Collection;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class AbstractController extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    /**
     * Run an ES query.
     *
     * @param string $query
     * @param array  $data
     *
     * @return Collection
     */
    protected function executeQuery($query, array $data = [])
    {
        /** @type AbstractQuery $query */
        $query = app($query);
        $query->addData($data);

        return $query->run()->getResults();
    }
}
