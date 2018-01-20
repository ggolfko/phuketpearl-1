<?php namespace App;

use Eloquent;

class Inform extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Inform::where('informid', $id)->count();
        return $item > 0? Inform::createId(): $id;
    }

    public function map()
    {
        return $this->belongsTo('App\BankMap');
    }
}
