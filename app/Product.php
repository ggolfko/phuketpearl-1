<?php namespace App;

use Eloquent;

class Product extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Product::where('productid', $id)->count();
        return $item > 0? Product::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->productid = self::createId();
        });
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function categories()
    {
        return $this->hasMany('App\ProductMap');
    }

    public function hook()
    {
        return $this->hasOne('App\Hook');
    }

	public function qualities()
    {
        return $this->hasMany('App\ProductQuality');
    }

    public function getTags()
    {
        return $this->hasMany('App\TagMap', 'model_id')->where('model', 'product')->get();
    }

    public function getTitle($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'product')
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

    public function getBodytype($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'product')
                ->where('model_id', $this->id)
                ->where('field', 'bodytype')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function getMaterials($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'product')
                ->where('model_id', $this->id)
                ->where('field', 'materials')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function getPearltype($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'product')
                ->where('model_id', $this->id)
                ->where('field', 'pearltype')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function getPearlsize($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'product')
                ->where('model_id', $this->id)
                ->where('field', 'pearlsize')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function getMoredetails($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'product')
                ->where('model_id', $this->id)
                ->where('field', 'moredetails')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function hasCategory($cid)
    {
        $has = false;

        foreach ($this->categories as $map){
            if ($map->category && $map->category->categoryid == $cid){
                $has = true;
                break;
            }
        }

        return $has;
    }
}
