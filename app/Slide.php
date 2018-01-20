<?php namespace App;

use Eloquent;

class Slide extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Slide::where('slideid', $id)->count();
        return $item > 0? Slide::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->slideid = self::createId();
        });
    }
}
