<?php namespace App;

use Eloquent;

class Newsletter extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Newsletter::where('letterid', $id)->count();
        return $item > 0? Newsletter::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->letterid = self::createId();
        });
    }

    public function draft()
    {
        return $this->belongsTo('App\NewsletterDraft');
    }
}
