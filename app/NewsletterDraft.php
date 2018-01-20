<?php namespace App;

use Eloquent;

class NewsletterDraft extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = NewsletterDraft::where('draftid', $id)->count();
        return $item > 0? NewsletterDraft::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->draftid = self::createId();
        });
    }
}
