<?php

namespace Modules\Restaurant\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'size', 'number_of_tables', 'manager_id', 'phone',
    ];

    /** 
     * Get the manager of the hall (should be an employee)
     *
     * @return App\User
     */
    public function manager()
    {
        return $this->belongsTo('App\User', 'manager_id');
    }

    /** 
     * Get the tabels that belongs to this hall
     *
     * @return App\Table
     */
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
