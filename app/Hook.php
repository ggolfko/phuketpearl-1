<?php namespace App;

use Eloquent;

class Hook extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Hook::where('hookid', $id)->count();
        return $item > 0? Hook::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->hookid = self::createId();
        });
    }

    public function images()
    {
        return $this->hasMany('App\HookImage');
    }
}
