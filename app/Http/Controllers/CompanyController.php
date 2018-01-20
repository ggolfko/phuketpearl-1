<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificate;
use App\Award;
use App\Timeline;
use App\Story;
use App\StoryImage;

class CompanyController extends Controller {

    public function getAwardCertificate(Request $request)
    {
        $cers   = Certificate::all();
        $awards = Award::all();

        $this->params['cers']       = $cers;
        $this->params['awards']     = $awards;
        $this->params['title']      = trans('_.Awards & Certificates').' - '.$this->config['name'];
        $this->params['menu']       = 'company';
        $this->params['submenu']    = 'awardscertificates';

        return view('frontend.company.award-certificate', $this->params);
    }

    public function getStory(Request $request)
    {
        $timelines  = Timeline::orderBy('time', 'asc')->get();
        $story      = Story::first();
        $images     = StoryImage::orderBy('created_at', 'desc')->get();

        $this->params['images']     = $images;
        $this->params['story']      = $story;
        $this->params['timelines']  = $timelines;
        $this->params['title']      = trans('_.Our story').' - '.$this->config['name'];
        $this->params['menu']       = 'company';
        $this->params['submenu']    = 'ourstory';

        return view('frontend.company.story', $this->params);
    }
}
