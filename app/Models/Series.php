<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = [
        'tmdb_id',
        'name',
        'slug',
        'created_year',
        'poster_path',
        'rating',
        'visits',
    ];
}
