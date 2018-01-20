<?php namespace App;

use Eloquent;
use App\Translate;

class Tour extends Eloquent {

    protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = Tour::where('tourid', $id)->count();
        return $item > 0? Tour::createId(): $id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->tourid = self::createId();
        });
    }

    public function images()
    {
        return $this->hasMany('App\TourImage');
    }

	public function extras()
	{
		return $this->hasMany('App\TourExtraVisitor');
	}

    public function getTags()
    {
        return $this->hasMany('App\TagMap', 'model_id')->where('model', 'tour')->get();
    }

    public function getPayments()
    {
        return $this->hasMany('App\PaymentMap', 'model_id')->where('model', 'tour')->get();
    }

    public function getTitle($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'tour')
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

    public function getDetail($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'tour')
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

    public function getNote($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'tour')
                ->where('model_id', $this->id)
                ->where('field', 'note')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

    public function getHighlight($locale = null, $object = false)
    {
        $text   = '';
        $item   = false;

        if (!is_null($locale))
        {
            $translate = Translate::where('model', 'tour')
                ->where('model_id', $this->id)
                ->where('field', 'hightlight')
                ->where('locale', $locale)
                ->first();
            if ($translate){
                $text   = $translate->text;
                $item   = $translate;
            }
        }

        return $object? $item: $text;
    }

	public $areas = [
		'Ao Por',
		'Bang Tao',
		'Boat Lagoon',
		'Cape Panwa',
		'Chalong',
		'Kalim Beach',
		'Kamala',
		'Karon',
		'Kata',
		'Laguna',
		'Layan',
		'Mai Khao',
		'Nai Harn',
		'Nai Thon',
		'Nai Yang',
		'Patong',
		'Phuket Town',
		'Rawai',
		'Royal Phuket Marina',
		'Siray',
		'Surin',
		'Thalang',
		'Tri Trang'
	];
}
