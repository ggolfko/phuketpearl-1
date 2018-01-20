<?php namespace App;

use Eloquent;

class Doc extends Eloquent {

    public function getContent($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'doc')
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
