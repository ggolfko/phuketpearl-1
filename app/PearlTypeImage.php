<?php namespace App;

use Eloquent;

class PearlTypeImage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlTypeImage::where('imageid', $id)->count();
        return $item > 0? PearlTypeImage::createId(): $id;
    }
}
