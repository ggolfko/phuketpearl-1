<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Certificate;
use App\Translate;
use File;
use Image;

class CertificateController extends Controller {

    public function postEdit(Request $request, $certificateid)
    {
        $certificate = Certificate::where('certificateid', $certificateid)->first();

        if ($certificate)
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

                    if ($certificate->imageid != $imageid)
                    {
                        if (File::exists(public_path("app/certificate/temp/{$imageid}.png")))
                        {
                            $image = Image::make(public_path("app/certificate/temp/{$imageid}.png"));
                            $image->fit(600, 800);

                            if ($image->save(public_path("app/certificate/{$certificate->certificateid}/{$imageid}_t.png"), 100))
                            {
                                $image->destroy();
                                $image  = Image::make(public_path("app/certificate/temp/{$imageid}.png"));
                                if ($image->save(public_path("app/certificate/{$certificate->certificateid}/{$imageid}.png"), 100))
                                {
                                    $image->destroy();
                                    $certificate->imageid = $imageid;
                                    $certificate->save();
                                }
                            }
                        }
                    }

                    File::cleanDirectory(public_path("app/certificate/temp"));

                    foreach ($this->locales as $locale){
                        $trans = $certificate->getTitle($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($title[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'certificate';
                            $trans->model_id    = $certificate->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();
                        }
                    }

                    return redirect('dashboard/docs/certificate')->with('sMessage', trans('_.Save changes successfully.'));
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $certificateid)
    {
        $certificate = Certificate::where('certificateid', $certificateid)->first();

        if ($certificate)
        {
            $this->params['request']    = $request;
            $this->params['certificate']= $certificate;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'certificate';

            return view('dashboard.docs.certificate.edit', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostDelete(Request $request, $certificateid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $certificate = Certificate::find($id);

            if ($certificate && $certificate->certificateid == $certificateid)
            {
                $certificateid = $certificate->certificateid;

                if ($certificate->delete())
                {
                    if ($certificateid != '')
                    {
                        if (File::isDirectory(public_path("app/certificate/{$certificateid}"))){
                            File::deleteDirectory(public_path("app/certificate/{$certificateid}"));
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

            if ($valid && File::exists(public_path("app/certificate/temp/{$imageid}.png")))
            {
                $eMessage = trans('error.general');
                $certificate = new Certificate;

                if ($certificate->save())
                {
                    if (!File::isDirectory(public_path("app/certificate/{$certificate->certificateid}"))){
                        File::makeDirectory(public_path("app/certificate/{$certificate->certificateid}"));
                    }

                    $image = Image::make(public_path("app/certificate/temp/{$imageid}.png"));
                    $image->fit(600, 800);

                    if ($image->save(public_path("app/certificate/{$certificate->certificateid}/{$imageid}_t.png"), 100))
                    {
                        $image->destroy();
                        $image = Image::make(public_path("app/certificate/temp/{$imageid}.png"));
                        if ($image->save(public_path("app/certificate/{$certificate->certificateid}/{$imageid}.png"), 100))
                        {
                            $image->destroy();
                            File::cleanDirectory(public_path("app/certificate/temp"));

                            $certificate->imageid = $imageid;
                            $certificate->save();
                        }
                    }

                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'certificate';
                        $trans->model_id    = $certificate->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/docs/certificate')->with('sMessage', trans('_.Added a new item successfully.'));
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
                $id     = Certificate::createId();
                $image  = Image::make($file);

                if ($image->save(public_path("app/certificate/temp/{$id}.png"), 100))
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
        $this->params['submenu']    = 'certificate';

        return view('dashboard.docs.certificate.add', $this->params);
    }

    public function getIndex()
    {
        $items = Certificate::all();

        $this->params['items']      = $items;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'certificate';

        return view('dashboard.docs.certificate.index', $this->params);
    }
}
