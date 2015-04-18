<?php
namespace Furnace\Entities\Models;

class Favorite extends AbstractModel
{
    /**
     * @type array
     */
    protected $fillable = [
        'favoritable_type',
        'favoritable_id',
        'user_id',
    ];

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// RELATIONSHIPS ///////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favoritable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
