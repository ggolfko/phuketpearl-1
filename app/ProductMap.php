<?php namespace App;

use Eloquent;

class ProductMap extends Eloquent {

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

	public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
