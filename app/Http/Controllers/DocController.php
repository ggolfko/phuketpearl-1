<?php namespace App\Http\Controllers;

use App\Doc;

class DocController extends Controller {

    public function getTourTerms()
    {
        $doc = Doc::where('name', 'tour_terms')->first();
        $this->params['doc'] = $doc;

        return view('frontend.docs.tour-terms', $this->params);
    }
}
