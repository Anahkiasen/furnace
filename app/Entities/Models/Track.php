<?php
namespace Furnace\Entities\Models;

use Collective\Annotations\Database\Eloquent\Annotations\Annotations\Bind;
use Furnace\Entities\Interfaces\Favoritable;

/**
 * @Bind("tracks")
 */
class Track extends AbstractModel implements Favoritable
{
    /**
     * @type array
     */
    protected $fillable = [
        'artist',
        'album',
        'name',
        'parts',
        'tuning',
        'version',
        'dd',
        'riff_repeater',
        'difficulty_levels',
        'score',
        'ignition_id',
        'tracker_id',
    ];

    /**
     * @type int
     */
    public static $ratingScale = 20;

    /**
     * The standard number of difficulty levels.
     */
    const STANDARD_DIFFICULTY_LEVELS = 8;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    //////////////////////////////////////////////////////////////////////
    ///////////////////////////// ATTRIBUTES /////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return bool
     */
    public function getIsPlayableAttribute()
    {
        return $this->ratings->average('playable') > 0.5;
    }

    /**
     * Get the rating of the track.
     *
     * @return float
     */
    public function getRatingAttribute()
    {
        if (!$this->isPlayable) {
            return 0;
        }

        $parts = array_filter($this->parts);

        $notes = [
            $this->ratings->average('tone'),
            $this->ratings->average('audio'),
            $this->ratings->average('tab'),
            $this->ratings->average('normalized_volume'),
            $this->ratings->average('presilence'),
            $this->dd,
            $this->riff_repeater,
            round($this->difficulty_levels / static::STANDARD_DIFFICULTY_LEVELS),
            count($parts),
            $this->updated_at->diffInMonths() < 6,
        ];

        $rating = array_sum($notes);
        $rating = round($rating, 1);

        return min($rating, static::$ratingScale);
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
            'lead'   => array_search('lead', $parts, true) !== false,
            'rhythm' => array_search('rhythm', $parts, true) !== false,
            'bass'   => array_search('bass', $parts, true) !== false,
            'vocals' => array_search('vocals', $parts, true) !== false,
        ];
    }

    /**
     * Get the human-readable tuning.
     *
     * @return string
     */
    public function getTuningAttribute()
    {
        $tuning  = $this->attributes['tuning'];
        $tunings = [
            'estandard'      => 'E',
            'edropd'         => 'DROP D',
            'eflatstandard'  => 'E♭',
            'eflatdropflat'  => 'E♭ DROP D',
            'eflatdropdflat' => 'E♭ DROP D♭',
            'dstandard'      => 'D',
            'ddropc'         => 'D DROP C',
            'other'          => 'Other',
        ];

        return array_get($tunings, $tuning, $tuning);
    }
}
