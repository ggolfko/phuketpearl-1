<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Tour;
use App\MediaSpecialGuest;

class NewsController extends Controller {

	public function getMediaSpecialGuests(Request $request)
	{
		$medias = MediaSpecialGuest::orderBy('created_at', 'desc')->get();

        $this->params['medias']		= $medias;
		$this->params['menu']		= 'news';
		$this->params['submenu']	= 'media_special_guests';
        $this->params['title']		= trans('_.Media & Special Guests').' - '.$this->config['name'];

		return view('frontend.news.media-special-guests', $this->params);
	}

    public function getRead(Request $request, $newsid)
    {
        $news = News::where('newsid', $newsid)->first();

        if ($news && $news->publish == '1')
        {
            $randoms    = News::where('publish', '1')->where('id', '!=', $news->id)->orderByRaw("RAND()")->take(2)->get();
            $tours      = Tour::where('publish', '1')->orderByRaw("RAND()")->take(2)->get();

			$topic		= $news->getTopic($this->config['lang']['code']);

            $this->params['randoms']    = $randoms;
            $this->params['tours']      = $tours;
            $this->params['news']       = $news;
    		$this->params['menu']       = 'news';
            $this->params['title']      = $topic.' - '.$this->config['name'];
            $this->params['meta_description']   = $this->params['title'];

            $views = $request->cookie('VIEWED')? unserialize($request->cookie('VIEWED')): [];
            if (isset($views['news'])){
                if (!in_array($news->newsid, $views['news'])){
                    $views['news'][] = $news->newsid;

                    $news->views = $news->views+1;
                    $news->save();
                }
            }
            else {
                $views['news'] = [];
                $views['news'][] = $news->newsid;

                $news->views = $news->views+1;
                $news->save();
            }
            \Cookie::queue('VIEWED', serialize($views), 60*24*3);

			$og_tags = [
				'title' => $topic,
				'description' => str_limit(strip_tags($news->getContent($this->config['lang']['code'])), 150)
			];

			$countImage = $news->images->count();

			if ($countImage > 0){
				if ($countImage == 1){
					$image = $news->images->first();
					$og_tags['image'] = config('app.url') . "/app/news/{$news->newsid}/{$image->imageid}.png";
				}
				else {
					$og_tags['images'] = [];

					foreach ($news->images as $image){
						$og_tags['images'][] = config('app.url') . "/app/news/{$news->newsid}/{$image->imageid}.png";
					}
				}
			}

			$this->params['og_tags'] = $og_tags;

    		return view('frontend.news.read', $this->params);
        }

        return abort(404);
    }

	public function getIndex()
	{
        $news = News::where('publish', '1')->orderBy('created_at', 'desc')->paginate(14);

        $this->params['news']   	= $news;
		$this->params['menu']   	= 'news';
		$this->params['submenu']	= 'news';
        $this->params['title']		= trans('_.News').' - '.$this->config['name'];

		return view('frontend.news.index', $this->params);
	}
}
