<?php namespace App;

use Eloquent;

class BankMap extends Eloquent {

    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }
}
