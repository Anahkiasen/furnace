<?php
namespace Furnace\Entities\Models;

use Collective\Annotations\Database\Eloquent\Annotations\Annotations\Bind;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Furnace\Entities\Interfaces\Favoritable;
use Furnace\Entities\Traits\Indexable;

class Track extends AbstractModel implements Favoritable, SluggableInterface
{
    use SluggableTrait;
    use Indexable;

    /**
     * @type array
     */
    protected $sluggable = [];

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
        'platforms',
        'score',
        'ignition_id',
        'tracker_id',
    ];

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
     * @return string
     */
    public function getIdentifierAttribute()
    {
        if (!$this->tracker) {
            return sprintf('%s - %s', $this->artist, $this->name);
        }

        return sprintf('%s - %s (%s)', $this->artist, $this->name, $this->tracker->name);
    }

    /**
     * @return bool
     */
    public function getIsPlayableAttribute()
    {
        return $this->ratings->average('playable') > 0.5;
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
        return $this->recomposeJointArray('parts', ['lead', 'rhythm', 'bass', 'vocals']);
    }

    /**
     * Get which platforms the track supports.
     *
     * @return array
     */
    public function getPlatformsAttribute()
    {
        return $this->recomposeJointArray('platforms', ['pc', 'mac', 'xbox360', 'ps3']);
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

    /**
     * @param string   $attribute
     * @param string[] $parts
     *
     * @return array
     */
    protected function recomposeJointArray($attribute, $parts)
    {
        $recomposed = [];
        $attribute  = explode(',', $this->attributes[$attribute]);
        foreach ($parts as $part) {
            $recomposed[$part] = array_search($part, $attribute, true) !== false;
        }

        return $recomposed;
    }
}
