<?php namespace App;

use Eloquent;

class Gallery extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Gallery::where('imageid', $id)->count();
        return $item > 0? Gallery::createId(): $id;
    }
}
