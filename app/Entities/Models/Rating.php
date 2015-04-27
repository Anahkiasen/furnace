<?php
namespace Furnace\Entities\Models;

use Collective\Annotations\Database\Eloquent\Annotations\Annotations\Bind;

/**
 * @Bind("ratings")
 */
class Rating extends AbstractModel
{
    /**
     * @type array
     */
    protected $fillable = [
        'presilence',
        'normalized_volume',
        'playable',
        'tone',
        'audio',
        'sync',
        'techniques',
        'tab',
        'difficulty',
        'comments',
        'track_id',
        'user_id',
        'platform',
        'total',
        'track_id',
        'user_id',
    ];

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// RELATIONSHIPS ///////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
