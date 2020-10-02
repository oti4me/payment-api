<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class User
 * @package App\Models
 */
class User extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['firstName', 'lastName', 'email', 'password'];

    /**
     * @var string[]
     */
    protected $hidden = ['password'];

    /**
     * @return HasOne
     */
    public function products()
    {
        return $this->hasOne('App\Models\Product');
    }

    /**
     * @return HasMany
     */
    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }
}
