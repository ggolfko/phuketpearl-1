<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $params	= [];
	public $config	= [];
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
		$this->config['viber']		= $settings->where('property', 'social_viber')->first()->value;
		$this->config['whatapp']	= $settings->where('property', 'social_whatapp')->first()->value;
		$this->config['wechat']		= $settings->where('property', 'social_wechat')->first()->value;
		$this->config['url']		= $request->root();
		$this->config['fullUrl']	= $request->fullUrl();
		$this->config['fb_appid']	= $settings->where('property', 'fb_appid')->first()->value;
		$this->config['fb_title']	= $settings->where('property', 'fb_title')->first()->value;
		$this->config['fb_image']	= $settings->where('property', 'fb_image')->first()->value;
		$this->config['fb_description']	= $settings->where('property', 'fb_description')->first()->value;
		$this->config['home_title']	= $settings->where('property', 'home_title')->first()->value;

		//langs
		$defaultLocale = \App\Config::where('property', 'default_locale')->first()->value;
		$this->config['langs']	= config('app.locales');
		$this->config['lang'] 	= $this->config['langs'][$defaultLocale];
		$override = false;

		//override
		if ($request->has('lang'))
		{
			$langCode = $request->input('lang');

			foreach ($this->config['langs'] as $lang){
				if ($langCode == $lang['code']){
					$override = true;
					$this->config['lang'] = $this->config['langs'][$lang['code']];
				}
			}
		}

		//not override
		if (!$override)
		{
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
		}

		app()->setLocale($this->config['lang']['code']);

		//phones
		$phones = json_decode($settings->where('property', 'contact_phone')->first()->value);

		if (isset($phones->{$this->config['lang']['code']})){
			$phone = $phones->{$this->config['lang']['code']};
		}
		else {
			$phone = [];
		}

		$this->config['phones'] = $phone;

		//params
		$this->params['config']	= $this->config;
		$this->params['auth']	= $this->auth;
		$this->params['user']	= $this->user;

		//top info
		$this->params['top_phone'] = '';
		if (count($this->config['phones']) > 0){
			$this->params['top_phone'] = $this->config['phones'][0];
		}

		$this->params['top_email'] = '';
		if (count($this->config['emails']) > 0){
			$this->params['top_email'] = $this->config['emails'][0];
		}

        //categories
        $this->params['categories'] = Category::all();
	}
}
