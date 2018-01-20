<?php namespace App;

use Eloquent;

class PearlFarmingSlide extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlFarmingSlide::where('slideid', $id)->count();
        return $item > 0? PearlFarmingSlide::createId(): $id;
    }

	protected static function createImageId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlFarmingSlide::where('imageid', $id)->count();
        return $item > 0? PearlFarmingSlide::createImageId(): $id;
    }

	public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->slideid = self::createId();
        });
    }

	public function getDescription($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'pearlfarming')
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
}
