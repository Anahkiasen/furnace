<?php
namespace Furnace\Entities\Models;

class Tracker extends AbstractModel
{
    /**
     * @type array
     */
    protected $guarded = [];

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// RELATIONSHIPS ///////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    //////////////////////////////////////////////////////////////////////
    ///////////////////////////// ATTRIBUTES /////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return float
     */
    public function getRatingAttribute()
    {
        $ratings = $this->tracks->lists('rating');
        $ratings = array_sum($ratings);

        return round($ratings, 1);
    }

    /**
     * @return string[]
     */
    public function getArtistsAttribute()
    {
        $artists = $this->tracks->lists('artist');
        $artists = array_unique($artists);
        sort($artists);

        return $artists;
    }
}
