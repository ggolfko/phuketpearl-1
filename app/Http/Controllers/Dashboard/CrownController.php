<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Crown;
use App\Translate;

class CrownController extends Controller {

    public function ajaxPostDelete(Request $request, $crownid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $crown = Crown::find($id);

            if ($crown && $crown->crownid == $crownid)
            {
                $crownid = $crown->crownid;

                Translate::where('model', 'crown')
                    ->where('model_id', $crown->id)
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($crown->delete())
                {
                    if ($crownid != '')
                    {
                        if (\File::isDirectory(public_path("app/crown/{$crownid}"))){
                            \File::deleteDirectory(public_path("app/crown/{$crownid}"));
                        }
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postEdit(Request $request, $crownid)
    {
        $crown = Crown::where('crownid', $crownid)->first();

        if ($crown)
        {
            $title      = $request->input('title');
            $detail     = $request->input('detail');
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

                    if ($crown->imageid != $imageid)
                    {
                        if (\File::exists(public_path("app/crown/temp/{$imageid}.png")))
                        {
                            $image  = \Image::make(public_path("app/crown/temp/{$imageid}.png"));
                            $width	= $image->width();
                            $height	= $image->height();

                            if ($height > $width){
                                $image->resize(622, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                                if ($image->height() < 415){
                                    $image->resize(null, 415, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                            }
                            else if ($height == $width)
                            {
                                $image->resize(622, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                            else
                            {
                                $image->resize(null, 415, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                                if ($image->width() < 622){
                                    $image->resize(622, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                            }

                            $image->crop(622, 415, 0, 0);

                            if ($image->save(public_path("app/crown/{$crown->crownid}/{$imageid}_t.png"), 100))
                            {
                                $image->destroy();
                                $image  = \Image::make(public_path("app/crown/temp/{$imageid}.png"));
                                $width	= $image->width();
                                $height	= $image->height();

                                if ($width >= $height)
                                {
                                    if ($width > 622){
                                        $image->resize(622, null, function ($constraint) {
                                            $constraint->aspectRatio();
                                        });
                                    }
                                }
                                else
                                {
                                    if ($height > 415){
                                        $image->resize(null, 415, function ($constraint) {
                                            $constraint->aspectRatio();
                                        });
                                    }
                                }

                                if ($image->save(public_path("app/crown/{$crown->crownid}/{$imageid}_m.png"), 100))
                                {
                                    $image->destroy();
                                    $image  = \Image::make(public_path("app/crown/temp/{$imageid}.png"));

                                    if ($image->save(public_path("app/crown/{$crown->crownid}/{$imageid}.png"), 100))
                                    {
                                        $image->destroy();
                                        $crown->imageid = $imageid;
                                        $crown->save();
                                    }
                                }
                            }
                        }
                    }

                    \File::cleanDirectory(public_path("app/crown/temp"));

                    foreach ($this->locales as $locale){
                        $trans = $crown->getTitle($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($title[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'crown';
                            $trans->model_id    = $crown->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();
                        }

                        $trans = $crown->getDetail($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($detail[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'crown';
                            $trans->model_id    = $crown->id;
                            $trans->field       = 'detail';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($detail[$locale['code']]);
                            $trans->save();
                        }
                    }

                    return redirect('dashboard/docs/crown')->with('sMessage', trans('_.Save changes successfully.'));
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $crownid)
    {
        $crown = Crown::where('crownid', $crownid)->first();

        if ($crown)
        {
            $this->params['request']    = $request;
            $this->params['crown']      = $crown;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'crown';

            return view('dashboard.docs.crown.edit', $this->params);
        }

        return abort(404);
    }

    public function postAdd(Request $request)
    {
        $title      = $request->input('title');
        $detail     = $request->input('detail');
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
                $eMessage   = trans('error.general');
                $crown      = new Crown;

                if ($crown->save())
                {
                    if (!\File::isDirectory(public_path("app/crown/{$crown->crownid}"))){
                        \File::makeDirectory(public_path("app/crown/{$crown->crownid}"));
                    }

                    if (\File::exists(public_path("app/crown/temp/{$imageid}.png")))
                    {
                        $image  = \Image::make(public_path("app/crown/temp/{$imageid}.png"));
                        $width	= $image->width();
                        $height	= $image->height();

                        if ($height > $width){
                            $image->resize(622, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            if ($image->height() < 415){
                                $image->resize(null, 415, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                        }
                        else if ($height == $width)
                        {
                            $image->resize(622, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                        else
                        {
                            $image->resize(null, 415, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            if ($image->width() < 622){
                                $image->resize(622, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                        }

                        $image->crop(622, 415, 0, 0);

                        if ($image->save(public_path("app/crown/{$crown->crownid}/{$imageid}_t.png"), 100))
                        {
                            $image->destroy();
                            $image  = \Image::make(public_path("app/crown/temp/{$imageid}.png"));
                            $width	= $image->width();
                            $height	= $image->height();

                            if ($width >= $height)
                            {
                                if ($width > 622){
                                    $image->resize(622, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                            }
                            else
                            {
                                if ($height > 415){
                                    $image->resize(null, 415, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                            }

                            if ($image->save(public_path("app/crown/{$crown->crownid}/{$imageid}_m.png"), 100))
                            {
                                $image->destroy();
                                $image  = \Image::make(public_path("app/crown/temp/{$imageid}.png"));

                                if ($image->save(public_path("app/crown/{$crown->crownid}/{$imageid}.png"), 100))
                                {
                                    $image->destroy();
                                    \File::cleanDirectory(public_path("app/crown/temp"));

                                    $crown->imageid = $imageid;
                                    $crown->save();
                                }
                            }
                        }
                    }

                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'crown';
                        $trans->model_id    = $crown->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();

                        $trans = new Translate;
                        $trans->model       = 'crown';
                        $trans->model_id    = $crown->id;
                        $trans->field       = 'detail';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($detail[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/docs/crown')->with('sMessage', trans('crown.Added a new item successfully.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function ajaxPostImageUpload(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        if ($request->hasFile('image'))
        {
            $response['message'] = trans('error.general');
			
            $file   = $request->file('image');
            $ext    = $file->getClientOriginalExtension();


            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id     = Crown::createId();
                $image  = \Image::make($file);

                if ($image->save(public_path("app/crown/temp/{$id}.png"), 100))
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
        $this->params['submenu']    = 'crown';

        return view('dashboard.docs.crown.add', $this->params);
    }

    public function getIndex()
    {
        $items = Crown::all();

        $this->params['items']      = $items;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'crown';

        return view('dashboard.docs.crown.index', $this->params);
    }
}
