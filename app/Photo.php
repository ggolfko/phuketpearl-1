<?php namespace App;

use Eloquent;

class Photo extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Photo::where('photoid', $id)->count();
        return $item > 0? Photo::createId(): $id;
    }

    public function album()
    {
        return $this->belongsTo('App\Album');
    }
}
