<?php
namespace Furnace\Entities\Traits;

trait Indexable
{
    /**
     * Transforms the model to an ES document
     *
     * @return array
     */
    public function toDocument()
    {
        $transformer = class_basename($this);
        $transformer = sprintf('Furnace\Services\Search\Transformers\%sTransformer', $transformer);
        $transformer = new $transformer;

        return $transformer->transform($this);
    }
}
