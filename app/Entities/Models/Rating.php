<?php
namespace Furnace\Entities\Models;

class Rating extends AbstractModel
{
    /**
     * @type array
     */
    protected $fillable = [
        'comments',
        'presilence',
        'normalized_volume',
        'playable',
        'tone',
        'track',
        'tab',
        'track_id',
        'user_id',
    ];
}
