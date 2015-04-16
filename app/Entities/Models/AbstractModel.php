<?php
namespace Furnace\Entities\Models;

use Illuminate\Database\Eloquent\Model;
use Furnace\Collection;

class AbstractModel extends Model
{
    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = array())
    {
        return new Collection($models);
    }
}
