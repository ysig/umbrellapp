<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    public $timestamps = false;
	protected $fillable = ['User', 'City', 'Country'];
}
