<?php namespace App;

use Eloquent;

class Story extends Eloquent {

    public function getDetail($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'story')
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
