<?php
namespace Furnace\Entities\Models;

use Furnace\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractModel extends Model
{
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }
}
