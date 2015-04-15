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
     * @type int
     */
    const RATING_SCALE = 18;

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// RELATIONSHIPS ///////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tracker()
    {
        return $this->belongsTo(Tracker::class);
    }

    //////////////////////////////////////////////////////////////////////
    ///////////////////////////// ATTRIBUTES /////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * Get the rating of the track.
     *
     * @return float
     */
    public function getRatingAttribute()
    {
        if (!$this->playable) {
            return 0;
        }

        $parts = array_filter($this->parts);

        $notes = [
            $this->tone,
            $this->track,
            $this->tab,
            !$this->live,
            $this->normalized_volume,
            $this->presilence,
            $this->dd,
            count($parts),
            $this->updated_at->diffInMonths() < 6,
        ];

        $rating = array_sum($notes);
        $rating = round($rating, 1);

        return $rating;
    }

    /**
     * @return mixed
     */
    public function getLastUpdateAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    /**
     * Get which parts the track supports.
     *
     * @return array
     */
    public function getPartsAttribute()
    {
        $parts = explode(',', $this->attributes['parts']);

        return [
            'lead'   => array_search('lead', $parts) !== false,
            'rhythm' => array_search('rhythm', $parts) !== false,
            'bass'   => array_search('bass', $parts) !== false,
            'vocals' => array_search('vocals', $parts) !== false,
        ];
    }

    /**
     * Get the human-readable tuning.
     *
     * @return string
     */
    public function getTuningAttribute()
    {
        $tunings = [
            'estandard'      => 'E',
            'edropd'         => 'DROP D',
            'eflatstandard'  => 'E♭',
            'eflatdropflat'  => 'E♭ DROP D',
            'eflatdropdflat' => 'E♭ DROP D♭',
            'other'          => 'Other',
        ];

        return $tunings[$this->attributes['tuning']];
    }
}
