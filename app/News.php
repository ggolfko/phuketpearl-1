<?php namespace App;

use Eloquent;

class News extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = News::where('newsid', $id)->count();
        return $item > 0? News::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->newsid = self::createId();
        });
    }

    public function images()
    {
        return $this->hasMany('App\NewsImage');
    }

    public function getTopic($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'news')
                ->where('model_id', $this->id)
                ->where('field', 'topic')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function getDescription($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'news')
                ->where('model_id', $this->id)
                ->where('field', 'description')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function getContent($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'news')
                ->where('model_id', $this->id)
                ->where('field', 'content')
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
