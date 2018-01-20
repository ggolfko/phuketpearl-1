<?php namespace App;

use Eloquent;

class Timeline extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Timeline::where('timelineid', $id)->count();
        return $item > 0? Timeline::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->timelineid = self::createId();
        });
    }

    public function images()
    {
        return $this->hasMany('App\TimelineImage');
    }

    public function getDetail($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'timeline')
                ->where('model_id', $this->id)
                ->where('field', 'detail')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }
}
