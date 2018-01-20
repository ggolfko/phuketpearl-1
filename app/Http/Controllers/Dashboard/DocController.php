<?php namespace App\Http\Controllers\Dashboard;

class DocController extends Controller {

    public function getIndex()
    {
        return redirect('dashboard?home');
    }
}
