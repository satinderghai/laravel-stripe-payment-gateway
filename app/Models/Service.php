<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

	protected $table = 'service';
		protected $fillable = [
	'id',
	'title',
	'body',
	'image',
	'status',
	'slug',
	];
  
}
