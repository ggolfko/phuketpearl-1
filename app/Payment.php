<?php namespace App;

use Eloquent;

class Payment extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Payment::where('paymentid', $id)->count();
        return $item > 0? Payment::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->paymentid = self::createId();
        });
    }

    public function banks()
    {
        return $this->hasMany('App\BankMap');
    }
}
