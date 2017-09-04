<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public $timestamps = false;
	protected $primaryKey = "User Id";
    protected $fillable = ['User Id', 'Name', 'e-mail'];
}
