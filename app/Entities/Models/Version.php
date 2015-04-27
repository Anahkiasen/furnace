<?php
namespace Furnace\Entities\Models;

class Version extends AbstractModel
{
    /**
     * @type array
     */
    protected $fillable = [
        'name',
        'track_id',
    ];

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// RELATIONSHIPS ///////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
