<?php namespace App;

use Eloquent;

class StoryImage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = StoryImage::where('imageid', $id)->count();
        return $item > 0? StoryImage::createId(): $id;
    }
}
