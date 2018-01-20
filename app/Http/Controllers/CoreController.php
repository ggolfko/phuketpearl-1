<?php namespace App\Http\Controllers;

use Robots;

class CoreController extends Controller {

	public function robots()
	{
		Robots::addUserAgent('*');
        Robots::addSitemap(config('app.url').'/sitemap.xml');
		Robots::addAllow('/app');
		Robots::addAllow('/photos');
		Robots::addAllow('/static');
		Robots::addDisallow('/dashboard');

		return response()->make(Robots::generate(), 200, ['Content-Type' => 'text/plain']);
	}
}
