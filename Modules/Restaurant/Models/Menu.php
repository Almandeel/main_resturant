<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function items()
    {
        return $this->belongsToMany('App\Item')->withPivot('status')->withTimestamps();
    }
}
