<?php namespace App;

use Eloquent;

class MediaSpecialGuestImage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = MediaSpecialGuestImage::where('imageid', $id)->count();
        return $item > 0? MediaSpecialGuestImage::createId(): $id;
    }
}
