<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Crown;
use App\PearlCare;
use App\PearlQuality;
use App\PearlType;
use App\PearlFarm;
use App\PearlFarmVideo;
use App\PearlFarming;
use App\Tour;

class PearlController extends Controller {

    public function getCrown(Request $request)
    {
        $items = Crown::all();

        $this->params['items']      = $items;
        $this->params['title']      = trans('_.Pearl Crowns').' - '.$this->config['name'];
        $this->params['menu']       = 'company';
        $this->params['submenu']    = 'pearlcrowns';

        return view('frontend.pearl.crown', $this->params);
    }

    public function getType(Request $request)
    {
        $items = [];
        PearlType::all()->each(function($item) use (&$items){
            $items[] = [
                'object'    => $item,
                'id'        => $item->id,
                'typeid'    => $item->typeid,
                'title'     => $item->getTitle($this->config['lang']['code']),
                'detail'    => $item->getDetail($this->config['lang']['code']),
				'main'		=> ($item->main == '1')
            ];
        });

		$tours = Tour::where('publish', '1')->orderByRaw("RAND()")->take(4)->get();
        $this->params['tours'] = $tours;

        $this->params['items']      = $items;
        $this->params['title']      = trans('_.Type of pearl').' - '.$this->config['name'];
        $this->params['menu']       = 'ourpearlfarm';
        $this->params['submenu']    = 'pearltype';

        return view('frontend.pearl.type', $this->params);
    }

    public function getFarming(Request $request)
    {
        $items = [];
        PearlFarming::all()->each(function($item) use (&$items){
            $items[] = [
                'object'    => $item,
                'id'        => $item->id,
                'farmingid' => $item->farmingid,
                'title'     => $item->getTitle($this->config['lang']['code']),
                'content'   => $item->getContent($this->config['lang']['code']),
            ];
        });

		$tours = Tour::where('publish', '1')->orderByRaw("RAND()")->take(4)->get();
        $this->params['tours'] = $tours;

        $this->params['items']      = $items;
        $this->params['title']      = trans('_.Pearl farming').' - '.$this->config['name'];
        $this->params['menu']       = 'ourpearlfarm';
        $this->params['submenu']    = 'pearlfarming';

        return view('frontend.pearl.farming', $this->params);
    }

    public function getFarm(Request $request, $id = '')
    {
        $items  = PearlFarm::orderBy('created_at', 'desc')->get();
        $tours  = Tour::where('publish', '1')->orderByRaw("RAND()")->take(4)->get();
        $videos = PearlFarmVideo::where('publish', '1')->orderBy('created_at', 'desc')->get();

        $this->params['id']     	= $id;
		$this->params['videos']     = $videos;
        $this->params['tours']      = $tours;
        $this->params['items']      = $items;
        $this->params['title']      = trans('_.Phuket Pearl’s pearl farm').' - '.$this->config['name'];
        $this->params['menu']       = 'ourpearlfarm';
        $this->params['submenu']    = 'pearlfarm';

        return view('frontend.pearl.farm', $this->params);
    }

    public function getQuality(Request $request)
    {
        $items = PearlQuality::all();

        $this->params['items']      = $items;
        $this->params['title']      = trans('_.Pearl Quality').' - '.$this->config['name'];
        $this->params['menu']       = 'pearlquality';
        $this->params['submenu']    = 'pearlquality';

        return view('frontend.pearl.quality', $this->params);
    }

    public function getCare(Request $request)
    {
        $item = PearlCare::first();

        $this->params['item']       = $item;
        $this->params['title']      = trans('_.Pearl Care').' - '.$this->config['name'];
        $this->params['menu']       = 'jewels';
        $this->params['submenu']    = 'pearlcare';

        return view('frontend.pearl.care', $this->params);
    }
}
