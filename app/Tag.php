<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = ['display_name', 'description'];

	public $timestamps = false;

	public function products(){
		return $this->belongsToMany('App\Product');
	}
}
