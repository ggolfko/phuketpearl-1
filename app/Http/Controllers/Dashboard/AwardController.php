<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Award;
use App\Translate;
use File;
use Image;

class AwardController extends Controller {

    public function postEdit(Request $request, $awardid)
    {
        $award = Award::where('awardid', $awardid)->first();

        if ($award)
        {
            $title      = $request->input('title');
            $imageid    = $request->input('imageid');
            $eMessage   = trans('error.procedure');

            if ($title && $imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16)
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if (!isset($title[$locale['code']])){
                        $valid = false;
                    }
                }

                if ($valid)
                {
                    $eMessage = trans('error.general');

                    if ($award->imageid != $imageid)
                    {
                        if (File::exists(public_path("app/award/temp/{$imageid}.png")))
                        {
                            $image = Image::make(public_path("app/award/temp/{$imageid}.png"));
                            $image->fit(250, 370);

                            if ($image->save(public_path("app/award/{$award->awardid}/{$imageid}_t.png"), 100))
                            {
                                $image->destroy();
                                $image  = \Image::make(public_path("app/award/temp/{$imageid}.png"));
                                if ($image->save(public_path("app/award/{$award->awardid}/{$imageid}.png"), 100))
                                {
                                    $image->destroy();
                                    $award->imageid = $imageid;
                                    $award->save();
                                }
                            }
                        }
                    }

                    File::cleanDirectory(public_path("app/award/temp"));

                    foreach ($this->locales as $locale){
                        $trans = $award->getTitle($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($title[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'award';
                            $trans->model_id    = $award->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();
                        }
                    }

                    return redirect('dashboard/docs/award')->with('sMessage', trans('_.Save changes successfully.'));
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $awardid)
    {
        $award = Award::where('awardid', $awardid)->first();

        if ($award)
        {
            $this->params['request']    = $request;
            $this->params['award']      = $award;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'award';

            return view('dashboard.docs.award.edit', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostDelete(Request $request, $awardid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $award = Award::find($id);

            if ($award && $award->awardid == $awardid)
            {
                $awardid = $award->awardid;

                if ($award->delete())
                {
                    if ($awardid != '')
                    {
                        if (File::isDirectory(public_path("app/award/{$awardid}"))){
                            File::deleteDirectory(public_path("app/award/{$awardid}"));
                        }
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postAdd(Request $request)
    {
        $title      = $request->input('title');
        $imageid    = $request->input('imageid');
        $eMessage   = trans('error.procedure');

        if ($title && $imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16)
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($title[$locale['code']])){
                    $valid = false;
                }
            }

            if ($valid && File::exists(public_path("app/award/temp/{$imageid}.png")))
            {
                $eMessage   = trans('error.general');
                $award      = new Award;

                if ($award->save())
                {
                    if (!File::isDirectory(public_path("app/award/{$award->awardid}"))){
                        File::makeDirectory(public_path("app/award/{$award->awardid}"));
                    }

                    $image = Image::make(public_path("app/award/temp/{$imageid}.png"));
                    $image->fit(250, 370);

                    if ($image->save(public_path("app/award/{$award->awardid}/{$imageid}_t.png"), 100))
                    {
                        $image->destroy();
                        $image = Image::make(public_path("app/award/temp/{$imageid}.png"));
                        if ($image->save(public_path("app/award/{$award->awardid}/{$imageid}.png"), 100))
                        {
                            $image->destroy();
                            File::cleanDirectory(public_path("app/award/temp"));

                            $award->imageid = $imageid;
                            $award->save();
                        }
                    }

                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'award';
                        $trans->model_id    = $award->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/docs/award')->with('sMessage', trans('_.Added a new item successfully.'));
                }
            }
        }
		
        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function ajaxPostImage(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        if ($request->hasFile('image'))
        {
            $response['message'] = trans('error.general');
            $file   = $request->file('image');
            $ext    = $file->getClientOriginalExtension();


            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id     = Award::createId();
                $image  = Image::make($file);

                if ($image->save(public_path("app/award/temp/{$id}.png"), 100))
                {
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['payload']['imageid'] = $id;
                }
            }
            else {
                $response['message'] = trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.');
            }
        }

        return response()->json($response);
    }

    public function getAdd(Request $request)
    {
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'award';

        return view('dashboard.docs.award.add', $this->params);
    }

    public function getIndex()
    {
        $items = Award::all();

        $this->params['items']      = $items;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'award';

        return view('dashboard.docs.award.index', $this->params);
    }
}
