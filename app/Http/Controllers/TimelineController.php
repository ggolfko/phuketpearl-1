<?php namespace App\Http\Controllers;

class TimelineController extends Controller {

    public function getIndex()
    {
        $this->params['title']      = trans('_.Timeline').' - '.$this->config['name'];
        $this->params['menu']       = 'company';
        $this->params['submenu']    = 'timeline';

        return view('frontend.company.timeline', $this->params);
    }
}
