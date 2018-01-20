<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Tour;
use App\TourImage;
use App\Translate;
use App\Tag;
use App\TagMap;
use App\Doc;
use App\Payment;
use App\PaymentMap;
use App\TourExtraVisitor;

class TourController extends Controller {

    public function postDisabled(Request $request, $tourid)
    {
        $tour = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $eMessage = trans('error.general');

            if ($request->has('dates')){
                $dates  = explode(',', $request->input('dates'));
                $date   = json_encode($dates);
                $tour->disabled = $date;
            }
            else {
                $tour->disabled = json_encode([]);
            }

            if ($tour->save()){
                return redirect('dashboard/tours/'.$tour->tourid)->with('sMessage', trans('_.Save changes successfully.'));
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getDisabled(Request $request, $tourid)
    {
        $tour = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $this->params['tour']       = $tour;
            $this->params['request']    = $request;
            $this->params['menu']       = 'tour';

            return view('dashboard.tours.disabled', $this->params);
        }

        return abort(404);
    }

    public function postTerms(Request $request)
    {
        $eMessage   = trans('error.procedure');
        $content    = $request->input('content');
        $doc        = Doc::where('name', 'tour_terms')->first();

        if ($content && $doc)
        {
            foreach ($this->locales as $locale)
            {
                $trans = $doc->getContent($locale['code'], true);
                if ($trans){
                    $trans->text = trim($content[$locale['code']]);
                    $trans->save();
                }
            }

            return redirect("dashboard/tours")->with('sMessage', trans('_.Save changes successfully.'));
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getTerms(Request $request)
    {
        $doc = Doc::where('name', 'tour_terms')->first();

        $this->params['doc']        = $doc;
        $this->params['request']    = $request;
        $this->params['menu']       = 'tour';

        return view('dashboard.tours.terms', $this->params);
    }

    public function ajaxPostImage(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $imageid    = $request->input('imageid');

        if ($imageid && $request->hasFile('file'))
        {
            if (!\File::isDirectory(public_path("app/tour/{$imageid}"))){
                \File::makeDirectory(public_path("app/tour/{$imageid}"));
            }

            $file   = $request->file('file');
            $ext    = $file->getClientOriginalExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $id     = TourImage::createId();
                $image  = \Image::make($file);
                if ($image->save(public_path("app/tour/{$imageid}/{$id}.png"), 100))
                {
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['link']       = "/app/tour/{$imageid}/{$id}.png";
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostDelete(Request $request, $tourid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $tour       = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $response['message'] = trans('error.general');
            $imageid = $tour->imageid;

            $tour->getPayments()->each(function($map){
                $map->delete();
            });

            $tour->getTags()->each(function($map){
                $map->delete();
            });

            $tour->images()->each(function($item){
                $item->delete();
            });

			$tour->extras->each(function($e){
				$e->delete();
			});

            $translates = Translate::where('model', 'tour')
                ->where('model_id', $tour->id)
                ->get()
                ->each(function($item){
                    $item->delete();
                });

            if ($tour->delete())
            {
                if (\File::isDirectory(public_path("app/tour/{$tourid}"))){
                    \File::deleteDirectory(public_path("app/tour/{$tourid}"));
                }
                if (\File::isDirectory(public_path("app/tour/{$imageid}"))){
                    \File::deleteDirectory(public_path("app/tour/{$imageid}"));
                }

                $response['status']     = 'ok';
                $response['message']    = 'success';
            }
        }

        return response()->json($response);
    }

    public function ajaxPostNew(Request $request, $tourid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $tour       = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $tour->new = $set == 'yes'? true: false;
                if ($tour->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostPopular(Request $request, $tourid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $tour       = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $tour->popular = $set == 'yes'? true: false;
                if ($tour->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostRecommend(Request $request, $tourid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $tour       = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $tour->recommend = $set == 'yes'? true: false;
                if ($tour->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostPublish(Request $request, $tourid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $tour       = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $tour->publish = $set == 'yes'? true: false;
                if ($tour->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postEdit(Request $request, $tourid)
    {
        $tour = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $eMessage   = trans('error.procedure');
            $title      = $request->input('title');
            $url        = $request->input('url');
            $code       = $request->input('code');
            $publish    = $request->input('publish');
            $detail     = $request->input('detail');
            $note       = $request->input('note');
            $price_type = $request->input('price_type');
            $keywords   = $request->input('keywords');
            $hightlight = $request->input('hightlight');
            $about_new  = $request->input('about_new');
            $about_popular      = $request->input('about_popular');
            $about_recommend    = $request->input('about_recommend');
            $price_person_adult = $request->input('price_person_adult');
            $price_person_child = $request->input('price_person_child');
            $price_package      = $request->input('price_package');
            $number_package_adult   = $request->input('number_package_adult');
            $number_package_child   = $request->input('number_package_child');
            $map        = $request->input('map');
            $payments   = $request->input('payments');
			$times   	= $request->input('times');
			$extras   	= $request->input('extras');
			$disabled_week   = $request->input('disabled_week');
			$disabled_month   = $request->input('disabled_month');
			$show_child_age   = $request->input('show_child_age');
			$maximum_guests   = $request->input('maximum_guests');

            if ($title && $url && preg_match("/^[a-zA-Z0-9-]+$/", $url) && $publish && in_array($publish, ['yes', 'no']) && $code && $detail && $price_type && in_array($price_type, ['person', 'package', 'free']))
            {
                $exists = Tour::where('url', $url)->first();

                if ($exists && $exists->tourid != $tour->tourid){
                    $eMessage = trans('tour.This url is already exists, please choose another one.');
                }
                else
                {
                    $eMessage = trans('error.general');

                    $valid = true;
                    foreach ($this->locales as $locale){
                        if ($valid)
                        {
                            if (!isset($title[$locale['code']])){
                                $valid = false;
                            }
                            if (!isset($detail[$locale['code']])){
                                $valid = false;
                            }
                        }
                        else {
                            break;
                        }
                    }

                    if ($valid)
                    {
                        $tour->code         = trim($code);
                        $tour->url          = trim($url);
                        $tour->price_type   = $price_type;
                        $tour->publish      = $publish == 'yes'? true: false;
                        $tour->new          = $about_new == 'true'? true: false;
                        $tour->popular      = $about_popular == 'true'? true: false;
                        $tour->recommend    = $about_recommend == 'true'? true: false;
						$tour->show_child_age = $show_child_age == 'yes'? true: false;

						$disabled_days_week = [];
						if ($disabled_week)
						{
							foreach ($disabled_week as $disable){
								if (in_array($disable, ['0', '1', '2', '3', '4', '5', '6'])){
									$disabled_days_week[] = trim($disable);
								}
							}
						}
						$tour->disabled_days_week = json_encode($disabled_days_week);

						$disabled_days_month = [];
						if ($disabled_month)
						{
							foreach ($disabled_month as $disable){
								if (in_array($disable, ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'])){
									$disabled_days_month[] = trim($disable);
								}
							}
						}
						$tour->disabled_days_month = json_encode($disabled_days_month);

						$available_times = [];
						if ($times)
						{
							$times = json_decode($times);
							foreach ($times as $time){
								if (isset($time->start) && isset($time->end)){
									$available_times[] = $time;
								}
							}
						}
						$tour->times = json_encode($available_times);

						$mapData			= trim($map);
						$mapSrc				= getMapSrc($mapData);
						$tour->map_data		= $mapData;

						if ($mapSrc != ''){
							$tour->map_enabled	= true;
							$tour->map_src		= $mapSrc;
						}
						else {
							$tour->map_enabled	= false;
							$tour->map_src		= '';
						}

                        if ($price_type == 'person')
                        {
                            $tour->price_person_adult   = floatval($price_person_adult);
                            $tour->price_person_child   = floatval($price_person_child);
                            $tour->price_package        = 0.0;
                            $tour->number_package_adult = 0;
                            $tour->number_package_child = 0;
							$tour->maximum_guests		= 0;
                        }
                        else if ($price_type == 'package')
                        {
                            $tour->price_person_adult   = 0.0;
                            $tour->price_person_child   = 0.0;
                            $tour->price_package        = floatval($price_package);
                            $tour->number_package_adult = $number_package_adult;
                            $tour->number_package_child = $number_package_child;
							$tour->maximum_guests		= 0;

							if ($extras)
							{
								$extras = json_decode($extras);

								$tour->extras->each(function($e){
									$e->delete();
								});

								foreach ($extras as $extra){
									if (isset($extra->number) && isset($extra->price))
									{
										$et = new TourExtraVisitor;
										$et->tour_id	= $tour->id;
										$et->number		= $extra->number;
										$et->price		= $extra->price;
										$et->save();
									}
								}
							}
                        }
						else if ($price_type == 'free')
                        {
                            $tour->price_person_adult   = 0.0;
                            $tour->price_person_child   = 0.0;
                            $tour->price_package        = 0.0;
                            $tour->number_package_adult = 0;
                            $tour->number_package_child = 0;
							$tour->maximum_guests		= $maximum_guests;
                        }

                        if ($tour->save())
                        {
                            if (!\File::isDirectory(public_path("app/tour/{$tour->tourid}"))){
    							\File::makeDirectory(public_path("app/tour/{$tour->tourid}"));
    						}

                            //payments
                            $tour->getPayments()->each(function($map){
                                $map->delete();
                            });
                            if ($payments)
                            {
                                foreach ($payments as $paymentid){
                                    $payment = Payment::where('paymentid', $paymentid)->first();
                                    if ($payment){
                                        $paymentMap = new PaymentMap;
                                        $paymentMap->payment_id = $payment->id;
                                        $paymentMap->model      = 'tour';
                                        $paymentMap->model_id   = $tour->id;
                                        $paymentMap->save();
                                    }
                                }
                            }

                            //keywords
                            $tour->getTags()->each(function($map){
                                $map->delete();
                            });

                            if ($keywords)
                            {
                                $keyword = explode(',', $keywords);
                                foreach ($keyword as $text)
                                {
                                    $tag = Tag::where('text', trim($text))->first();
                                    if (!$tag){
                                        $tag = new Tag;
                                        $tag->text = trim($text);
                                        $tag->save();
                                    }

                                    if ($tag){
                                        $map = new TagMap;
                                        $map->model     = 'tour';
                                        $map->tag_id    = $tag->id;
                                        $map->model_id  = $tour->id;
                                        $map->save();
                                    }
                                }
                            }

                            //translate
                            foreach ($this->locales as $locale)
                            {
                                $trans = $tour->getTitle($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($title[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'tour';
                                    $trans->model_id    = $tour->id;
                                    $trans->field       = 'title';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($title[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $tour->getDetail($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($detail[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'tour';
                                    $trans->model_id    = $tour->id;
                                    $trans->field       = 'detail';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($detail[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $tour->getNote($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($note[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'tour';
                                    $trans->model_id    = $tour->id;
                                    $trans->field       = 'note';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($note[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $tour->getHighlight($locale['code'], true);
                                if ($trans){
                                    $trans->text = serialize($hightlight[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'tour';
                                    $trans->model_id    = $tour->id;
                                    $trans->field       = 'hightlight';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = serialize($hightlight[$locale['code']]);
                                    $trans->save();
                                }
                            }

                            return redirect("dashboard/tours/{$tour->tourid}")->with('sMessage', trans('_.Save changes successfully.'));
                        }
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $tourid)
    {
        $tour = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $keywords   = '';
            $tags       = [];
            foreach ($tour->getTags() as $map)
            {
                if ($map->tag){
                    $tags[] = $map->tag->text;
                }
            }
            if (count($tags) > 0){
                $keywords = implode(',', $tags);
            }

            $payment_maps = [];
            foreach ($tour->getPayments() as $map)
            {
                if ($map->payment){
                    $payment_maps[] = $map->payment->paymentid;
                }
            }

            $this->params['payment_maps'] = $payment_maps;
            $this->params['payments']     = Payment::where('enabled', '1')->get();
            $this->params['keywords']     = $keywords;
            $this->params['tour']         = $tour;
            $this->params['request']      = $request;
            $this->params['menu']         = 'tour';

            return view('dashboard.tours.edit', $this->params);
        }

        return abort(404);
    }

    public function getItem(Request $request, $tourid)
    {
        $tour = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $keywords   = '-';
            $tags       = [];
            foreach ($tour->getTags() as $map)
            {
                if ($map->tag){
                    $tags[] = $map->tag->text;
                }
            }
            if (count($tags) > 0){
                $keywords = implode(',', $tags);
            }

            $this->params['keywords']   = $keywords;
            $this->params['tour']       = $tour;
            $this->params['request']    = $request;
            $this->params['menu']       = 'tour';

            return view('dashboard.tours.item', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostImageDelete(Request $request, $tourid, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $tour       = Tour::where('tourid', $tourid)->first();
        $id         = $request->input('id');

        if ($tour && $id)
        {
            $image = TourImage::find($id);
            if ($image && $image->imageid == $imageid)
            {
                $response['message'] = trans('error.general');
                $refresh = false;

                if ($image->delete())
                {
                    \File::delete([
                        public_path("app/tour/{$tour->tourid}/{$imageid}.png"),
                        public_path("app/tour/{$tour->tourid}/{$imageid}_t.png")
                    ]);

                    if ($tour->images->count() < 1){
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

    public function ajaxPostImageUpload(Request $request, $tourid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $tour       = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            if ($request->hasFile('image'))
            {
                $response['message'] = trans('error.image');

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
                            $id     = TourImage::createId();
                            $image  = \Image::make($file);
                            if ($image->save(public_path("app/tour/{$tour->tourid}/{$id}.png"), 100))
                            {
                                $image = \Image::make(public_path("app/tour/{$tour->tourid}/{$id}.png"));
								$image->fit(622, 415);

                                if ($image->save(public_path("app/tour/{$tour->tourid}/{$id}_t.png"), 100))
                                {
                                    $img = new TourImage;
                                    $img->imageid     = $id;
                                    $img->tour_id     = $tour->id;

                                    if (!$img->save()){
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
                    $response['message'] = trans('_.Allowed only "jpeg, jpg, gif, png" file extension only.');
                }
            }
        }

        return response()->json($response);
    }

    public function getImage(Request $request, $tourid)
    {
        $tour = Tour::where('tourid', $tourid)->first();

        if ($tour)
        {
            $this->params['tour']       = $tour;
            $this->params['request']    = $request;
            $this->params['menu']       = 'tour';

            return view('dashboard.tours.image', $this->params);
        }

        return abort(404);
    }

    public function postCreate(Request $request)
    {
        $eMessage   = trans('error.procedure');
        $title      = $request->input('title');
        $url        = $request->input('url');
        $code       = $request->input('code');
        $publish    = $request->input('publish');
        $detail     = $request->input('detail');
        $note       = $request->input('note');
        $price_type = $request->input('price_type');
        $keywords   = $request->input('keywords');
        $hightlight = $request->input('hightlight');
        $imageid    = $request->input('imageid');
        $about_new  = $request->input('about_new');
        $about_popular      = $request->input('about_popular');
        $about_recommend    = $request->input('about_recommend');
        $price_person_adult = $request->input('price_person_adult');
        $price_person_child = $request->input('price_person_child');
        $price_package      = $request->input('price_package');
        $number_package_adult   = $request->input('number_package_adult');
        $number_package_child   = $request->input('number_package_child');
        $map        = $request->input('map');
		$payments   = $request->input('payments');
		$times   	= $request->input('times');
		$extras   	= $request->input('extras');
		$disabled_week   = $request->input('disabled_week');
		$disabled_month   = $request->input('disabled_month');
		$show_child_age   = $request->input('show_child_age');
		$maximum_guests   = $request->input('maximum_guests');

        if ($title && $url && preg_match("/^[a-zA-Z0-9-]+$/", $url) && $publish && in_array($publish, ['yes', 'no']) && $code && $detail && $price_type && in_array($price_type, ['person', 'package', 'free']) && $imageid)
        {
            $exists = Tour::where('url', $url)->first();

            if ($exists){
                $eMessage = trans('tour.This url is already exists, please choose another one.');
            }
            else
            {
                $eMessage = trans('error.general');

                $valid = true;
                foreach ($this->locales as $locale){
                    if ($valid)
                    {
                        if (!isset($title[$locale['code']])){
                            $valid = false;
                        }
                        if (!isset($detail[$locale['code']])){
                            $valid = false;
                        }
                    }
                    else {
                        break;
                    }
                }

                if ($valid)
                {
                    $tour = new Tour;
                    $tour->code         = trim($code);
                    $tour->url          = trim($url);
                    $tour->price_type   = $price_type;
                    $tour->publish      = $publish == 'yes'? true: false;
                    $tour->new          = $about_new == 'true'? true: false;
                    $tour->popular      = $about_popular == 'true'? true: false;
                    $tour->recommend    = $about_recommend == 'true'? true: false;
                    $tour->imageid      = $imageid;
                    $tour->views        = 0;
                    $tour->disabled     = json_encode([]);
					$tour->show_child_age = $show_child_age == 'yes'? true: false;

					$disabled_days_week = [];
					if ($disabled_week)
					{
						foreach ($disabled_week as $disable){
							if (in_array($disable, ['0', '1', '2', '3', '4', '5', '6'])){
								$disabled_days_week[] = trim($disable);
							}
						}
					}
					$tour->disabled_days_week = json_encode($disabled_days_week);

					$disabled_days_month = [];
					if ($disabled_month)
					{
						foreach ($disabled_month as $disable){
							if (in_array($disable, ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'])){
								$disabled_days_month[] = trim($disable);
							}
						}
					}
					$tour->disabled_days_month = json_encode($disabled_days_month);

					$available_times = [];
					if ($times)
					{
						$times = json_decode($times);
						foreach ($times as $time){
							if (isset($time->start) && isset($time->end)){
								$available_times[] = $time;
							}
						}
					}
					$tour->times = json_encode($available_times);

					$mapData			= trim($map);
					$mapSrc				= getMapSrc($mapData);
					$tour->map_data		= $mapData;

					if ($mapSrc != ''){
						$tour->map_enabled	= true;
						$tour->map_src		= $mapSrc;
					}
					else {
						$tour->map_enabled	= false;
						$tour->map_src		= '';
					}

                    if ($price_type == 'person')
                    {
                        $tour->price_person_adult   = floatval($price_person_adult);
                        $tour->price_person_child   = floatval($price_person_child);
                        $tour->price_package        = 0.0;
                        $tour->number_package_adult = 0;
                        $tour->number_package_child = 0;
						$tour->maximum_guests		= 0;
                    }
                    else if ($price_type == 'package')
                    {
                        $tour->price_person_adult   = 0.0;
                        $tour->price_person_child   = 0.0;
                        $tour->price_package        = floatval($price_package);
                        $tour->number_package_adult = $number_package_adult;
                        $tour->number_package_child = $number_package_child;
						$tour->maximum_guests		= 0;
                    }
					else if ($price_type == 'free')
					{
						$tour->price_person_adult   = 0.0;
						$tour->price_person_child   = 0.0;
						$tour->price_package        = 0.0;
						$tour->number_package_adult = 0;
						$tour->number_package_child = 0;
						$tour->maximum_guests		= $maximum_guests;
					}

                    if ($tour->save())
                    {
                        if (!\File::isDirectory(public_path("app/tour/{$tour->tourid}"))){
							\File::makeDirectory(public_path("app/tour/{$tour->tourid}"));
						}

						if ($price_type == 'package')
	                    {
							if ($extras)
							{
								$extras = json_decode($extras);

								$tour->extras->each(function($e){
									$e->delete();
								});

								foreach ($extras as $extra){
									if (isset($extra->number) && isset($extra->price))
									{
										$et = new TourExtraVisitor;
										$et->tour_id	= $tour->id;
										$et->number		= $extra->number;
										$et->price		= $extra->price;
										$et->save();
									}
								}
							}
	                    }

                        //payments
                        if ($payments)
                        {
                            foreach ($payments as $paymentid){
                                $payment = Payment::where('paymentid', $paymentid)->first();
                                if ($payment){
                                    $paymentMap = new PaymentMap;
                                    $paymentMap->payment_id = $payment->id;
                                    $paymentMap->model      = 'tour';
                                    $paymentMap->model_id   = $tour->id;
                                    $paymentMap->save();
                                }
                            }
                        }

                        //keywords
                        if ($keywords)
                        {
                            $keyword = explode(',', $keywords);
                            foreach ($keyword as $text)
                            {
                                $tag = Tag::where('text', trim($text))->first();
                                if (!$tag){
                                    $tag = new Tag;
                                    $tag->text = trim($text);
                                    $tag->save();
                                }

                                if ($tag){
                                    $map = new TagMap;
                                    $map->model     = 'tour';
                                    $map->tag_id    = $tag->id;
                                    $map->model_id  = $tour->id;
                                    $map->save();
                                }
                            }
                        }

                        //translate
                        foreach ($this->locales as $locale)
                        {
                            $trans = new Translate;
                            $trans->model       = 'tour';
                            $trans->model_id    = $tour->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'tour';
                            $trans->model_id    = $tour->id;
                            $trans->field       = 'detail';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($detail[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'tour';
                            $trans->model_id    = $tour->id;
                            $trans->field       = 'note';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($note[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'tour';
                            $trans->model_id    = $tour->id;
                            $trans->field       = 'hightlight';
                            $trans->locale      = $locale['code'];
                            $trans->text        = serialize($hightlight[$locale['code']]);
                            $trans->save();
                        }

                        return redirect("dashboard/tours/{$tour->tourid}/images")->with('sMessage', trans('tour.Create a new tour package successfully.'));
                    }
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getCreate(Request $request)
    {
        $imageid = TourImage::createId();

        $this->params['payments']   = Payment::where('enabled', '1')->get();
        $this->params['imageid']    = $imageid;
        $this->params['request']    = $request;
        $this->params['menu']       = 'tour';

        return view('dashboard.tours.create', $this->params);
    }

    public function getIndex(Request $request)
    {
        $items = Tour::orderBy('code', 'asc')->paginate(25);

		$this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'tour';

        return view('dashboard.tours.index', $this->params);
    }
}
