<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlData extends Model
{
    use HasFactory;

    protected $table = 'url_data';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'url',
        'shorten_url',
    ];
}
