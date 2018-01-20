<?php namespace App;

use Eloquent;

class NewsletterImage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = NewsletterImage::where('imageid', $id)->count();
        return $item > 0? NewsletterImage::createId(): $id;
    }
}
