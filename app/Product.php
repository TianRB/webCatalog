<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['display_name', 'description', 'sugested_price'];

	public function pics() {
		return $this->hasMany('App\Pic');
	}
	public function tags(){
		return $this->belongsToMany('App\Tag');
	}
	public function categories(){
		return $this->belongsToMany('App\Category');
	}
	// App\Product::available()->get();
	public function scopeAvailable($query){
		return $query->where('available', true);
	}
}
