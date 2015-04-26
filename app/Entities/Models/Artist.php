<?php
namespace Furnace\Entities\Models;

use Arrounded\Traits\JsonAttributes;

class Artist extends AbstractModel
{
    use JsonAttributes;

    /**
     * @type array
     */
    protected $fillable = [
        'name',
        'tags',
    ];

    /**
     * @param string|array $tags
     */
    public function setTagsAttribute($tags)
    {
        $this->setJsonAttribute('tags', $tags);
    }

    /**
     * @return array
     */
    public function getTagsAttribute()
    {
        return $this->getJsonAttribute('tags');
    }
}
