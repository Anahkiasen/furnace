<?php
namespace Notetracker\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    /**
     * @type array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    /**
     * @return float
     */
    public function getRatingAttribute()
    {
        $ratings = $this->tracks->lists('rating');
        $ratings = array_sum($ratings) / count($ratings);

        return round($ratings, 1);
    }
}
