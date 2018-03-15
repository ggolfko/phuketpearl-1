<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $params	= [];
	public $config	= [];
    public $locales = [];
	public $auth;
	public $user;

	public function __construct(Guard $auth, Request $request)
	{
		//auth
		$this->auth	= $auth;
		$this->user	= $this->auth->user();

		//info
		$settings = \App\Config::all();
		$this->config['settings']	= $settings;
		$this->config['default_lang'] = $settings->where('property', 'default_locale')->first()->value;
		$this->config['name']		= $settings->where('property', 'name')->first()->value;
        $this->config['description']= $settings->where('property', 'description')->first()->value;
        $this->config['keywords']	= json_decode($settings->where('property', 'keywords')->first()->value);
		$this->config['copyright']	= $settings->where('property', 'copyright')->first()->value;
		$this->config['phones']		= json_decode($settings->where('property', 'contact_phone')->first()->value);
		$this->config['faxes']		= json_decode($settings->where('property', 'contact_fax')->first()->value);
		$this->config['emails']		= json_decode($settings->where('property', 'contact_email')->first()->value);
        $this->config['address']	= $settings->where('property', 'contact_address')->first()->value;
		$this->config['addresses']	= json_decode($settings->where('property', 'contact_address')->first()->value);
		$this->config['facebook']	= $settings->where('property', 'social_facebook')->first()->value;
		$this->config['twitter']	= $settings->where('property', 'social_twitter')->first()->value;
		$this->config['instagram']	= $settings->where('property', 'social_instagram')->first()->value;
		$this->config['pinterest']	= $settings->where('property', 'social_pinterest')->first()->value;
		$this->config['googleplus']	= $settings->where('property', 'social_googleplus')->first()->value;
		$this->config['youtube']	= $settings->where('property', 'social_youtube')->first()->value;
		$this->config['line']		= $settings->where('property', 'social_line')->first()->value;
		$this->config['whatapp']	= $settings->where('property', 'social_whatapp')->first()->value;
		$this->config['wechat']		= $settings->where('property', 'social_wechat')->first()->value;
		$this->config['viber']		= $settings->where('property', 'social_viber')->first()->value;
		$this->config['url']		= $request->root();

		//langs
		$defaultLocale = \App\Config::where('property', 'default_locale')->first()->value;
		$this->config['langs']	= config('app.locales');
		$this->config['lang'] 	= $this->config['langs'][$defaultLocale];

		if ($this->auth->check()){
			$this->config['lang'] = $this->config['langs'][$this->user->locale];
		}
		else {
			if (\Cookie::has('lang'))
			{
				$lang = \Cookie::get('lang');
				if (isset($this->config['langs'][$lang]))
				{
					$this->config['lang'] = $this->config['langs'][$lang];
				}
			}
		}
		app()->setLocale($this->config['lang']['code']);

        //locales
        $this->locales = [];
        foreach($this->config['langs'] as $lang){
            $this->locales[] = $lang;
        }

		//params
		$this->params['config']	= $this->config;
		$this->params['auth']	= $this->auth;
		$this->params['user']	= $this->user;
        $this->params['locales']= $this->locales;
	}
}
