<?php namespace App;

use Eloquent;

class Category extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Category::where('categoryid', $id)->count();
        return $item > 0? Category::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->categoryid = self::createId();
        });
    }

    public function products()
    {
        return $this->hasMany('App\ProductMap');
    }

    public function getTitle($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'category')
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
