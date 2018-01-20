<?php namespace App;

use Eloquent;

class TimelineImage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = TimelineImage::where('imageid', $id)->count();
        return $item > 0? TimelineImage::createId(): $id;
    }
}
