<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Slide;
use Image;
use File;

class SlideController extends Controller {

	public function postItem(Request $request, $slideid)
    {
		$eMessage	= trans('error.procedure');
		$item 		= Slide::where('slideid', $slideid)->first();

		if ($item)
		{
			$link		= $request->input('link');
			$imageid	= $request->input('imageid');
			$publish	= $request->input('publish');

			if (
				$imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16 &&
				$publish && in_array($publish, ['yes', 'no'])
			)
			{
				$eMessage = trans('error.general');

				$item->publish = ($publish == 'yes');

				$link = trim($link);

				if ($link && preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $link))
				{
					$internal = false;

					$originUrl		= parse_url(config('app.url'));
					$originHost		= $originUrl['host'];
					$originDomain	= str_replace('www.', '', $originHost);

					$pointUrl		= parse_url($link);
					$pointHost		= $pointUrl['host'];

					if (preg_match('/'.$originDomain.'/', $pointHost)){
						$internal = true;
					}

					if ($internal){
						$item->link = isset($pointUrl['path'])? $pointUrl['path']: '';
					}
					else {
						$item->link = $link;
					}

					$item->link_set			= true;
					$item->link_internal	= $internal;
				}
				else {
					$item->link				= '';
					$item->link_set			= false;
					$item->link_internal	= false;
				}

				if ($item->save())
				{
					//new image
					if ($imageid != $item->imageid)
					{
						$imageTemp = public_path("app/slide/temp/{$imageid}.png");

						if (File::exists($imageTemp))
						{
							$imageDirPath = public_path("app/slide/{$item->slideid}");

							if (!File::isDirectory($imageDirPath)){
								File::makeDirectory($imageDirPath);
							}

							$image = Image::make($imageTemp);
							$image->fit(622, 415);

							if ($image->save("{$imageDirPath}/{$imageid}_t.png", 100))
							{
								$image->destroy();
								$image = Image::make($imageTemp);

								if ($image->save("{$imageDirPath}/{$imageid}.png", 100))
								{
									$item->imageid = $imageid;

									if ($item->save())
									{
										File::cleanDirectory(public_path('app/slide/temp'));

										return redirect('dashboard/slides')->with('sMessage', trans('_.Save changes successfully.'));
									}
								}
							}
						}
					}
					//sae image
					else {
						File::cleanDirectory(public_path('app/slide/temp'));

						return redirect('dashboard/slides')->with('sMessage', trans('_.Save changes successfully.'));
					}
				}
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
    }

	public function getItem(Request $request, $slideid)
    {
		$item = Slide::where('slideid', $slideid)->first();

		if ($item)
		{
			$this->params['item']		= $item;
	        $this->params['request']	= $request;
			$this->params['menu']		= 'slide';

	        return view('dashboard.slides.item', $this->params);
		}
    }

	public function ajaxPostPublish(Request $request, $slideid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$slide		= Slide::where('slideid', $slideid)->first();
		$set		= $request->input('set');

		if ($slide && $set && in_array($set, ['yes', 'no']))
        {
			$response['message'] = trans('error.general');

			$slide->publish = ($set == 'yes');

			if ($slide->save()){
				$response['status']     = 'ok';
				$response['message']    = 'success';
			}
        }

        return response()->json($response);
    }

	public function ajaxPostSort(Request $request, $slideid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$slide		= Slide::where('slideid', $slideid)->first();
		$type		= $request->input('type');

        if ($slide && $type && in_array($type, ['up', 'down']))
        {
			$response['message'] = trans('error.general');

			//up
			if ($type == 'up')
			{
				$first = Slide::orderBy('sort', 'asc')->first();

				if ($first && $first->slideid != $slide->slideid)
				{
					$slides = Slide::orderBy('sort', 'desc')->get();
					$item_1	= false;
					$item_2	= false;

					foreach ($slides as $item){
						if ($item->slideid == $slide->slideid){
							$item_1 = $item;
						}
						else if ($item_1 && !$item_2) {
							$item_2 = $item;
						}
					}

					if ($item_1 && $item_2)
					{
						$sort_1	= $item_1->sort;
						$sort_2	= $item_2->sort;

						$item_1->sort = $sort_2;
						$item_2->sort = $sort_1;

						if ($item_1->save() && $item_2->save()){
							$response['status']     = 'ok';
							$response['message']    = 'success';
						}
					}
				}
			}
			//down
			else if ($type == 'down')
			{
				$last = Slide::orderBy('sort', 'desc')->first();

				if ($last && $last->slideid != $slide->slideid)
				{
					$slides = Slide::orderBy('sort', 'asc')->get();
					$item_1	= false;
					$item_2	= false;

					foreach ($slides as $item){
						if ($item->slideid == $slide->slideid){
							$item_1 = $item;
						}
						else if ($item_1 && !$item_2) {
							$item_2 = $item;
						}
					}

					if ($item_1 && $item_2)
					{
						$sort_1	= $item_1->sort;
						$sort_2	= $item_2->sort;

						$item_1->sort = $sort_2;
						$item_2->sort = $sort_1;

						if ($item_1->save() && $item_2->save()){
							$response['status']     = 'ok';
							$response['message']    = 'success';
						}
					}
				}
			}
        }

        return response()->json($response);
    }

	public function ajaxPostDelete(Request $request, $slideid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$slide		= Slide::where('slideid', $slideid)->first();

        if ($slide)
        {
			$response['message'] = trans('error.general');

            if ($slide->delete())
			{
				if (File::isDirectory(public_path("app/slide/{$slideid}"))){
					File::deleteDirectory(public_path("app/slide/{$slideid}"));
				}

				$response['status']     = 'ok';
				$response['message']    = 'success';
			}
        }

        return response()->json($response);
    }

	public function postAdd(Request $request)
    {
		$link		= $request->input('link');
		$imageid	= $request->input('imageid');
		$addto		= $request->input('addto');
		$publish	= $request->input('publish');
        $eMessage	= trans('error.procedure');

		if (
			$imageid && preg_match("/^[0-9]+$/", $imageid) && strlen($imageid) == 16 &&
			$addto && in_array($addto, ['first', 'last']) &&
			$publish && in_array($publish, ['yes', 'no'])
		)
        {
			$imageTemp = public_path("app/slide/temp/{$imageid}.png");

			if (File::exists($imageTemp))
			{
				$eMessage = trans('error.general');

				$sort = 0;

				//sort
				if ($addto == 'last')
				{
					$sortLast = Slide::orderBy('sort', 'desc')->first();

					if ($sortLast){
						$sort = intval($sortLast->sort) + 1;
					}
					else {
						$sort = 1;
					}
				}
				else if ($addto == 'first')
				{
					$sort	= 1;
					$sortc	= 2;
					$sorts	= Slide::orderBy('sort', 'asc')->get();

					if ($sorts->count() > 0){
						foreach ($sorts as $sorti){
							$sorti->sort = $sortc;
							if ($sorti->save()){
								$sortc++;
							}
						}
					}
				}

				//add item
				$slide = new Slide;
				$slide->sort		= $sort;
				$slide->publish		= ($publish == 'yes');

				$link = trim($link);

				if ($link && preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $link))
				{
					$internal = false;

					$originUrl		= parse_url(config('app.url'));
					$originHost		= $originUrl['host'];
					$originDomain	= str_replace('www.', '', $originHost);

					$pointUrl		= parse_url($link);
					$pointHost		= $pointUrl['host'];

					if (preg_match('/'.$originDomain.'/', $pointHost)){
						$internal = true;
					}

					if ($internal){
						$slide->link = isset($pointUrl['path'])? $pointUrl['path']: '';
					}
					else {
						$slide->link = $link;
					}

					$slide->link_set		= true;
					$slide->link_internal	= $internal;
				}
				else {
					$slide->link			= '';
					$slide->link_set		= false;
					$slide->link_internal	= false;
				}

				if ($slide->save())
				{
					$imageDirPath = public_path("app/slide/{$slide->slideid}");

					if (!File::isDirectory($imageDirPath)){
                        File::makeDirectory($imageDirPath);
                    }

					$image = Image::make($imageTemp);
					$image->fit(622, 415);

					if ($image->save("{$imageDirPath}/{$imageid}_t.png", 100))
					{
						$image->destroy();
						$image = Image::make($imageTemp);

						if ($image->save("{$imageDirPath}/{$imageid}.png", 100))
						{
							$slide->imageid = $imageid;

							if ($slide->save())
							{
								File::cleanDirectory(public_path('app/slide/temp'));

								return redirect('dashboard/slides')->with('sMessage', trans('slide.Added a new slide successfully.'));
							}
						}
					}
				}
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
    }

	public function getAdd(Request $request)
    {
        $this->params['request']	= $request;
		$this->params['menu']		= 'slide';

        return view('dashboard.slides.add', $this->params);
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
                $id     = Slide::createId();
                $image  = Image::make($file);

                if ($image->save(public_path("app/slide/temp/{$id}.png"), 100))
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

    public function getIndex(Request $request)
    {
		$items = Slide::orderBy('sort', 'asc')->get();

		$this->params['items']		= $items;
        $this->params['request']	= $request;
		$this->params['menu']		= 'slide';

        return view('dashboard.slides.index', $this->params);
    }
}
