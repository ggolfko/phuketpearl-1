<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

class HowtoController extends Controller {

    public function getMap(Request $request)
    {
        $this->params['request'] = $request;

        return view('dashboard.howto.map', $this->params);
    }
}
