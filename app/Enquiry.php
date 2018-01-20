<?php namespace App;

use Eloquent;

class Enquiry extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Enquiry::where('enquiryid', $id)->count();
        return $item > 0? Enquiry::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->enquiryid = self::createId();
        });
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function messages()
    {
        return $this->hasMany('App\EnquiryMessage');
    }
}
