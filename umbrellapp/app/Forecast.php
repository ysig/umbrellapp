<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    public $timestamps = false;
	protected $primaryKey = 'Date';
	public $incrementing = false;
    protected $fillable = ['City', 'Country', 'Date', 'Time', 'weather', 'temp_max', 'temp_min'];
}
