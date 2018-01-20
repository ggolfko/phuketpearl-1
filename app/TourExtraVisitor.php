<?php namespace App;

use Eloquent;

class TourExtraVisitor extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = TourExtraVisitor::where('extraid', $id)->count();
        return $item > 0? TourExtraVisitor::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->extraid = self::createId();
        });
    }
}
