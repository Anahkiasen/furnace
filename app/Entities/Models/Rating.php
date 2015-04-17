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
        'comments',
        'presilence',
        'normalized_volume',
        'playable',
        'tone',
        'audio',
        'tab',
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

    //////////////////////////////////////////////////////////////////////
    ///////////////////////////// ATTRIBUTES /////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return float
     */
    public function getNoteAttribute()
    {
        $components = [
            $this->presilence,
            $this->normalized_volume,
            $this->playable,
            $this->tone,
            $this->audio,
            $this->tab,
        ];

        $note = array_sum($components);
        $note = round($note, 1);

        return $note;
    }
}
