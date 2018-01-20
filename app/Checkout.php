<?php namespace App;

use Eloquent;

class Checkout extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Checkout::where('checkoutid', $id)->count();
        return $item > 0? Checkout::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $transaction        = str_random();
			$model->checkoutid  = self::createId();
            $model->transaction = $transaction;
            $model->token       = \Crypt::encrypt($transaction);
        });
    }

	public function extra()
	{
		return $this->belongsTo('App\TourExtraVisitor');
	}
}
