<?php namespace App;

use Eloquent;

class PearlType extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlType::where('typeid', $id)->count();
        return $item > 0? PearlType::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->typeid = self::createId();
        });
    }

    public function images()
    {
        return $this->hasMany('App\PearlTypeImage');
    }

    public function main()
    {
        return $this->belongsTo('App\PearlTypeImage', 'main_id');
    }

    public function getTitle($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'pearltype')
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

    public function getDetail($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'pearltype')
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
