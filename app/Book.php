<?php namespace App;

use Eloquent;

class Book extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Book::where('bookid', $id)->count();
        return $item > 0? Book::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->bookid  = self::createId();
        });
    }

    public function tour()
    {
        return $this->belongsTo('App\Tour');
    }

    public function checkout()
    {
        return $this->hasOne('App\Checkout');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }

    public function messages()
    {
        return $this->hasMany('App\BookMessage');
    }

    public function informs()
    {
        return $this->hasMany('App\Inform');
    }
}
