<?php namespace App;

use Eloquent;

class PaymentMap extends Eloquent {

    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
}
