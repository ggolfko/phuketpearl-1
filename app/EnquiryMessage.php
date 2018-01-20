<?php namespace App;

use Eloquent;

class EnquiryMessage extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = EnquiryMessage::where('messageid', $id)->count();
        return $item > 0? EnquiryMessage::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->messageid = self::createId();
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
