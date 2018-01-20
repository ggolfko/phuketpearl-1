<?php namespace App;

use Eloquent;

class MediaSpecialGuest extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = MediaSpecialGuest::where('itemid', $id)->count();
        return $item > 0? MediaSpecialGuest::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->itemid = self::createId();
        });
    }

	public function images()
    {
        return $this->hasMany('App\MediaSpecialGuestImage', 'item_id');
    }

	public function getTopic($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'media_special_guests')
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
}
