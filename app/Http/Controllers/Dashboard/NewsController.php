<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\News;
use App\NewsImage;
use App\Translate;
use App\MediaSpecialGuest;
use App\MediaSpecialGuestImage;
use Image;
use File;

class NewsController extends Controller {

	public function ajaxPostMediaSpecialGuestsDelete(Request $request, $itemid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$item		= MediaSpecialGuest::where('itemid', $itemid)->first();

        if ($item)
        {
			$response['message'] = trans('error.general');

			$item->images()->each(function($image){
				$image->delete();
			});

			$translates = Translate::where('model', 'media_special_guests')
				->where('model_id', $item->id)
				->get()
				->each(function($trans){
					$trans->delete();
				});

			if ($item->delete() && $itemid != '')
			{
				if (\File::isDirectory(public_path("app/media_special_guests/{$itemid}"))){
					\File::deleteDirectory(public_path("app/media_special_guests/{$itemid}"));
				}

				$response['status']     = 'ok';
				$response['message']    = 'success';
			}
        }

        return response()->json($response);
    }

	public function ajaxPostMediaSpecialGuestsImageDelete(Request $request, $itemid, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$item		= MediaSpecialGuest::where('itemid', $itemid)->first();
		$id         = $request->input('id');

        if ($item)
        {
			$image = MediaSpecialGuestImage::find($id);

			if ($image && $image->imageid == $imageid && $item->id == $image->item_id)
            {
				if ($image->delete())
                {
                    $refresh = false;

                    \File::delete([
                        public_path("app/media_special_guests/{$item->itemid}/{$imageid}.png"),
                        public_path("app/media_special_guests/{$item->itemid}/{$imageid}_t.png")
                    ]);

                    if ($item->images->count() < 1){
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

	public function ajaxPostMediaSpecialGuestsImages(Request $request, $itemid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$item		= MediaSpecialGuest::where('itemid', $itemid)->first();

        if ($item)
        {
            $response['message'] = trans('error.image');

			$files = $request->input('files');

			if ($files)
			{
				foreach ($files as $file)
				{
					if ( isset($file['name']) && isset($file['ext']) && isset($file['file']) && File::exists( public_path($file['file']) ))
					{
						$id     = MediaSpecialGuestImage::createId();
						$image	= Image::make( public_path($file['file']) );

						if ($image->save(public_path("app/media_special_guests/{$item->itemid}/{$id}.png"), 100))
						{
							$image->fit(512, 288);

							if ($image->save(public_path("app/media_special_guests/{$item->itemid}/{$id}_t.png"), 100))
							{
								$img = new MediaSpecialGuestImage;
								$img->imageid	= $id;
								$img->item_id	= $item->id;
								$img->save();

								unset($img);
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
        }

        return response()->json($response);
    }

	public function ajaxPostMediaSpecialGuestsUpload(Request $request, $itemid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$item		= MediaSpecialGuest::where('itemid', $itemid)->first();

        if ($item)
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
                        if (!\File::isDirectory(public_path("app/media_special_guests/{$item->itemid}"))){
	                        \File::makeDirectory(public_path("app/media_special_guests/{$item->itemid}"));
	                    }

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
        }

        return response()->json($response);
    }

	public function postMediaSpecialGuestsItem(Request $request, $itemid)
    {
        $item = MediaSpecialGuest::where('itemid', $itemid)->first();

        if ($item)
        {
			$topic		= $request->input('topic');
			$eMessage	= trans('error.procedure');

			if ($topic)
	        {
	            $valid = true;
	            foreach ($this->locales as $locale){
	                if (!isset($topic[$locale['code']])){
	                    $valid = false;
	                }
	            }

				if ($valid)
	            {
	                $eMessage = trans('error.general');

					if ($item->save())
	                {
	                    if (!\File::isDirectory(public_path("app/media_special_guests/{$item->itemid}"))){
	                        \File::makeDirectory(public_path("app/media_special_guests/{$item->itemid}"));
	                    }

						foreach ($this->locales as $locale){
							$trans = $item->getTopic($locale['code'], true);
                            if ($trans){
                                $trans->text = trim($topic[$locale['code']]);
                                $trans->save();
                            }
                            else {
                                $trans = new Translate;
		                        $trans->model       = 'media_special_guests';
		                        $trans->model_id    = $item->id;
		                        $trans->field       = 'topic';
		                        $trans->locale      = $locale['code'];
		                        $trans->text        = trim($topic[$locale['code']]);
		                        $trans->save();
                            }
	                    }

						return redirect("dashboard/docs/media-special-guests")->with('sMessage', trans('_.Save changes successfully.'));
					}
				}
			}

			return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

	public function getMediaSpecialGuestsItem(Request $request, $itemid)
    {
        $item = MediaSpecialGuest::where('itemid', $itemid)->first();

        if ($item)
        {
			$this->params['item']		= $item;
			$this->params['request']	= $request;
	        $this->params['menu']       = 'doc';
			$this->params['submenu']    = 'media-special-guests';

            return view('dashboard.docs.media-special-guests.item', $this->params);
        }

        return abort(404);
    }

	public function getMediaSpecialGuestsImages(Request $request, $itemid)
    {
        $item = MediaSpecialGuest::where('itemid', $itemid)->first();

        if ($item)
        {
			$this->params['item']		= $item;
			$this->params['request']	= $request;
	        $this->params['menu']       = 'doc';
			$this->params['submenu']    = 'media-special-guests';

            return view('dashboard.docs.media-special-guests.image', $this->params);
        }

        return abort(404);
    }

	public function postMediaSpecialGuestsAdd(Request $request)
    {
		$topic		= $request->input('topic');
		$eMessage	= trans('error.procedure');

		if ($topic)
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($topic[$locale['code']])){
                    $valid = false;
                }
            }

			if ($valid)
            {
                $eMessage = trans('error.general');

				$item = new MediaSpecialGuest;

				if ($item->save())
                {
                    if (!\File::isDirectory(public_path("app/media_special_guests/{$item->itemid}"))){
                        \File::makeDirectory(public_path("app/media_special_guests/{$item->itemid}"));
                    }

					foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'media_special_guests';
                        $trans->model_id    = $item->id;
                        $trans->field       = 'topic';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($topic[$locale['code']]);
                        $trans->save();
                    }

					return redirect("dashboard/docs/media-special-guests/{$item->itemid}/images")->with('sMessage', trans('_.Added a new item successfully.'));
				}
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
    }

	public function getMediaSpecialGuestsAdd(Request $request)
    {
		$this->params['request']	= $request;
        $this->params['menu']       = 'doc';
		$this->params['submenu']    = 'media-special-guests';

        return view('dashboard.docs.media-special-guests.add', $this->params);
    }

	public function getMediaSpecialGuests(Request $request)
    {
		$items = MediaSpecialGuest::orderBy('created_at', 'desc')->get();

		$this->params['items']		= $items;
		$this->params['request']	= $request;
        $this->params['menu']       = 'doc';
		$this->params['submenu']    = 'media-special-guests';

        return view('dashboard.docs.media-special-guests.index', $this->params);
    }

    public function ajaxPostPublish(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');
        $newsid     = $request->input('newsid');
        $publish    = $request->input('publish');

        if ($id && $newsid && $publish && in_array($publish, ['yes', 'no']))
        {
            $news = News::find($id);

            if ($news && $news->newsid == $newsid)
            {
                $response['message'] = trans('error.general');
                $news->publish = $publish == 'yes'? true: false;

                if ($news->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postEdit(Request $request, $newsid)
    {
        $news = News::where('newsid', $newsid)->first();

        if ($news)
        {
            $topic          = $request->input('topic');
            $description    = $request->input('description');
			$published		= $request->input('published');
            $publish        = $request->input('publish');
            $content        = $request->input('content');
            $eMessage       = trans('error.procedure');

            if ($topic && $description && $content && $publish && in_array($publish, ['yes', 'no']))
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if (!isset($topic[$locale['code']]) || !isset($content[$locale['code']]) || !isset($description[$locale['code']]) ){
                        $valid = false;
                    }
                }

                if ($valid)
                {
                    $eMessage = trans('error.general');
					$news->published	= $published? $published: date('Y-m-d');
                    $news->publish  	= $publish == 'yes'? true: false;

                    if ($news->save())
                    {
                        foreach ($this->locales as $locale){
                            $trans = $news->getTopic($locale['code'], true);
                            if ($trans){
                                $trans->text = trim($topic[$locale['code']]);
                                $trans->save();
                            }
                            else {
                                $trans = new Translate;
                                $trans->model       = 'news';
                                $trans->model_id    = $news->id;
                                $trans->field       = 'topic';
                                $trans->locale      = $locale['code'];
                                $trans->text        = trim($topic[$locale['code']]);
                                $trans->save();
                            }

                            $trans = $news->getDescription($locale['code'], true);
                            if ($trans){
                                $trans->text = trim($description[$locale['code']]);
                                $trans->save();
                            }
                            else {
                                $trans = new Translate;
                                $trans->model       = 'news';
                                $trans->model_id    = $news->id;
                                $trans->field       = 'description';
                                $trans->locale      = $locale['code'];
                                $trans->text        = trim($description[$locale['code']]);
                                $trans->save();
                            }

                            $trans = $news->getContent($locale['code'], true);
                            if ($trans){
                                $trans->text = trim($content[$locale['code']]);
                                $trans->save();
                            }
                            else {
                                $trans = new Translate;
                                $trans->model       = 'news';
                                $trans->model_id    = $news->id;
                                $trans->field       = 'content';
                                $trans->locale      = $locale['code'];
                                $trans->text        = trim($content[$locale['code']]);
                                $trans->save();
                            }
                        }

                        return redirect("dashboard/news/{$news->newsid}")->with('sMessage', trans('news.Save the changes successfully.'));
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $newsid)
    {
        $news = News::where('newsid', $newsid)->first();

        if ($news)
        {
            $this->params['request']    = $request;
    		$this->params['news']		= $news;
            $this->params['menu']       = 'news';

            return view('dashboard.news.edit', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostItemDelete(Request $request, $newsid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $news = News::find($id);
            if ($news && $news->newsid == $newsid)
            {
                $response['message'] = trans('error.general');

                $newsid     = $news->newsid;
                $imageid    = $news->imageid;

                $news->images()->each(function($item){
                    $item->delete();
                });

                $translates = Translate::where('model', 'news')
                    ->where('model_id', $news->id)
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($news->delete() && $newsid != '' && $imageid != '')
                {
                    if (\File::isDirectory(public_path("app/news/{$newsid}"))){
                        \File::deleteDirectory(public_path("app/news/{$newsid}"));
                    }
                    if (\File::isDirectory(public_path("app/news/{$imageid}"))){
                        \File::deleteDirectory(public_path("app/news/{$imageid}"));
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostItemImageDelete(Request $request, $newsid, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $news       = News::where('newsid', $newsid)->first();
        $id         = $request->input('id');

        if ($news && $id)
        {
            $image = NewsImage::find($id);

            if ($image && $image->imageid == $imageid && $news->id == $image->news_id)
            {
                if ($image->delete())
                {
                    $refresh = false;

                    \File::delete([
                        public_path("app/news/{$news->newsid}/{$imageid}.png"),
                        public_path("app/news/{$news->newsid}/{$imageid}_t.png")
                    ]);

                    if ($news->images->count() < 1){
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

	public function ajaxPostItemImages(Request $request, $newsid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$news       = News::where('newsid', $newsid)->first();

        if ($news)
        {
            $response['message'] = trans('error.image');

			$files = $request->input('files');

			if ($files)
			{
				foreach ($files as $file)
				{
					if ( isset($file['name']) && isset($file['ext']) && isset($file['file']) && File::exists( public_path($file['file']) ))
					{
						$id     = NewsImage::createId();
						$image	= Image::make( public_path($file['file']) );

						if ($image->save(public_path("app/news/{$news->newsid}/{$id}.png"), 100))
						{
							$image->fit(512, 288);

							if ($image->save(public_path("app/news/{$news->newsid}/{$id}_t.png"), 100))
							{
								$newImage = new NewsImage;
								$newImage->imageid      = $id;
								$newImage->news_id      = $news->id;
								$newImage->save();

								unset($newImage);
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
        }

        return response()->json($response);
    }

    public function ajaxPostItemImagesUpload(Request $request, $newsid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $news       = News::where('newsid', $newsid)->first();

        if ($news)
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
                        if (!\File::isDirectory(public_path("app/news/{$news->newsid}"))){
							\File::makeDirectory(public_path("app/news/{$news->newsid}"));
						}

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
        }

        return response()->json($response);
    }

    public function ajaxPostImageUpload(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $imageid    = $request->input('imageid');

        if ($imageid && $request->hasFile('file'))
        {
            if (!\File::isDirectory(public_path("app/news/{$imageid}"))){
                \File::makeDirectory(public_path("app/news/{$imageid}"));
            }

            $file   = $request->file('file');
            $ext    = $file->getClientOriginalExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id     = NewsImage::createId();
                $image  = \Image::make($file);
                if ($image->save(public_path("app/news/{$imageid}/{$id}.png"), 100))
                {
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['link']       = "/app/news/{$imageid}/{$id}.png";
                }
            }
        }

        return response()->json($response);
    }

    public function getImages(Request $request, $newsid)
    {
        $news = News::where('newsid', $newsid)->first();

        if ($news)
        {
    		$this->params['news']		= $news;
            $this->params['menu']       = 'news';

            return view('dashboard.news.image', $this->params);
        }

        return abort(404);
    }

    public function getItem(Request $request, $newsid)
    {
        $news = News::where('newsid', $newsid)->first();

        if ($news)
        {
    		$this->params['news']		= $news;
            $this->params['menu']       = 'news';

            return view('dashboard.news.item', $this->params);
        }

        return abort(404);
    }

    public function postWrite(Request $request)
    {
        $topic          = $request->input('topic');
        $description    = $request->input('description');
		$published      = $request->input('published');
        $publish        = $request->input('publish');
        $content        = $request->input('content');
        $imageid        = $request->input('imageid');
        $eMessage       = trans('error.procedure');

        if ($topic && $description && $content && $publish && in_array($publish, ['yes', 'no']) && $imageid)
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($topic[$locale['code']]) || !isset($content[$locale['code']]) || !isset($description[$locale['code']])){
                    $valid = false;
                }
            }

            if ($valid)
            {
                $eMessage = trans('error.general');
                $news = new News;
                $news->imageid  	= $imageid;
                $news->views    	= 0;
				$news->published	= $published? $published: date('Y-m-d');
                $news->publish  	= $publish == 'yes'? true: false;

                if ($news->save())
                {
                    if (!\File::isDirectory(public_path("app/news/{$news->newsid}"))){
                        \File::makeDirectory(public_path("app/news/{$news->newsid}"));
                    }

                    foreach ($this->locales as $locale){
                        $trans = new Translate;
                        $trans->model       = 'news';
                        $trans->model_id    = $news->id;
                        $trans->field       = 'topic';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($topic[$locale['code']]);
                        $trans->save();

                        $trans = new Translate;
                        $trans->model       = 'news';
                        $trans->model_id    = $news->id;
                        $trans->field       = 'description';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($description[$locale['code']]);
                        $trans->save();

                        $trans = new Translate;
                        $trans->model       = 'news';
                        $trans->model_id    = $news->id;
                        $trans->field       = 'content';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($content[$locale['code']]);
                        $trans->save();
                    }

                    return redirect("dashboard/news/{$news->newsid}/images")->with('sMessage', trans('news.Successfully saved the news.'));
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getWrite(Request $request)
    {
        $imageid = NewsImage::createId();

        $this->params['request']    = $request;
        $this->params['imageid']    = $imageid;
        $this->params['menu']       = 'news';

        return view('dashboard.news.write', $this->params);
    }

    public function getIndex(Request $request)
    {
        $items = News::orderBy('created_at', 'desc')->paginate(25);

		$this->params['items']		= $items;
		$this->params['request']	= $request;
        $this->params['menu']       = 'news';

        return view('dashboard.news.index', $this->params);
    }
}
