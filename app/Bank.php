<?php namespace App;

use Eloquent;

class Bank extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Bank::where('bankid', $id)->count();
        return $item > 0? Bank::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->bankid = self::createId();
        });
    }
}
