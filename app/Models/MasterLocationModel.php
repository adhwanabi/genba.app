<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterLocationModel extends Model
{
    protected $table = 'master_location';

    protected $fillable = [
        'area',
        'pic',
    ];

    public $timestamps = true;

    /**
     * Get the area of the location.
     *
     * @return string|null
     */
    public function getAreaAttribute()
    {
        return $this->attributes['area'];
    }

    /**
     * Get the person in charge (PIC) of the location.
     *
     * @return string|null
     */
    public function getPicAttribute()
    {
        return $this->attributes['pic'];
    }
}
