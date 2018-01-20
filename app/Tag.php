<?php namespace App;

use Eloquent;

class Tag extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Tag::where('tagid', $id)->count();
        return $item > 0? Tag::createId(): $id;
    }

	public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->tagid = self::createId();
        });
    }
}
