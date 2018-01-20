<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Tour;

class WorkingController extends Controller {

    public function getIndex(Request $request)
    {
        $working_hours  = Config::where('property', 'opening_hours')->first()->value;
        $map            = Config::where('property', 'map')->first()->value;
        $tours          = Tour::where('publish', '1')->orderByRaw("RAND()")->take(2)->get();

        $this->params['tours']         = $tours;
        $this->params['working_hours'] = $working_hours;
        $this->params['map']           = json_decode($map);
        $this->params['title']         = trans('_.Location & Opening hours').' - '.$this->config['name'];
        $this->params['menu']          = 'working';
        $this->params['submenu']       = 'working';

        return view('frontend.working.index', $this->params);
    }
}
