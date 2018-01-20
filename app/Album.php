<?php namespace App;

use Eloquent;

class Album extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Album::where('albumid', $id)->count();
        return $item > 0? Album::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->albumid = self::createId();
        });
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function cover()
    {
        return $this->belongsTo('App\Photo', 'cover_id');
    }

    public function getTitle($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'album')
                ->where('model_id', $this->id)
                ->where('field', 'title')
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
