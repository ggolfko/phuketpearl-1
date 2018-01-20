<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Translate;
use App\Gallery;
use App\GalleryVideo;
use Image;
use File;

class PictureController extends Controller {

    public function ajaxPostVideoDelete(Request $request, $videoid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $video = GalleryVideo::find($id);
            if ($video && $video->videoid == $videoid)
            {
                $response['message'] = trans('error.general');

                $videoid = $video->videoid;

                $translates = Translate::where('model', 'gallery_video')
                    ->where('model_id', $video->id)
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($video->delete() && $videoid != '')
                {
                    \File::deleteDirectory(public_path("app/gallery_videos/{$videoid}"));

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postVideoEdit(Request $request, $videoid)
    {
        $video = GalleryVideo::where('videoid', $videoid)->first();

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

                        if (!\File::isDirectory(public_path("app/gallery_videos/{$video->videoid}"))){
                            \File::makeDirectory(public_path("app/gallery_videos/{$video->videoid}"));
                        }
                        else {
                            \File::cleanDirectory(public_path("app/gallery_videos/{$video->videoid}"));
                        }

                        if ($yt && isset($yt->snippet) && isset($yt->snippet->thumbnails))
                        {
                            if (isset($yt->snippet->thumbnails->maxres)){
                                $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                                if ($image->save(public_path("app/gallery_videos/{$video->videoid}/maxres.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['maxres'] = true;

                                    $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                                    if ($image->save(public_path("app/gallery_videos/{$video->videoid}/preview_temp.png"), 100)){
                                        $image->destroy();
                                        $preview = true;
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->medium)){
                                $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                if ($image->save(public_path("app/gallery_videos/{$video->videoid}/medium.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['medium'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                        if ($image->save(public_path("app/gallery_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->standard)){
                                $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                if ($image->save(public_path("app/gallery_videos/{$video->videoid}/standard.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['standard'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                        if ($image->save(public_path("app/gallery_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->high)){
                                $image = \Image::make($yt->snippet->thumbnails->high->url);
                                if ($image->save(public_path("app/gallery_videos/{$video->videoid}/high.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['high'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->high->url);
                                        if ($image->save(public_path("app/gallery_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }

                            if (isset($yt->snippet->thumbnails->default)){
                                $image = \Image::make($yt->snippet->thumbnails->default->url);
                                if ($image->save(public_path("app/gallery_videos/{$video->videoid}/default.jpg"), 100)){
                                    $image->destroy();
                                    $thumb['default'] = true;

                                    if (!$preview)
                                    {
                                        $image = \Image::make($yt->snippet->thumbnails->default->url);
                                        if ($image->save(public_path("app/gallery_videos/{$video->videoid}/preview_temp.png"), 100)){
                                            $image->destroy();
                                            $preview = true;
                                        }
                                    }
                                }
                            }
                        }

                        if ($preview)
                        {
                            $image  = \Image::make(public_path("app/gallery_videos/{$video->videoid}/preview_temp.png"));
                            $image->fit(622, 415);
                            $image->save(public_path("app/gallery_videos/{$video->videoid}/preview.png"), 100);
                            $image->destroy();
                            \File::delete(public_path("app/gallery_videos/{$video->videoid}/preview_temp.png"));
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
                                $trans->model       = 'gallery_video';
                                $trans->model_id    = $video->id;
                                $trans->field       = 'title';
                                $trans->locale      = $locale['code'];
                                $trans->text        = trim($title[$locale['code']]);
                                $trans->save();
                            }
                        }

                        return redirect('dashboard/gallery/videos')->with('sMessage', trans('video.Save changes to video information successfully.'));
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getVideoEdit(Request $request, $videoid)
    {
        $video = GalleryVideo::where('videoid', $videoid)->first();

        if ($video)
        {
            $this->params['video']      = $video;
            $this->params['request']	= $request;
            $this->params['menu']       = 'gallery';

            return view('dashboard.gallery.video.edit', $this->params);
        }

        return abort(404);
    }

    public function postVideoAdd(Request $request)
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
                $videoid    = GalleryVideo::createId();
                $yt         = \Youtube::getVideoInfo($ytid);
                $preview    = false;
                $thumb      = [
                    'default'   => false,
                    'medium'    => false,
                    'high'      => false,
                    'standard'  => false,
                    'maxres'    => false
                ];

                if (!\File::isDirectory(public_path("app/gallery_videos/{$videoid}"))){
                    \File::makeDirectory(public_path("app/gallery_videos/{$videoid}"));
                }

                if ($yt && isset($yt->snippet) && isset($yt->snippet->thumbnails))
                {
                    if (isset($yt->snippet->thumbnails->maxres)){
                        $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                        if ($image->save(public_path("app/gallery_videos/{$videoid}/maxres.jpg"), 100)){
                            $image->destroy();
                            $thumb['maxres'] = true;

                            $image = \Image::make($yt->snippet->thumbnails->maxres->url);
                            if ($image->save(public_path("app/gallery_videos/{$videoid}/preview_temp.png"), 100)){
                                $image->destroy();
                                $preview = true;
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->medium)){
                        $image = \Image::make($yt->snippet->thumbnails->medium->url);
                        if ($image->save(public_path("app/gallery_videos/{$videoid}/medium.jpg"), 100)){
                            $image->destroy();
                            $thumb['medium'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->medium->url);
                                if ($image->save(public_path("app/gallery_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->standard)){
                        $image = \Image::make($yt->snippet->thumbnails->standard->url);
                        if ($image->save(public_path("app/gallery_videos/{$videoid}/standard.jpg"), 100)){
                            $image->destroy();
                            $thumb['standard'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->standard->url);
                                if ($image->save(public_path("app/gallery_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->high)){
                        $image = \Image::make($yt->snippet->thumbnails->high->url);
                        if ($image->save(public_path("app/gallery_videos/{$videoid}/high.jpg"), 100)){
                            $image->destroy();
                            $thumb['high'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->high->url);
                                if ($image->save(public_path("app/gallery_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }

                    if (isset($yt->snippet->thumbnails->default)){
                        $image = \Image::make($yt->snippet->thumbnails->default->url);
                        if ($image->save(public_path("app/gallery_videos/{$videoid}/default.jpg"), 100)){
                            $image->destroy();
                            $thumb['default'] = true;

                            if (!$preview)
                            {
                                $image = \Image::make($yt->snippet->thumbnails->default->url);
                                if ($image->save(public_path("app/gallery_videos/{$videoid}/preview_temp.png"), 100)){
                                    $image->destroy();
                                    $preview = true;
                                }
                            }
                        }
                    }
                }

                if ($preview)
                {
                    $image  = \Image::make(public_path("app/gallery_videos/{$videoid}/preview_temp.png"));
                    $image->fit(622, 415);
                    $image->save(public_path("app/gallery_videos/{$videoid}/preview.png"), 100);
                    $image->destroy();
                    \File::delete(public_path("app/gallery_videos/{$videoid}/preview_temp.png"));
                }

                $video = new GalleryVideo;
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
                        $trans->model       = 'gallery_video';
                        $trans->model_id    = $video->id;
                        $trans->field       = 'title';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($title[$locale['code']]);
                        $trans->save();
                    }

                    return redirect('dashboard/gallery/videos')->with('sMessage', trans('video.Added a new video successfully.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getVideoAdd(Request $request)
    {
		$this->params['request']	= $request;
        $this->params['menu']       = 'gallery';

        return view('dashboard.gallery.video.add', $this->params);
    }

    public function getVideo(Request $request)
    {
        $items = GalleryVideo::orderBy('created_at', 'desc')->get();

        $this->params['items']		= $items;
		$this->params['request']	= $request;
        $this->params['menu']       = 'gallery';

        return view('dashboard.gallery.video.index', $this->params);
    }

	public function ajaxPostImageDelete(Request $request, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$gallery	= Gallery::where('imageid', $imageid)->first();

		if ($gallery)
		{
			$refresh = false;

			if ($gallery->delete())
			{
				\File::delete([
					public_path("app/gallery/{$imageid}.png"),
					public_path("app/gallery/{$imageid}_t.png")
				]);

				if (Gallery::count() < 1){
					$refresh = true;
				}

				$response['status']     = 'ok';
				$response['message']    = 'success';
				$response['payload']['refresh'] = $refresh;
			}
		}

        return response()->json($response);
    }

	public function ajaxPostImages(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$response['message'] = trans('error.image');

		$files = $request->input('files');

		if ($files)
		{
			foreach ($files as $file)
			{
				if ( isset($file['name']) && isset($file['ext']) && isset($file['file']) && File::exists( public_path($file['file']) ))
				{
					$id     = Gallery::createId();
					$image	= Image::make( public_path($file['file']) );

					if ($image->save(public_path("app/gallery/{$id}.png"), 100))
					{
						$image->fit(622, 415);

						if ($image->save(public_path("app/gallery/{$id}_t.png"), 100))
						{
							$gallery = new Gallery;
							$gallery->imageid = $id;

							$gallery->save();

							unset($photo);
						}
					}

					unset($image);
				}
			}

			unset($files);
			clearTempFiles();

			$response['status']		= 'ok';
			$response['message']	= 'success';
		}

        return response()->json($response);
    }

	public function ajaxPostUpload(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

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
					$temps = [];

					foreach ($files as $file)
					{
						$temp = tempFile($file);

						if ($temp){
							$temps[] = $temp;
						}
					}

					if (count($temps) > 0)
					{
						$response['status']     = 'ok';
						$response['message']    = 'success';
						$response['payload']['images'] = $temps;
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

    public function getIndex(Request $request)
    {
        $items = Gallery::orderBy('created_at', 'desc')->get();

		$this->params['items']		= $items;
		$this->params['request']	= $request;
        $this->params['menu']       = 'gallery';

        return view('dashboard.gallery.index', $this->params);
    }
}
