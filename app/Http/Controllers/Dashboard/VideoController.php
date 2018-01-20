<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Video;
use App\Translate;

class VideoController extends Controller {

    public function ajaxPostDelete(Request $request, $videoid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $video = Video::find($id);
            if ($video && $video->videoid == $videoid)
            {
                $response['message'] = trans('error.general');

                $videoid = $video->videoid;

                $translates = Translate::where('model', 'video')
                    ->where('model_id', $video->id)
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($video->delete() && $videoid != '')
                {
                    \File::deleteDirectory(public_path("app/videos/{$videoid}"));

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function getEdit(Request $request, $videoid)
    {
        $video = Video::where('videoid', $videoid)->first();

        if ($video)
        {
            $this->params['video']      = $video;
            $this->params['request']	= $request;
            $this->params['menu']       = 'video';

            return view('dashboard.videos.edit', $this->params);
        }

        return abort(404);
    }

    public function postEdit(Request $request, $videoid)
    {
        $video = Video::where('videoid', $videoid)->first();

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

                        if (!\File::isDirectory(public_path("app/videos/{$video->videoid}"))){
                            \File::makeDirectory(public_path("app/videos/{$video->videoid}"));
                        }
                        else {
                            \File::cleanDirectory(public_path("app/videos/{$video->videoid}"));
                        }

                        if ($yt && isset($yt->snippet) && isset($yt->snippet->thumbnails))
                        {
                            if (isset($yt->snippet->thumbnails->maxres)){
                                $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                                if ($image->save(public_path("app/videos/{$video->videoid}/maxres.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['maxres'] = true;

                                    $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                                    if ($image->save(public_path("app/videos/{$video->videoid}/preview_temp.png"), 100)){
                                        $image->destroy();
                                        $preview = true;
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->medium)){
                                $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                if ($image->save(public_path("app/videos/{$video->videoid}/medium.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['medium'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                        if ($image->save(public_path("app/videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->standard)){
                                $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                if ($image->save(public_path("app/videos/{$video->videoid}/standard.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['standard'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                        if ($image->save(public_path("app/videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->high)){
                                $image = \Image::make($yt->snippet->thumbnails->high->url);
                                if ($image->save(public_path("app/videos/{$video->videoid}/high.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['high'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->high->url);
                                        if ($image->save(public_path("app/videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->default)){
                                $image = \Image::make($yt->snippet->thumbnails->default->url);
                                if ($image->save(public_path("app/videos/{$video->videoid}/default.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['default'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->default->url);
                                        if ($image->save(public_path("app/videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }
                        }

                        if ($preview)
                        {
                            $image  = \Image::make(public_path("app/videos/{$video->videoid}/preview_temp.png"));
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
                            $image->save(public_path("app/videos/{$video->videoid}/preview.png"), 100);
                            $image->destroy();
                            \File::delete(public_path("app/videos/{$video->videoid}/preview_temp.png"));
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
                                $trans->model       = 'video';
                                $trans->model_id    = $video->id;
                                $trans->field       = 'title';
                                $trans->locale      = $locale['code'];
                                $trans->text        = trim($title[$locale['code']]);
                                $trans->save();
                            }
                        }

                        return redirect('dashboard/videos')->with('sMessage', trans('video.Save changes to video information successfully.'));
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function postAdd(Request $request)
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
                $videoid    = Video::createId();
                $yt         = \Youtube::getVideoInfo($ytid);
                $preview    = false;
                $thumb      = [
                    'default'   => false,
                    'medium'    => false,
                    'high'      => false,
                    'standard'  => false,
                    'maxres'    => false
                ];

                if (!\File::isDirectory(public_path("app/videos/{$videoid}"))){
                    \File::makeDirectory(public_path("app/videos/{$videoid}"));
                }

                if ($yt && isset($yt->snippet) && isset($yt->snippet->thumbnails))
                {
                    if (isset($yt->snippet->thumbnails->maxres)){
                        $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                        if ($image->save(public_path("app/videos/{$videoid}/maxres.jpg"), 100)){
                            $image->destroy();
                            $thumb['maxres'] = true;

                            $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                            if ($image->save(public_path("app/videos/{$videoid}/preview_temp.png"), 100)){
                                $image->destroy();
                                $preview = true;
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->medium)){
                        $image = \Image::make($yt->snippet->thumbnails->medium->url);
                        if ($image->save(public_path("app/videos/{$videoid}/medium.jpg"), 100)){
                            $image->destroy();
                            $thumb['medium'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                if ($image->save(public_path("app/videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->standard)){
                        $image = \Image::make($yt->snippet->thumbnails->standard->url);
                        if ($image->save(public_path("app/videos/{$videoid}/standard.jpg"), 100)){
                            $image->destroy();
                            $thumb['standard'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                if ($image->save(public_path("app/videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->high)){
                        $image = \Image::make($yt->snippet->thumbnails->high->url);
                        if ($image->save(public_path("app/videos/{$videoid}/high.jpg"), 100)){
                            $image->destroy();
                            $thumb['high'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->high->url);
                                if ($image->save(public_path("app/videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->default)){
                        $image = \Image::make($yt->snippet->thumbnails->default->url);
                        if ($image->save(public_path("app/videos/{$videoid}/default.jpg"), 100)){
                            $image->destroy();
                            $thumb['default'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->default->url);
                                if ($image->save(public_path("app/videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }
                }

                if ($preview)
                {
                    $image  = \Image::make(public_path("app/videos/{$videoid}/preview_temp.png"));
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
                    $image->save(public_path("app/videos/{$videoid}/preview.png"), 100);
                    $image->destroy();
                    \File::delete(public_path("app/videos/{$videoid}/preview_temp.png"));
                }

                $video = new Video;
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
                        $trans->model       = 'video';
                        $trans->model_id    = $video->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/videos')->with('sMessage', trans('video.Added a new video successfully.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getAdd(Request $request)
    {
		$this->params['request']	= $request;
        $this->params['menu']       = 'video';

        return view('dashboard.videos.add', $this->params);
    }

    public function getIndex(Request $request)
    {
        $items  = Video::orderBy('created_at', 'desc')->paginate(25);

		$this->params['items']		= $items;
		$this->params['request']	= $request;
        $this->params['menu']       = 'video';

        return view('dashboard.videos.index', $this->params);
    }
}
