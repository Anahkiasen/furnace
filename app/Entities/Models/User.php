<?php
namespace Furnace\Entities\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Furnace\Entities\Interfaces\Favoritable;
use Gravatar;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, SluggableInterface
{
    use Authenticatable, CanResetPassword, SluggableTrait;

    /**
     * @type array
     */
    protected $sluggable = [];

    /**
     * The attributes that are mass assignable.
     *
     * @type array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'twitter_id',
        'facebook_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @type array
     */
    protected $hidden = ['password', 'remember_token'];

    //////////////////////////////////////////////////////////////////////
    //////////////////////////// RELATIONSHIPS ///////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class)->orderBy('favoritable_type');
    }

    //////////////////////////////////////////////////////////////////////
    ///////////////////////////// ATTRIBUTES /////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @param Favoritable $favoritable
     *
     * @return bool
     */
    public function hasFavorited(Favoritable $favoritable)
    {
        foreach ($this->favorites as $favorite) {
            if ($favorite->favoritable_type === get_class($favoritable) && $favorite->favoritable_id === $favoritable->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $size
     *
     * @return string
     */
    public function avatar($size = 'default')
    {
        return Gravatar::get($this->email, $size);
    }

    /**
     * @return string
     */
    public function getIdentifierAttribute()
    {
        return $this->name;
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
