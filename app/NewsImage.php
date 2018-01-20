<?php namespace App;

use Eloquent;

class NewsImage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = NewsImage::where('imageid', $id)->count();
        return $item > 0? NewsImage::createId(): $id;
    }
}
