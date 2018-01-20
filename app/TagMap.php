<?php namespace App;

use Eloquent;

class TagMap extends Eloquent {

    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }
}
