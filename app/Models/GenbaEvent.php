<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenbaEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'location',
        'start_date',
        'end_date',
        'priority',
        'pic',
        'description'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}