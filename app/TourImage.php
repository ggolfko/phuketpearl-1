<?php namespace App;

use Eloquent;

class TourImage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = TourImage::where('imageid', $id)->count();
        return $item > 0? TourImage::createId(): $id;
    }
}
