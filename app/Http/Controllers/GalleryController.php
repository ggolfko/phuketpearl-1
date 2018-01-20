<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\GalleryVideo;
use App\Tour;

class GalleryController extends Controller {

    public function getIndex(Request $request, $id = '')
    {
        $images	= Gallery::orderBy('created_at', 'desc')->get();
        $videos = GalleryVideo::where('publish', '1')->orderBy('created_at', 'desc')->get();

		$tours = Tour::where('publish', '1')->orderByRaw("RAND()")->take(4)->get();
        $this->params['tours'] = $tours;

		$this->params['id']			= $id;
		$this->params['request']	= $request;
        $this->params['videos']     = $videos;
        $this->params['images']     = $images;
        $this->params['title']      = trans('_.Gallery').' - '.$this->config['name'];
        $this->params['menu']       = 'company';
        $this->params['submenu']    = 'gallery';

        return view('frontend.gallery.index', $this->params);
    }
}
