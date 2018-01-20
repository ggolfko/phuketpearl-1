<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Timeline;
use App\TimelineImage;
use App\Translate;

class TimelineController extends Controller {

    public function ajaxPostDelete(Request $request, $timelineid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $timeline = Timeline::find($id);
            if ($timeline && $timeline->timelineid == $timelineid)
            {
                $response['message'] = trans('error.general');

                $timeline->images()->each(function($item){
                    $item->delete();
                });

                $translates = Translate::where('model', 'timeline')
                    ->where('model_id', $timeline->id)
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($timeline->delete())
                {
                    if (\File::isDirectory(public_path("app/timeline/{$timelineid}"))){
                        \File::deleteDirectory(public_path("app/timeline/{$timelineid}"));
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postEdit(Request $request, $timelineid)
    {
        $timeline = Timeline::where('timelineid', $timelineid)->first();

        if ($timeline)
        {
            $year       = $request->input('year');
            $detail     = $request->input('detail');
            $eMessage   = trans('error.procedure');

            if ($year && $detail && preg_match("/^[0-9]+$/", $year))
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if (!isset($detail[$locale['code']])){
                        $valid = false;
                    }
                }

                if ($valid)
                {
                    $eMessage       = trans('error.general');
                    $timeline->time = $year.'-01-01';

                    if ($timeline->save())
                    {
                        foreach ($this->locales as $locale){
                            $trans = $timeline->getDetail($locale['code'], true);
                            if ($trans){
                                $trans->text = trim($detail[$locale['code']]);
                                $trans->save();
                            }
                            else {
                                $trans = new Translate;
                                $trans->model       = 'timeline';
                                $trans->model_id    = $timeline->id;
                                $trans->field       = 'detail';
                                $trans->locale      = $locale['code'];
                                $trans->text        = trim($detail[$locale['code']]);
                                $trans->save();
                            }
                        }

                        return redirect('dashboard/docs/timeline/'.$timeline->timelineid)->with('sMessage', trans('timeline.Save the changes successfully.'));
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $timelineid)
    {
        $timeline = Timeline::where('timelineid', $timelineid)->first();

        if ($timeline)
        {
            $this->params['timeline']	= $timeline;
            $this->params['request']	= $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'timeline';

            return view('dashboard.docs.timeline.edit', $this->params);
        }

        return abort(404);
    }

    public function getItem(Request $request, $timelineid)
    {
        $timeline = Timeline::where('timelineid', $timelineid)->first();

        if ($timeline)
        {
            $this->params['timeline']	= $timeline;
            $this->params['request']	= $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'timeline';

            return view('dashboard.docs.timeline.item', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostImageDelete(Request $request, $timelineid, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $timeline   = Timeline::where('timelineid', $timelineid)->first();
        $id         = $request->input('id');

        if ($timeline && $id)
        {
            $image = TimelineImage::find($id);

            if ($image && $image->imageid == $imageid && $timeline->id == $image->timeline_id)
            {
                if ($image->delete())
                {
                    $refresh = false;

                    \File::delete([
                        public_path("app/timeline/{$timeline->timelineid}/{$imageid}.png"),
                        public_path("app/timeline/{$timeline->timelineid}/{$imageid}_t.png")
                    ]);

                    if ($timeline->images->count() < 1){
                        $refresh = true;
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['payload']['refresh'] = $refresh;
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostImageUpload(Request $request, $timelineid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $timeline   = Timeline::where('timelineid', $timelineid)->first();

        if ($timeline)
        {
            $response['message'] = trans('error.general');
            if ($request->hasFile('image'))
            {
                $files  = $request->file('image');
                $valid  = true;

                foreach ($files as $file)
                {
                    $ext = $file->getClientOriginalExtension();
                    if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png'])){
                        $valid = false;
                    }
                }

                if ($valid)
                {
                    if (count($files) <= 10)
                    {
                        if (!\File::isDirectory(public_path("app/timeline/{$timeline->timelineid}"))){
							\File::makeDirectory(public_path("app/timeline/{$timeline->timelineid}"));
						}
                        $interrupt = false;

                        foreach ($files as $file)
                        {
                            $id     = TimelineImage::createId();
                            $image  = \Image::make($file);
                            if ($image->save(public_path("app/timeline/{$timeline->timelineid}/{$id}.png"), 100))
                            {
                                $image  = \Image::make(public_path("app/timeline/{$timeline->timelineid}/{$id}.png"));
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

                                if ($image->save(public_path("app/timeline/{$timeline->timelineid}/{$id}_t.png"), 100))
                                {
                                    $newImage = new TimelineImage;
                                    $newImage->imageid      = $id;
                                    $newImage->timeline_id  = $timeline->id;

                                    if (!$newImage->save()){
                                        $interrupt = true;
                                    }
                                }
                                else {
                                    $interrupt = true;
                                }
                            }
                            else {
                                $interrupt = true;
                            }
                        }

                        if (!$interrupt)
                        {
                            $response['status']     = 'ok';
                            $response['message']    = 'success';
                        }
                    }
                    else {
                        $response['message'] = trans('gallery.Upload images up to 10 files at a time.');
                    }
                }
                else {
                    $response['message'] = trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.');
                }
            }
        }

        return response()->json($response);
    }

    public function getImage(Request $request, $timelineid)
    {
        $timeline = Timeline::where('timelineid', $timelineid)->first();

        if ($timeline)
        {
            $this->params['timeline']	= $timeline;
            $this->params['request']	= $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'timeline';

            return view('dashboard.docs.timeline.image', $this->params);
        }

        return abort(404);
    }

    public function postAdd(Request $request)
    {
        $year       = $request->input('year');
        $detail     = $request->input('detail');
        $eMessage   = trans('error.procedure');

        if ($year && $detail && preg_match("/^[0-9]+$/", $year))
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($detail[$locale['code']])){
                    $valid = false;
                }
            }

            if ($valid)
            {
                $eMessage   = trans('error.general');
                $timeline   = new Timeline;
                $timeline->time = $year.'-01-01';

                if ($timeline->save())
                {
                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'timeline';
                        $trans->model_id    = $timeline->id;
                        $trans->field       = 'detail';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($detail[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/docs/timeline/'.$timeline->timelineid.'/images')->with('sMessage', trans('timeline.Added a new timeline successfully.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getAdd(Request $request)
    {
	    $this->params['request']	= $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'timeline';

        return view('dashboard.docs.timeline.add', $this->params);
    }

    public function getIndex(Request $request)
    {
        $items = Timeline::orderBy('time', 'desc')->orderBy('created_at', 'desc')->get();

        $this->params['items']      = $items;
	    $this->params['request']	= $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'timeline';

        return view('dashboard.docs.timeline.index', $this->params);
    }
}
