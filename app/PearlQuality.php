<?php namespace App;

use Eloquent;

class PearlQuality extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlQuality::where('itemid', $id)->count();
        return $item > 0? PearlQuality::createId(): $id;
    }

	protected static function createImageId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlQuality::where('imageid', $id)->count();
        return $item > 0? PearlQuality::createImageId(): $id;
    }

	public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->itemid = self::createId();
        });
    }

	public function getTitle($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'pearlquality')
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

	public function getDetails($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'pearlquality')
                ->where('model_id', $this->id)
                ->where('field', 'details')
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
