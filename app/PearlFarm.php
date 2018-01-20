<?php namespace App;

use Eloquent;

class PearlFarm extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlFarm::where('imageid', $id)->count();
        return $item > 0? PearlFarm::createId(): $id;
    }
}
