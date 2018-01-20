<?php namespace App;

use Eloquent;

class PearlFarming extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = PearlFarming::where('farmingid', $id)->count();
        return $item > 0? PearlFarming::createId(): $id;
    }

    public function getTitle($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'pearlfarming')
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

    public function getContent($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'pearlfarming')
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

	public function slides()
    {
        return $this->hasMany('App\PearlFarmingSlide');
    }
}
