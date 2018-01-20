<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Photo;
use App\News;
use App\Tour;
use App\Product;
use App\Category;
use App\Config;
use App\Slide;
use App\Award;
use App\Certificate;

class HomeController extends Controller {

	public function getIndex(Request $request)
	{
		$tours			= Tour::where('publish', '1')->orderBy('created_at', 'desc')->take(4)->with(['extras'])->get();
		$jewels			= Product::where('publish', '1')->orderByRaw("RAND()")->take(6)->get();
		$slides			= Slide::where('publish', '1')->where('imageid', '!=', '')->orderBy('sort', 'asc')->get();
		$collections_	= Category::where('imageid', '!=', '')->with(['products'])->get();
		$collections	= [];
		$awards = Award::all();
		$cers   = Certificate::all();


		foreach($collections_ as $collection_)
		{
			$has = false;

			foreach ($collection_->products as $product_)
			{
				if ($product_->product && $product_->product->publish == '1'){
					$has = true;
				}
			}

			if ($has)
			{
				$collections[] = $collection_;
			}
		}

		$jsonld = [
			'@context' => 'http://schema.org',
			'@type' => 'WebSite',
			'@id' => '#website',
			'url' => config('app.url'),
			'name' => $this->config['name'],
		];

		$this->params['request'] = $request;
		$this->params['jsonld']			= $jsonld;
		$this->params['slides']			= $slides;
		$this->params['cers']       = $cers;
		$this->params['awards']     = $awards;
		$this->params['tours']			= $tours;
		$this->params['jewels']			= $jewels;
		$this->params['collections']	= $collections;
		$this->params['menu']			= 'home';


		return view('frontend.home.index', $this->params);
	}
}
