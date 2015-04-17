<?php
namespace Furnace\Entities\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
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
