<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\PearlCare;
use App\PearlQuality;
use App\PearlType;
use App\PearlTypeImage;
use App\PearlFarm;
use App\PearlFarmVideo;
use App\PearlFarming;
use App\PearlFarmingSlide;
use App\Translate;
use File;
use Image;

class PearlController extends Controller {

	public function postQualityEdit(Request $request, $itemid)
    {
		$item = PearlQuality::where('itemid', $itemid)->first();

		if ($item)
		{
			$title		= $request->input('title');
			$details	= $request->input('details');
	        $imageid    = $request->input('imageid');
	        $eMessage   = trans('error.procedure');

			if ($title && $details && $imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16)
	        {
				$valid = true;
	            foreach ($this->locales as $locale){
	                if (!isset($title[$locale['code']])){
	                    $valid = false;
	                }
					if (!isset($details[$locale['code']])){
	                    $valid = false;
	                }
	            }

				if ($valid && File::exists(public_path("app/pearlquality/{$imageid}.png")))
	            {
					$eMessage = trans('error.general');
					$item->imageid = $imageid;

					if ($item->save())
					{
						foreach ($this->locales as $locale)
						{
	                        $trans = $item->getTitle($locale['code'], true);
	                        if ($trans){
	                            $trans->text = trim($title[$locale['code']]);
	                            $trans->save();
	                        }
	                        else {
	                            $trans = new Translate;
	                            $trans->model       = 'pearlquality';
	                            $trans->model_id    = $item->id;
	                            $trans->field       = 'title';
	                            $trans->locale      = $locale['code'];
	                            $trans->text        = trim($title[$locale['code']]);
	                            $trans->save();
	                        }

							$trans = $item->getDetails($locale['code'], true);
	                        if ($trans){
	                            $trans->text = trim($details[$locale['code']]);
	                            $trans->save();
	                        }
	                        else {
	                            $trans = new Translate;
	                            $trans->model       = 'pearlquality';
	                            $trans->model_id    = $item->id;
	                            $trans->field       = 'details';
	                            $trans->locale      = $locale['code'];
	                            $trans->text        = trim($details[$locale['code']]);
	                            $trans->save();
	                        }
	                    }

						return redirect('dashboard/docs/pearlquality/' . $item->itemid)->with('sMessage', trans('_.Save changes successfully.'));
					}
				}
			}

			return redirect()->back()->with('eMessage', $eMessage);
		}

        return abort(404);
    }

	public function getQualityItem(Request $request, $itemid)
    {
		$item = PearlQuality::where('itemid', $itemid)->first();

		if ($item)
		{
			$this->params['item']    	=  $item;
			$this->params['request']    = $request;
	        $this->params['menu']       = 'doc';
	        $this->params['submenu']    = 'pearlquality';

	        return view('dashboard.docs.pearl.quality.item', $this->params);
		}

        return abort(404);
    }

	public function getQualityEdit(Request $request, $itemid)
    {
		$item = PearlQuality::where('itemid', $itemid)->first();

		if ($item)
		{
			$this->params['item']    	=  $item;
			$this->params['request']    = $request;
	        $this->params['menu']       = 'doc';
	        $this->params['submenu']    = 'pearlquality';

	        return view('dashboard.docs.pearl.quality.edit', $this->params);
		}

        return abort(404);
    }

