<?php namespace App;

use Eloquent;

class Subscribe extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Subscribe::where('subscribeid', $id)->count();
        return $item > 0? Subscribe::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->subscribeid = self::createId();
            $model->token       = str_random();
        });
    }
}
