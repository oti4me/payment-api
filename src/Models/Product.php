<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name', 'description', 'price', 'image_url'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
