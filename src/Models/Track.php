<?php
namespace Notetracker\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    /**
     * @type array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tracker()
    {
        return $this->belongsTo(Tracker::class);
    }

    /**
     * @return float
     */
    public function getRatingAttribute()
    {
        $notes = [
            $this->tone,
            $this->track,
            $this->tab,
        ];

        $rating = array_sum($notes) / count($notes);
        $rating = round($rating, 1);

        return $rating;
    }
}