	public function postQualityAdd(Request $request)
    {
        $title		= $request->input('title');
		$details	= $request->input('details');
        $imageid    = $request->input('imageid');
        $eMessage   = trans('error.procedure');

		if ($title && $details && $imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16)
        {
			$valid = true;
            foreach ($this->locales as $locale){
				if (!isset($title[$locale['code']])){
                    $valid = false;
                }
                if (!isset($details[$locale['code']])){
                    $valid = false;
                }
            }

			if ($valid && File::exists(public_path("app/pearlquality/{$imageid}.png")))
            {
				$eMessage = trans('error.general');
				$item = new PearlQuality;
				$item->imageid = $imageid;

				if ($item->save())
				{
					foreach ($this->locales as $locale)
					{
                        $trans = new Translate;
                        $trans->model       = 'pearlquality';
                        $trans->model_id    = $item->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();

						$trans = new Translate;
                        $trans->model       = 'pearlquality';
                        $trans->model_id    = $item->id;
                        $trans->field       = 'details';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($details[$locale['code']]);
                        $trans->save();
                    }

					return redirect('dashboard/docs/pearlquality')->with('sMessage', trans('_.Added a new item successfully.'));
				}
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
    }

	public function ajaxPostQualityImage(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        if ($request->hasFile('image'))
        {
            $file   = $request->file('image');
            $ext    = $file->getClientOriginalExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id = PearlQuality::createImageId();

                if ($file->move(public_path("app/pearlquality"), "{$id}.png"))
                {
                    $response['status']     = 'ok';
					$response['message']    = 'success';
					$response['payload']['imageid'] = $id;
                }
            }
        }

        return response()->json($response);
    }

	public function getQualityAdd(Request $request)
    {
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlquality';

        return view('dashboard.docs.pearl.quality.add', $this->params);
    }

    public function ajaxPostFarmVideoDelete(Request $request, $videoid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $video = PearlFarmVideo::find($id);
            if ($video && $video->videoid == $videoid)
            {
                $response['message'] = trans('error.general');

                $videoid = $video->videoid;

                $translates = Translate::where('model', 'pearlfarm_video')
                    ->where('model_id', $video->id)
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($video->delete() && $videoid != '')
                {
                    \File::deleteDirectory(public_path("app/pearlfarm_videos/{$videoid}"));

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postFarmVideoEdit(Request $request, $videoid)
    {
        $video = PearlFarmVideo::where('videoid', $videoid)->first();

        if ($video)
        {
            $title      = $request->input('title');
            $youtube    = $request->input('youtube');
            $publish    = $request->input('publish');
            $eMessage   = trans('error.procedure');

            if (
                $title && $youtube && $publish && in_array($publish, ['yes', 'no']) &&
                preg_match("/((http\:\/\/){0,}(www\.){0,}(youtube\.com){1} || (youtu\.be){1}(\/watch\?v\=[^\s]){1})/", $youtube) == 1
            )
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if (!isset($title[$locale['code']])){
                        $valid = false;
                    }
                }
                $ytid = getYoutubeId($youtube);

                if ($valid && $ytid)
                {
                    $eMessage   = trans('error.general');
                    $preview    = false;
                    $thumb      = [
                        'default'   => $video->thumb_default,
                        'medium'    => $video->thumb_medium,
                        'high'      => $video->thumb_high,
                        'standard'  => $video->thumb_standard,
                        'maxres'    => $video->thumb_maxres
                    ];

                    if ($ytid != getYoutubeId($video->youtube))
                    {
                        $yt = \Youtube::getVideoInfo($ytid);

                        if (!\File::isDirectory(public_path("app/pearlfarm_videos/{$video->videoid}"))){
                            \File::makeDirectory(public_path("app/pearlfarm_videos/{$video->videoid}"));
                        }
                        else {
                            \File::cleanDirectory(public_path("app/pearlfarm_videos/{$video->videoid}"));
                        }

                        if ($yt && isset($yt->snippet) && isset($yt->snippet->thumbnails))
                        {
                            if (isset($yt->snippet->thumbnails->maxres)){
                                $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/maxres.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['maxres'] = true;

                                    $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                                    if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/preview_temp.png"), 100)){
                                        $image->destroy();
                                        $preview = true;
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->medium)){
                                $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/medium.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['medium'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                        if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->standard)){
                                $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/standard.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['standard'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                        if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->high)){
                                $image = \Image::make($yt->snippet->thumbnails->high->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/high.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['high'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->high->url);
                                        if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->default)){
                                $image = \Image::make($yt->snippet->thumbnails->default->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/default.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['default'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->default->url);
                                        if ($image->save(public_path("app/pearlfarm_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }
                        }

                        if ($preview)
                        {
                            $image  = \Image::make(public_path("app/pearlfarm_videos/{$video->videoid}/preview_temp.png"));
                            $width	= $image->width();
                            $height	= $image->height();

                            if ($height >= $width){
                                $image->resize(622, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                            else {
                                $image->resize(null, 415, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }

                            $image->crop(622, 415, 0, 0);
                            $image->save(public_path("app/pearlfarm_videos/{$video->videoid}/preview.png"), 100);
                            $image->destroy();
                            \File::delete(public_path("app/pearlfarm_videos/{$video->videoid}/preview_temp.png"));
                        }
                    }

                    $video->youtube = $youtube;
                    $video->thumb_default   = $thumb['default'];
                    $video->thumb_medium    = $thumb['medium'];
                    $video->thumb_high      = $thumb['high'];
                    $video->thumb_standard  = $thumb['standard'];
                    $video->thumb_maxres    = $thumb['maxres'];
                    $video->publish = $publish == 'yes'? true: false;

                    if ($video->save())
                    {
                        foreach ($this->locales as $locale){
                            $trans = $video->getTitle($locale['code'], true);

                            if ($trans){
                                $trans->text = trim($title[$locale['code']]);
                                $trans->save();
                            }
                            else {
                                $trans = new Translate;
                                $trans->model       = 'pearlfarm_video';
                                $trans->model_id    = $video->id;
                                $trans->field       = 'title';
                                $trans->locale      = $locale['code'];
                                $trans->text        = trim($title[$locale['code']]);
                                $trans->save();
                            }
                        }

                        return redirect('dashboard/docs/pearlfarm/videos')->with('sMessage', trans('video.Save changes to video information successfully.'));
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getFarmVideoEdit(Request $request, $videoid)
    {
        $video = PearlFarmVideo::where('videoid', $videoid)->first();

        if ($video)
        {
            $this->params['video']      = $video;
            $this->params['request']	= $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearlfarm';

            return view('dashboard.docs.pearl.farm.video.edit', $this->params);
        }

        return abort(404);
    }

    public function postFarmVideoAdd(Request $request)
    {
        $title      = $request->input('title');
        $youtube    = $request->input('youtube');
        $publish    = $request->input('publish');
        $eMessage   = trans('error.procedure');

        if (
            $title && $youtube && $publish && in_array($publish, ['yes', 'no']) &&
            preg_match("/((http\:\/\/){0,}(www\.){0,}(youtube\.com){1} || (youtu\.be){1}(\/watch\?v\=[^\s]){1})/", $youtube) == 1
        )
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($title[$locale['code']])){
                    $valid = false;
                }
            }
            $ytid = getYoutubeId($youtube);

            if ($valid && $ytid)
            {
                $eMessage   = trans('error.general');
                $videoid    = PearlFarmVideo::createId();
                $yt         = \Youtube::getVideoInfo($ytid);
                $preview    = false;
                $thumb      = [
                    'default'   => false,
                    'medium'    => false,
                    'high'      => false,
                    'standard'  => false,
                    'maxres'    => false
                ];

                if (!\File::isDirectory(public_path("app/pearlfarm_videos/{$videoid}"))){
                    \File::makeDirectory(public_path("app/pearlfarm_videos/{$videoid}"));
                }

                if ($yt && isset($yt->snippet) && isset($yt->snippet->thumbnails))
                {
                    if (isset($yt->snippet->thumbnails->maxres)){
                        $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                        if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/maxres.jpg"), 100)){
                            $image->destroy();
                            $thumb['maxres'] = true;

                            $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                            if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/preview_temp.png"), 100)){
                                $image->destroy();
                                $preview = true;
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->medium)){
                        $image = \Image::make($yt->snippet->thumbnails->medium->url);
                        if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/medium.jpg"), 100)){
                            $image->destroy();
                            $thumb['medium'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->standard)){
                        $image = \Image::make($yt->snippet->thumbnails->standard->url);
                        if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/standard.jpg"), 100)){
                            $image->destroy();
                            $thumb['standard'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->high)){
                        $image = \Image::make($yt->snippet->thumbnails->high->url);
                        if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/high.jpg"), 100)){
                            $image->destroy();
                            $thumb['high'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->high->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->default)){
                        $image = \Image::make($yt->snippet->thumbnails->default->url);
                        if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/default.jpg"), 100)){
                            $image->destroy();
                            $thumb['default'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->default->url);
                                if ($image->save(public_path("app/pearlfarm_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }
                }

                if ($preview)
                {
                    $image  = \Image::make(public_path("app/pearlfarm_videos/{$videoid}/preview_temp.png"));
                    $width	= $image->width();
                    $height	= $image->height();

                    if ($height >= $width){
                        $image->resize(622, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    else {
                        $image->resize(null, 415, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                    $image->crop(622, 415, 0, 0);
                    $image->save(public_path("app/pearlfarm_videos/{$videoid}/preview.png"), 100);
                    $image->destroy();
                    \File::delete(public_path("app/pearlfarm_videos/{$videoid}/preview_temp.png"));
                }

                $video = new PearlFarmVideo;
                $video->videoid = $videoid;
                $video->youtube = $youtube;
                $video->thumb_default   = $thumb['default'];
                $video->thumb_medium    = $thumb['medium'];
                $video->thumb_high      = $thumb['high'];
                $video->thumb_standard  = $thumb['standard'];
                $video->thumb_maxres    = $thumb['maxres'];
                $video->publish = $publish == 'yes'? true: false;

                if ($video->save())
                {
                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'pearlfarm_video';
                        $trans->model_id    = $video->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/docs/pearlfarm/videos')->with('sMessage', trans('video.Added a new video successfully.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getFarmVideoAdd(Request $request)
    {
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlfarm';

        return view('dashboard.docs.pearl.farm.video.add', $this->params);
    }

    public function getFarmVideo(Request $request)
    {
        $items = PearlFarmVideo::orderBy('created_at', 'desc')->get();

        $this->params['items']		= $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlfarm';

        return view('dashboard.docs.pearl.farm.video.index', $this->params);
    }

    public function ajaxPostFarmingDelete(Request $request, $farmingid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $farming = PearlFarming::find($id);

            if ($farming && $farming->farmingid == $farmingid)
            {
                $translates = Translate::where('model', 'pearlfarming')
                    ->where('model_id', $farming->id)
					->where('field', 'title')
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

				$translates = Translate::where('model', 'pearlfarming')
                    ->where('model_id', $farming->id)
					->where('field', 'content')
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($farming->delete() && $farmingid != ''){
					$farming->slides->each(function($slide){
						$translates = Translate::where('model', 'pearlfarming')
		                    ->where('model_id', $slide->id)
							->where('field', 'description')
		                    ->get()
		                    ->each(function($item){
		                        $item->delete();
		                    });

						$slide->delete();
					});

                    if (File::exists(public_path("app/pearlfarming/{$farmingid}"))){
                        File::deleteDirectory(public_path("app/pearlfarming/{$farmingid}"));
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

	public function ajaxPostFarmingImageTemp(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        if ($request->hasFile('image'))
        {
            $response['message'] = trans('error.general');
            $file   = $request->file('image');
            $ext    = $file->getClientOriginalExtension();


            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id     = PearlFarmingSlide::createImageId();
                $image  = Image::make($file);

                if ($image->save(public_path("app/pearlfarming/temp/{$id}.png"), 100))
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

    public function ajaxPostFarmingImage(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $farmingid  = $request->input('farmingid');

        if ($farmingid && $request->hasFile('file'))
        {
            if (!File::isDirectory(public_path("app/pearlfarming/{$farmingid}"))){
                File::makeDirectory(public_path("app/pearlfarming/{$farmingid}"));
            }

            $file   = $request->file('file');
            $ext    = $file->getClientOriginalExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id     = PearlFarmingSlide::createId();
                $image  = \Image::make($file);
                if ($image->save(public_path("app/pearlfarming/{$farmingid}/{$id}.png"), 100))
                {
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['link']       = "/app/pearlfarming/{$farmingid}/{$id}.png";
                }
            }
        }

        return response()->json($response);
    }

    public function postFarmingEdit(Request $request, $farmingid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
            $title      = $request->input('title');
            $content    = $request->input('content');
            $eMessage   = trans('error.procedure');

            if ($title && $content)
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if (!isset($title[$locale['code']]) || !isset($content[$locale['code']])){
                        $valid = false;
                    }
                }

                if ($valid)
                {
                    $eMessage = trans('error.general');

                    foreach ($this->locales as $locale){
                        $trans = $farming->getTitle($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($title[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'pearlfarming';
                            $trans->model_id    = $farming->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();
                        }

                        $trans = $farming->getContent($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($content[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'pearlfarming';
                            $trans->model_id    = $farming->id;
                            $trans->field       = 'content';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($content[$locale['code']]);
                            $trans->save();
                        }
                    }

                    return redirect('dashboard/docs/pearlfarming/'.$farming->farmingid)->with('sMessage', trans('_.Save changes successfully.'));
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getFarmingEdit(Request $request, $farmingid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
            $this->params['farming']    = $farming;
            $this->params['request']    = $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearlfarming';

            return view('dashboard.docs.pearl.farming.edit', $this->params);
        }

        return abort(404);
    }

	public function postFarmingSlideAdd(Request $request, $farmingid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
			$description	= $request->input('description');
			$imageid    	= $request->input('imageid');
	        $eMessage   	= trans('error.procedure');

			if ($description && $imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16)
	        {
				$valid = true;
	            foreach ($this->locales as $locale){
	                if (!isset($description[$locale['code']])){
	                    $valid = false;
	                }
	            }

				if ($valid && File::exists(public_path("app/pearlfarming/temp/{$imageid}.png")))
	            {
					$eMessage = trans('error.general');

					$slide = new PearlFarmingSlide;
					$slide->pearl_farming_id = $farming->id;

					if ($slide->save())
					{
						$width	= 0;
						$height	= 0;

						if (!File::isDirectory(public_path("app/pearlfarming/{$farmingid}"))){
			                File::makeDirectory(public_path("app/pearlfarming/{$farmingid}"));
			            }

						$image = Image::make(public_path("app/pearlfarming/temp/{$imageid}.png"));
						$image->fit(375, 250);

						if ($image->save(public_path("app/pearlfarming/{$farmingid}/{$imageid}_t.png"), 100))
						{
							$image->destroy();
							$image = Image::make(public_path("app/pearlfarming/temp/{$imageid}.png"));
							$image->resize(null, 250, function ($constraint) {
								$constraint->aspectRatio();
							});
							$width	= $image->width();
							$height	= $image->height();

							if ($image->save(public_path("app/pearlfarming/{$farmingid}/{$imageid}_s.png"), 100))
							{
								$image->destroy();
								$image = Image::make(public_path("app/pearlfarming/temp/{$imageid}.png"));

								if ($image->save(public_path("app/pearlfarming/{$farmingid}/{$imageid}.png"), 100))
								{
									$image->destroy();
		                            File::cleanDirectory(public_path("app/pearlfarming/temp"));

		                            $slide->imageid = $imageid;
									$slide->width	= $width;
									$slide->height	= $height;
		                            $slide->save();
								}
							}
						}

						foreach ($this->locales as $locale){
	                        $trans = new Translate;
	                        $trans->model       = 'pearlfarming';
	                        $trans->model_id    = $slide->id;
	                        $trans->field       = 'description';
	                        $trans->locale      = $locale['code'];
	                        $trans->text        = trim($description[$locale['code']]);
	                        $trans->save();
	                    }

						return redirect('dashboard/docs/pearlfarming/' . $farming->farmingid . '/slides')->with('sMessage', trans('_.Added a new item successfully.'));
					}
				}
	        }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

	public function ajaxPostFarmingSlideDelete(Request $request, $farmingid, $slideid)
	{
		$response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$farming	= PearlFarming::where('farmingid', $farmingid)->first();

		if ($farming)
        {
			$slide = $farming->slides()->where('slideid', $slideid)->first();

			if ($slide)
			{
				$response['message'] = trans('error.general');

				$imageid = $slide->imageid;

				$translates = Translate::where('model', 'pearlfarming')
                    ->where('model_id', $slide->id)
					->where('field', 'description')
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

				if ($slide->delete())
				{
					if (File::exists(public_path("app/pearlfarming/{$farming->farmingid}/{$imageid}.png"))){
						File::delete(public_path("app/pearlfarming/{$farming->farmingid}/{$imageid}.png"));
					}
					if (File::exists(public_path("app/pearlfarming/{$farming->farmingid}/{$imageid}_t.png"))){
						File::delete(public_path("app/pearlfarming/{$farming->farmingid}/{$imageid}_t.png"));
					}
					if (File::exists(public_path("app/pearlfarming/{$farming->farmingid}/{$imageid}_s.png"))){
						File::delete(public_path("app/pearlfarming/{$farming->farmingid}/{$imageid}_s.png"));
					}

					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
		}

        return response()->json($response);
	}

	public function postFarmingSlideEdit(Request $request, $farmingid, $slideid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
			$slide = $farming->slides()->where('slideid', $slideid)->first();

			if ($slide)
			{
				$description	= $request->input('description');
				$imageid    	= $request->input('imageid');
		        $eMessage   	= trans('error.procedure');

				if ($description && $imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16)
		        {
					$valid = true;
		            foreach ($this->locales as $locale){
		                if (!isset($description[$locale['code']])){
		                    $valid = false;
		                }
		            }

					if ($valid)
		            {
						$eMessage = trans('error.general');

						if ($slide->imageid != $imageid)
						{
							if (File::exists(public_path("app/pearlfarming/temp/{$imageid}.png")))
							{
								$width	= 0;
								$height	= 0;

								if (!File::isDirectory(public_path("app/pearlfarming/{$farmingid}"))){
					                File::makeDirectory(public_path("app/pearlfarming/{$farmingid}"));
					            }

								$image = Image::make(public_path("app/pearlfarming/temp/{$imageid}.png"));
								$image->fit(375, 250);

								if ($image->save(public_path("app/pearlfarming/{$farmingid}/{$imageid}_t.png"), 100))
								{
									$image->destroy();
									$image = Image::make(public_path("app/pearlfarming/temp/{$imageid}.png"));
									$image->resize(null, 250, function ($constraint) {
										$constraint->aspectRatio();
									});
									$width	= $image->width();
									$height	= $image->height();

									if ($image->save(public_path("app/pearlfarming/{$farmingid}/{$imageid}_s.png"), 100))
									{
										$image->destroy();
										$image = Image::make(public_path("app/pearlfarming/temp/{$imageid}.png"));

										if ($image->save(public_path("app/pearlfarming/{$farmingid}/{$imageid}.png"), 100))
										{
											$image->destroy();
				                            $slide->imageid = $imageid;
											$slide->width	= $width;
											$slide->height	= $height;
				                            $slide->save();
										}
									}
								}
							}
						}

						File::cleanDirectory(public_path("app/pearlfarming/temp"));

	                    foreach ($this->locales as $locale){
	                        $trans = $slide->getDescription($locale['code'], true);
	                        if ($trans){
	                            $trans->text = trim($description[$locale['code']]);
	                            $trans->save();
	                        }
	                        else {
	                            $trans = new Translate;
	                            $trans->model       = 'pearlfarming';
	                            $trans->model_id    = $slide->id;
	                            $trans->field       = 'description';
	                            $trans->locale      = $locale['code'];
	                            $trans->text        = trim($description[$locale['code']]);
	                            $trans->save();
	                        }
	                    }

	                    return redirect('dashboard/docs/pearlfarming/' . $farming->farmingid . '/slides')->with('sMessage', trans('_.Save changes successfully.'));
					}
		        }

	            return redirect()->back()->with('eMessage', $eMessage);
			}
        }

        return abort(404);
    }

	public function getFarmingSlideEdit(Request $request, $farmingid, $slideid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
			$slide = $farming->slides()->where('slideid', $slideid)->first();

			if ($slide)
			{
				$this->params['farming']    = $farming;
				$this->params['slide']    	= $slide;
	            $this->params['request']    = $request;
	            $this->params['menu']       = 'doc';
	            $this->params['submenu']    = 'pearlfarming';

	            return view('dashboard.docs.pearl.farming.slide.edit', $this->params);
			}
        }

        return abort(404);
    }

	public function getFarmingSlideAdd(Request $request, $farmingid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
            $this->params['farming']    = $farming;
            $this->params['request']    = $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearlfarming';

            return view('dashboard.docs.pearl.farming.slide.add', $this->params);
        }

        return abort(404);
    }

	public function getFarmingSlides(Request $request, $farmingid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
            $this->params['farming']    = $farming;
            $this->params['request']    = $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearlfarming';

            return view('dashboard.docs.pearl.farming.slide.index', $this->params);
        }

        return abort(404);
    }

    public function getFarmingItem(Request $request, $farmingid)
    {
        $farming = PearlFarming::where('farmingid', $farmingid)->first();

        if ($farming)
        {
            $this->params['farming']    = $farming;
            $this->params['request']    = $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearlfarming';

            return view('dashboard.docs.pearl.farming.item', $this->params);
        }

        return abort(404);
    }

    public function postFarmingAdd(Request $request)
    {
        $title      = $request->input('title');
        $content    = $request->input('content');
        $farmingid  = $request->input('farmingid');
        $eMessage   = trans('error.procedure');

        if ($title && $content && $farmingid)
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($title[$locale['code']]) || !isset($content[$locale['code']])){
                    $valid = false;
                }
            }

            if ($valid)
            {
                $eMessage = trans('error.general');

                if (!File::isDirectory(public_path("app/pearlfarming/{$farmingid}"))){
                    File::makeDirectory(public_path("app/pearlfarming/{$farmingid}"));
                }

                $farming = new PearlFarming;
                $farming->farmingid = $farmingid;

                if ($farming->save())
                {
                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'pearlfarming';
                        $trans->model_id    = $farming->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();

                        $trans = new Translate;
                        $trans->model       = 'pearlfarming';
                        $trans->model_id    = $farming->id;
                        $trans->field       = 'content';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($content[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/docs/pearlfarming/' . $farming->farmingid . '/slides')->with('sMessage', trans('pearl.Add a new successfully.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getFarmingAdd(Request $request)
    {
        $this->params['farmingid']  = PearlFarming::createId();
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlfarming';

        return view('dashboard.docs.pearl.farming.add', $this->params);
    }

    public function getFarming(Request $request)
    {
        $items = PearlFarming::all();

        $this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlfarming';

        return view('dashboard.docs.pearl.farming.index', $this->params);
    }

    public function ajaxPostFarmDelete(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');
        $imageid    = $request->input('imageid');

        if ($id && $imageid)
        {
            $farm = PearlFarm::find($id);

            if ($farm && $farm->imageid == $imageid)
            {
                if ($farm->delete()){
                    File::delete([
                        public_path("app/pearlfarm/{$imageid}.png"),
                        public_path("app/pearlfarm/{$imageid}_t.png")
                    ]);

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostFarmUpload(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        if ($request->hasFile('image'))
        {
            $response['message'] = trans('error.general');

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
                    $interrupt = false;

                    foreach ($files as $file)
                    {
                        $id     = PearlFarm::createId();
                        $image  = \Image::make($file);
                        if ($image->save(public_path("app/pearlfarm/{$id}.png"), 100))
                        {
                            $image  = \Image::make(public_path("app/pearlfarm/{$id}.png"));
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

                            if ($image->save(public_path("app/pearlfarm/{$id}_t.png"), 100))
                            {
                                $image = new PearlFarm;
                                $image->imageid = $id;

                                if (!$image->save()){
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

        return response()->json($response);
    }

    public function getFarm(Request $request)
    {
        $items = PearlFarm::orderBy('created_at', 'desc')->get();

        $this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlfarm';

        return view('dashboard.docs.pearl.farm.index', $this->params);
    }

    public function ajaxPostTypeDelete(Request $request, $typeid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $type       = PearlType::where('typeid', $typeid)->first();

        if ($type)
        {
            $type->images()->each(function($image){
                $image->delete();
            });

            $translates = Translate::where('model', 'pearltype')
                ->where('model_id', $type->id)
                ->get()
                ->each(function($item){
                    $item->delete();
                });

            if ($type->delete() && $typeid != ''){
                \File::deleteDirectory(public_path("app/pearltype/{$typeid}"));

                $response['status']     = 'ok';
                $response['message']    = 'success';
            }
        }

        return response()->json($response);
    }

    public function ajaxPostTypeImageDelete(Request $request, $typeid, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $type       = PearlType::where('typeid', $typeid)->first();
        $id         = $request->input('id');

        if ($type && $id && $imageid)
        {
            $image = PearlTypeImage::find($id);

            if ($image && $image->imageid == $imageid && $image->pearl_type_id == $type->id){
                $image_id   = $image->id;
                $refresh    = false;

                if ($image->delete()){
                    if (File::exists(public_path("app/pearltype/{$type->typeid}/{$imageid}.png"))){
                        File::delete("app/pearltype/{$type->typeid}/{$imageid}.png");
                    }
                    if (File::exists(public_path("app/pearltype/{$type->typeid}/{$imageid}_t.png"))){
                        File::delete("app/pearltype/{$type->typeid}/{$imageid}_t.png");
                    }

                    if ($type->main_id == $image_id){
                        if ($type->images->count() > 0){
                            $main = $type->images->get(0);
                            if ($main){
                                $type->main_id = $main->id;
                                if ($type->save()){
                                    $refresh = true;
                                }
                            }
                        }
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['payload']['refresh'] = $refresh;
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostTypeMain(Request $request, $typeid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $type       = PearlType::where('typeid', $typeid)->first();
        $id         = $request->input('id');
        $imageid    = $request->input('imageid');

        if ($type && $id && $imageid)
        {
            $image = PearlTypeImage::find($id);

            if ($image && $image->imageid == $imageid && $image->pearl_type_id == $type->id){
                $type->main_id = $image->id;

                if ($type->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostTypeUpload(Request $request, $typeid)
    {
		$response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$type       = PearlType::where('typeid', $typeid)->first();

		if ($type)
		{
			if ($request->hasFile('image'))
			{
				$response['message'] = trans('error.general');

				$files  = $request->file('image');
				$valid  = true;

				foreach ($files as $file)
				{
					$ext = $file->getClientOriginalExtension();
					if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png'])){
						$valid = false;
					}
					unset($ext);
				}

				if ($valid)
				{
					if (count($files) <= 10)
					{
						$interrupt = false;

						foreach ($files as $file)
						{
							$id     = PearlTypeImage::createId();
							$image  = \Image::make($file);
							if ($image->save(public_path("app/pearltype/{$type->typeid}/{$id}.png"), 100))
							{
								$image  = \Image::make(public_path("app/pearltype/{$type->typeid}/{$id}.png"));
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

								if ($image->save(public_path("app/pearltype/{$type->typeid}/{$id}_t.png"), 100))
								{
									$image = new PearlTypeImage;
									$image->imageid = $id;
									$image->pearl_type_id = $type->id;

									if (!$image->save()){
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
							if (!$type->main && $type->images->count() > 0){
								$item = $type->images->get(0);
								if ($item){
									$type->main_id = $item->id;
									$type->save();
								}
							}
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

    public function getTypeImage(Request $request, $typeid)
    {
        $type = PearlType::where('typeid', $typeid)->first();

        if ($type)
        {
            $this->params['type']       = $type;
            $this->params['request']    = $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearltype';

            return view('dashboard.docs.pearl.type.image', $this->params);
        }

        return abort(404);
    }

    public function postTypeEdit(Request $request, $typeid)
    {
        $type = PearlType::where('typeid', $typeid)->first();

        if ($type)
        {
            $title      = $request->input('title');
            $detail     = $request->input('detail');
			$main		= $request->input('main');
            $eMessage   = trans('error.procedure');

            if ($title && $detail)
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if (!isset($title[$locale['code']]) || !isset($detail[$locale['code']])){
                        $valid = false;
                    }
                }

                if ($valid)
                {
                    $eMessage = trans('error.general');

					$type->main = ($main == 'yes')? true: false;
					$type->save();

                    foreach ($this->locales as $locale){
                        $trans = $type->getTitle($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($title[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'pearltype';
                            $trans->model_id    = $type->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();
                        }

                        $trans = $type->getDetail($locale['code'], true);
                        if ($trans){
                            $trans->text = trim($detail[$locale['code']]);
                            $trans->save();
                        }
                        else {
                            $trans = new Translate;
                            $trans->model       = 'pearltype';
                            $trans->model_id    = $type->id;
                            $trans->field       = 'detail';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($detail[$locale['code']]);
                            $trans->save();
                        }
                    }

                    return redirect('dashboard/docs/pearltype/'.$type->typeid)->with('sMessage', trans('_.Save changes successfully.'));
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getTypeEdit(Request $request, $typeid)
    {
        $type = PearlType::where('typeid', $typeid)->first();

        if ($type)
        {
            $this->params['type']       = $type;
            $this->params['request']    = $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearltype';

            return view('dashboard.docs.pearl.type.edit', $this->params);
        }

        return abort(404);
    }

    public function getTypeItem(Request $request, $typeid)
    {
        $type = PearlType::where('typeid', $typeid)->first();

        if ($type)
        {
            $this->params['type']       = $type;
            $this->params['request']    = $request;
            $this->params['menu']       = 'doc';
            $this->params['submenu']    = 'pearltype';

            return view('dashboard.docs.pearl.type.item', $this->params);
        }

        return abort(404);
    }

    public function postTypeAdd(Request $request)
    {
        $title      = $request->input('title');
        $detail     = $request->input('detail');
		$main		= $request->input('main');
        $eMessage   = trans('error.procedure');

        if ($title && $detail)
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($title[$locale['code']]) || !isset($detail[$locale['code']])){
                    $valid = false;
                }
            }

            if ($valid)
            {
                $eMessage = trans('error.general');

                $type = new PearlType;
				$type->main = ($main == 'yes')? true: false;

                if ($type->save()){
                    if (!\File::isDirectory(public_path("app/pearltype/{$type->typeid}"))){
                        \File::makeDirectory(public_path("app/pearltype/{$type->typeid}"));
                    }

                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'pearltype';
                        $trans->model_id    = $type->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();

                        $trans = new Translate;
                        $trans->model       = 'pearltype';
                        $trans->model_id    = $type->id;
                        $trans->field       = 'detail';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($detail[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/docs/pearltype/'.$type->typeid.'/images')->with('sMessage', trans('pearl.Added a new item successfully.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getTypeAdd(Request $request)
    {
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearltype';

        return view('dashboard.docs.pearl.type.add', $this->params);
    }

    public function getType(Request $request)
    {
        $items = PearlType::all();

        $this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearltype';

        return view('dashboard.docs.pearl.type.index', $this->params);
    }

    public function ajaxPostQualityItemDelete(Request $request, $itemid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$item		= PearlQuality::where('itemid', $itemid)->first();

        if ($item)
		{
			$imageid = $item->imageid;

			$translates = Translate::where('model', 'pearlquality')
                ->where('model_id', $item->id)
                ->get()
                ->each(function($item){
                    $item->delete();
                });

			if ($item->delete())
			{
				if (File::exists(public_path("app/pearlquality/{$imageid}.png"))){
                    File::delete(public_path("app/pearlquality/{$imageid}.png"));
                }

                $response['status']     = 'ok';
                $response['message']    = 'success';
			}
		}

        return response()->json($response);
    }

    public function getQuality(Request $request)
    {
        $items = PearlQuality::all();

        $this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlquality';

        return view('dashboard.docs.pearl.quality.index', $this->params);
    }

    public function ajaxPostCareImage(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        if ($request->hasFile('file'))
        {
            $file   = $request->file('file');
            $ext    = $file->getClientOriginalExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id     = PearlCare::createId();
                $image  = \Image::make($file);
                if ($image->save(public_path("app/pearlcare/{$id}.png"), 100))
                {
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['link']       = "/app/pearlcare/{$id}.png";
                }
            }
        }

        return response()->json($response);
    }

    public function postCare(Request $request)
    {
        $item       = PearlCare::first();
        $content    = $request->input('content');
        $eMessage   = trans('error.procedure');

        if ($content)
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($content[$locale['code']])){
                    $valid = false;
                }
            }

            if ($valid)
            {
                $eMessage = trans('error.general');

                foreach ($this->locales as $locale){
                    $trans = $item->getContent($locale['code'], true);
                    if ($trans){
                        $trans->text = trim($content[$locale['code']]);
                        $trans->save();
                    }
                    else {
                        $trans = new Translate;
                        $trans->model       = 'pearlcare';
                        $trans->model_id    = $item->id;
                        $trans->field       = 'content';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($content[$locale['code']]);
                        $trans->save();
                    }
                }

                return redirect()->back()->with('sMessage', trans('_.Save changes successfully.'));
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getCare(Request $request)
    {
        $item = PearlCare::first();

        $this->params['item']       = $item;
        $this->params['request']    = $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'pearlcare';

        return view('dashboard.docs.pearl.care', $this->params);
    }
}
