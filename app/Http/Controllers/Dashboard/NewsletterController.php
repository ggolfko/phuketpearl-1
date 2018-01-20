<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Newsletter;
use App\NewsletterImage;
use App\NewsletterDraft;
use App\Subscribe;
use App\User;
use Mail;
use File;
use Image;
use NewsletterLaravel;
use stdClass;

class NewsletterController extends Controller {

	public function ajaxGetSubscribers(Request $request)
    {
        $response	= ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$api			= NewsletterLaravel::getApi();
		$config_lists	= config('laravel-newsletter.lists');
		$list_id		= $config_lists[config('laravel-newsletter.defaultListName')]['id'];
		$all_lists		= $api->get("lists");
		$lists			= $all_lists['lists'];
		$list			= null;

		foreach ($lists as $list_){
			if ($list_['id'] == $list_id){
				$list = $list_;
			}
		}

		if ($list)
		{
			$response['status']     = 'ok';
			$response['message']    = 'success';
			$response['payload']['members'] = intval($list['stats']['member_count']);
		}

        return response()->json($response);
    }

    public function ajaxGetSent(Request $request, $letterid)
    {
        $letter = Newsletter::where('letterid', $letterid)->first();

        if ($letter)
        {
			$this->params['address'] = isset($this->config['addresses']->en)? $this->config['addresses']->en: '';

			$phones = [];

			foreach ($this->config['phones'] as $phone)
			{
				foreach ($phone as $number){
					$phones[] = $number;
				}
			}

			$this->params['phones']	= $phones;
            $this->params['letter']	= $letter;
            $this->params['draft']	= $letter->draft;

            return view('dashboard.newsletter.item_sent', $this->params);
        }

        return abort(404);
    }

    public function getItem(Request $request, $letterid)
    {
        $letter = Newsletter::where('letterid', $letterid)->first();

        if ($letter)
        {
            $this->params['letter']		= $letter;
    		$this->params['request']	= $request;
            $this->params['menu']       = 'newsletter';

            return view('dashboard.newsletter.item', $this->params);
        }

        return abort(404);
    }

	public function ajaxGetStatus(Request $request, $letterid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$letter		= Newsletter::where('letterid', $letterid)->first();

        if ($letter && $letter->letterid == $letterid)
		{
			$api	= NewsletterLaravel::getApi();
			$data	= $api->get("campaigns/{$letter->campaign_id}");

			if ($data['status'] == 'sent')
			{
				$letter->deliver_time	= $data['send_time'];
				$letter->emails_sent	= $data['emails_sent'];
				$letter->status			= 'sent';

				if ($letter->save()){
					$response['status']     = 'ok';
					$response['message']    = 'success';
					$response['payload']	= [
						'deliver_time'	=> $letter->deliver_time,
						'emails_sent'	=> $letter->emails_sent,
						'status'		=> $letter->status
					];
				}
			}
		}

        return response()->json($response);
    }

    public function ajaxDelete(Request $request, $letterid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $letter = Newsletter::find($id);

            if ($letter && $letter->letterid == $letterid)
            {
                if ($letter->draft)
                {
                    $draftid		= $letter->draft->draftid;
					$campaign_id	= $letter->campaign_id;

                    if ($letter->draft->delete() && $letter->delete())
					{
                        if (File::isDirectory(public_path("app/newsletter/draft/{$draftid}"))){
                            File::deleteDirectory(public_path("app/newsletter/draft/{$draftid}"));
                        }

						if ($campaign_id != ''){
							$api = NewsletterLaravel::getApi();
							$api->delete("campaigns/{$letter->campaign_id}");
						}

                        $response['status']     = 'ok';
                        $response['message']    = 'success';
                    }
                }
            }
        }

        return response()->json($response);
    }

	public function ajaxPostDeliver(Request $request, $letterid)
    {
		$response		= ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$letter			= Newsletter::where('letterid', $letterid)->first();
		$campaign_id	= $request->input('campaign_id');

		if ($letter && $letter->status == 'save' && $letter->campaign_id != '' && $campaign_id && $campaign_id == $letter->campaign_id)
		{
			$response['message'] = trans('error.general');

			$api = NewsletterLaravel::getApi();

			$api->post("campaigns/{$letter->campaign_id}/actions/send");

			$data = $api->get("campaigns/{$letter->campaign_id}");

			if ($data['status'] == 'sent' || $data['status'] == 'sending')
			{
				$letter->deliver_time	= $data['send_time'];
				$letter->emails_sent	= $data['emails_sent'];
				$letter->status			= $data['status'];

				if ($letter->save()){
					$response['status']     = 'ok';
					$response['message']    = 'success';
				}
			}
		}

		return response()->json($response);
	}

	public function ajaxPostCampaign(Request $request, $letterid)
    {
		$response	= ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
		$letter		= Newsletter::where('letterid', $letterid)->first();

		if ($letter && $letter->status == 'draft' && $letter->campaign_id == '')
		{
			$response['message'] = trans('error.general');

			$this->params['address'] = isset($this->config['addresses']->en)? $this->config['addresses']->en: '';

			$phones = [];

			foreach ($this->config['phones'] as $phone)
			{
				foreach ($phone as $number){
					$phones[] = $number;
				}
			}

			$this->params['phones']	= $phones;
			$this->params['letter']	= $letter;
			$this->params['draft']	= $letter->draft;

			$view	= \View::make('dashboard.newsletter.newsletter', $this->params)->render();
			$create	= NewsletterLaravel::createCampaign(
				$this->config['name'],
				config('app.email'),
				$letter->subject,
				$view,
				'',
				['auto_footer' => false]
			);

			if ($create)
			{
				$letter->campaign_id	= $create['id'];
				$letter->status			= 'save';

				if ($letter->save()){
					$response['status']     = 'ok';
					$response['message']    = 'success';
					$response['payload']['campaign_id'] = $letter->campaign_id;
				}
			}
		}

		return response()->json($response);
	}

    public function ajaxPostSend(Request $request)
    {
        $response	= ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $subject	= trim($request->input('subject'));
        $blocks		= $request->input('blocks');
        $images		= $request->input('images');
        $buttons	= $request->input('buttons');
        $text		= $request->input('text');

        if ($subject)
        {
            if (
                ($request->has('blocks') && isset($blocks['section1']) && isset($blocks['section2']) && isset($blocks['section3']) && isset($blocks['section4']) && isset($blocks['section5']) && isset($blocks['section6']) && isset($blocks['section7']) && isset($blocks['section8']) && isset($blocks['section9'])) &&
                ($request->has('images') && isset($images['section1']) && isset($images['section1'][0]) && isset($images['section2']) && isset($images['section2'][0]) && isset($images['section4']) && isset($images['section4'][0]) && isset($images['section5']) && isset($images['section5'][0]) && isset($images['section5'][1]) && isset($images['section6']) && isset($images['section6'][0]) && isset($images['section6'][1]) && isset($images['section6'][2]) && isset($images['section7']) && isset($images['section7'][0]) && isset($images['section8']) && isset($images['section8'][0])) &&
                ($request->has('buttons') && isset($buttons['section3']) && isset($buttons['section3'][0]) && isset($buttons['section3'][0]['text']) && isset($buttons['section3'][0]['link']) && isset($buttons['section7']) && isset($buttons['section7'][0]) && isset($buttons['section7'][0]['text']) && isset($buttons['section7'][0]['link']) && isset($buttons['section8']) && isset($buttons['section8'][0]) && isset($buttons['section8'][0]['text']) && isset($buttons['section8'][0]['link'])) &&
                ($request->has('text') && isset($text['section3']) && isset($text['section3'][0]) && isset($text['section4']) && isset($text['section4'][0]) && isset($text['section5']) && isset($text['section5'][0]) && isset($text['section5'][1]) && isset($text['section6']) && isset($text['section6'][0]) && isset($text['section6'][1]) && isset($text['section6'][2]) && isset($text['section7']) && isset($text['section7'][0]) && isset($text['section7'][1]) && isset($text['section8']) && isset($text['section8'][0]) && isset($text['section8'][1]))
            )
            {
                $response['message'] = trans('error.general');

                $draft = new NewsletterDraft;
                $draft->blocks_section1 = $blocks['section1']? true: false;
                $draft->blocks_section2 = $blocks['section2']? true: false;
                $draft->blocks_section3 = $blocks['section3']? true: false;
                $draft->blocks_section4 = $blocks['section4']? true: false;
                $draft->blocks_section5 = $blocks['section5']? true: false;
                $draft->blocks_section6 = $blocks['section6']? true: false;
                $draft->blocks_section7 = $blocks['section7']? true: false;
                $draft->blocks_section8 = $blocks['section8']? true: false;
                $draft->blocks_section9 = $blocks['section9']? true: false;
                $draft->images_section1_0   = '';
                $draft->images_section2_0   = '';
                $draft->images_section4_0   = '';
                $draft->images_section5_0   = '';
                $draft->images_section5_1   = '';
                $draft->images_section6_0   = '';
                $draft->images_section6_1   = '';
                $draft->images_section6_2   = '';
                $draft->images_section7_0   = '';
                $draft->images_section8_0   = '';
                $draft->buttons_section3_0_text =   $buttons['section3'][0]['text']? $buttons['section3'][0]['text']: 'A Button';
                $draft->buttons_section3_0_link =   $buttons['section3'][0]['link']? $buttons['section3'][0]['link']: '';
                $draft->buttons_section7_0_text =   $buttons['section7'][0]['text']? $buttons['section7'][0]['text']: 'A Button';
                $draft->buttons_section7_0_link =   $buttons['section7'][0]['link']? $buttons['section7'][0]['link']: '';
                $draft->buttons_section8_0_text =   $buttons['section8'][0]['text']? $buttons['section8'][0]['text']: 'A Button';
                $draft->buttons_section8_0_link =   $buttons['section8'][0]['link']? $buttons['section8'][0]['link']: '';
                $draft->text_section3_0 = $text['section3'][0]? $text['section3'][0]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut erat.';
                $draft->text_section4_0 = $text['section4'][0]? $text['section4'][0]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent laoreet malesuada cursus. Maecenas scelerisque congue eros eu posuere. Praesent in felis ut velit pretium lobortis rhoncus ut erat.';
                $draft->text_section5_0 = $text['section5'][0]? $text['section5'][0]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
                $draft->text_section5_1 = $text['section5'][1]? $text['section5'][1]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
                $draft->text_section6_0 = $text['section6'][0]? $text['section6'][0]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
                $draft->text_section6_1 = $text['section6'][1]? $text['section6'][1]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
                $draft->text_section6_2 = $text['section6'][2]? $text['section6'][2]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
                $draft->text_section7_0 = $text['section7'][0]? $text['section7'][0]: 'Class aptent taciti sociosqu';
                $draft->text_section7_1 = $text['section7'][1]? $text['section7'][1]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';
                $draft->text_section8_0 = $text['section8'][0]? $text['section8'][0]: 'Class aptent taciti sociosqu';
                $draft->text_section8_1 = $text['section8'][1]? $text['section8'][1]: 'Maecenas sed ante pellentesque, posuere leo id, eleifend dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.';

                if ($draft->save())
                {
                    if (!File::isDirectory(public_path("app/newsletter/draft/{$draft->draftid}"))){
                        File::makeDirectory(public_path("app/newsletter/draft/{$draft->draftid}"));
                    }

                    // start: generate images
                    if ($images['section1'][0]){
                        if (File::exists(public_path("app/newsletter/{$images['section1'][0]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section1'][0]}.png"));
                            $image->resize(140, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.png"), 100)){
                                $draft->images_section1_0 = $id;
                            }
                        }
                    }
                    if ($images['section2'][0]){
                        if (File::exists(public_path("app/newsletter/{$images['section2'][0]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section2'][0]}.png"));
                            $image->resize(598, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section2_0 = $id;
                            }
                        }
                    }
                    if ($images['section4'][0]){
                        if (File::exists(public_path("app/newsletter/{$images['section4'][0]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section4'][0]}.png"));
                            $image->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section4_0 = $id;
                            }
                        }
                    }
                    if ($images['section5'][0]){
                        if (File::exists(public_path("app/newsletter/{$images['section5'][0]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section5'][0]}.png"));
                            $image->resize(270, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section5_0 = $id;
                            }
                        }
                    }
                    if ($images['section5'][1]){
                        if (File::exists(public_path("app/newsletter/{$images['section5'][1]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section5'][1]}.png"));
                            $image->resize(270, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section5_1 = $id;
                            }
                        }
                    }
                    if ($images['section6'][0]){
                        if (File::exists(public_path("app/newsletter/{$images['section6'][0]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section6'][0]}.png"));
                            $image->resize(170, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section6_0 = $id;
                            }
                        }
                    }
                    if ($images['section6'][1]){
                        if (File::exists(public_path("app/newsletter/{$images['section6'][1]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section6'][1]}.png"));
                            $image->resize(170, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section6_1 = $id;
                            }
                        }
                    }
                    if ($images['section6'][2]){
                        if (File::exists(public_path("app/newsletter/{$images['section6'][2]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section6'][2]}.png"));
                            $image->resize(170, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section6_2 = $id;
                            }
                        }
                    }
                    if ($images['section7'][0]){
                        if (File::exists(public_path("app/newsletter/{$images['section7'][0]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section7'][0]}.png"));
                            $image->resize(170, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section7_0 = $id;
                            }
                        }
                    }
                    if ($images['section8'][0]){
                        if (File::exists(public_path("app/newsletter/{$images['section8'][0]}.png"))){
                            $image = Image::make(public_path("app/newsletter/{$images['section8'][0]}.png"));
                            $image->resize(170, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $id = NewsletterImage::createId();
                            if ($image->save(public_path("app/newsletter/draft/{$draft->draftid}/{$id}.jpg"), 100)){
                                $draft->images_section8_0 = $id;
                            }
                        }
                    }
                    // end: generate images

                    if ($draft->save())
                    {
                        $letter = new Newsletter;
                        $letter->draft_id   	= $draft->id;
                        $letter->subject    	= $subject;
						$letter->campaign_id	= '';
						$letter->deliver_time	= '';
						$letter->emails_sent	= 0;
						$letter->status			= 'draft';


                        if ($letter->save())
                        {
							$response['status']     = 'ok';
							$response['message']    = 'success';
							$response['payload']['_id'] = $letter->letterid;
                        }
                    }
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxGetPreview(Request $request)
    {
		$this->params['address'] = isset($this->config['addresses']->en)? $this->config['addresses']->en: '';

		$phones = [];

		foreach ($this->config['phones'] as $phone)
		{
			foreach ($phone as $number){
				$phones[] = $number;
			}
		}

		$this->params['phones'] = $phones;

        return view('dashboard.newsletter.preview', $this->params);
    }

    public function ajaxGetImagesId(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];
        $images     = NewsletterImage::orderBy('created_at', 'desc')->get();
        $items      = [];

        foreach ($images as $image)
        {
            $items[] = $image->imageid;
        }

        $response['status']     = 'ok';
        $response['message']    = 'success';
        $response['payload']['items'] = $items;

        return response()->json($response);
    }

    public function ajaxPostImageDelete(Request $request, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $image      = NewsletterImage::where('imageid', $imageid)->first();

        if ($image)
        {
            $response['message'] = trans('error.general');

            if ($image->delete())
            {
                \File::delete([
                    public_path("app/newsletter/{$imageid}.png"),
                    public_path("app/newsletter/{$imageid}_t.png")
                ]);

                $response['status']     = 'ok';
                $response['message']    = 'success';
            }
        }

        return response()->json($response);
    }

    public function ajaxPostImages(Request $request)
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
                        $id     = NewsletterImage::createId();
                        $image  = \Image::make($file);
                        $name   = $file->getClientOriginalName();

                        if ($image->save(public_path("app/newsletter/{$id}.png"), 100))
                        {
                            $image = \Image::make(public_path("app/newsletter/{$id}.png"));
                            $image->fit(102, 102);

                            if ($image->save(public_path("app/newsletter/{$id}_t.png"), 100))
                            {
                                $image = new NewsletterImage;
                                $image->imageid	= $id;
                                $image->name	= $name;

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

    public function ajaxGetImages(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];
        $images     = NewsletterImage::orderBy('created_at', 'desc')->get();
        $items      = [];

        foreach ($images as $image)
        {
            $item = [
                'id'        => $image->id,
                'imageid'   => $image->imageid,
                'name'      => $image->name
            ];
            $items[] = $item;
        }

        $response['status']     = 'ok';
        $response['message']    = 'success';
        $response['payload']['items'] = $items;

        return response()->json($response);
    }

    public function ajaxGetBuilder(Request $request)
    {
		$this->params['address'] = isset($this->config['addresses']->en)? $this->config['addresses']->en: '';

		$phones = [];

		foreach ($this->config['phones'] as $phone)
		{
			foreach ($phone as $number){
				$phones[] = $number;
			}
		}

		$this->params['phones'] = $phones;

        return view('dashboard.newsletter.builder', $this->params);
    }

    public function getCompose(Request $request)
    {
        $this->params['request']	    = $request;
        $this->params['menu']           = 'newsletter';

        return view('dashboard.newsletter.compose', $this->params);
    }

    public function ajaxPostSubscriberDelete(Request $request)
    {
        $response	= ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $email		= $request->input('email');

		if ($email && filter_var($email, FILTER_VALIDATE_EMAIL))
        {
			$response['message'] = trans('error.general');

			NewsletterLaravel::delete($email);

			$response['status']     = 'ok';
			$response['message']    = 'success';
        }

        return response()->json($response);
    }

    public function getSubscriber(Request $request)
    {
		$api			= NewsletterLaravel::getApi();
		$config_lists	= config('laravel-newsletter.lists');
		$list_id		= $config_lists[config('laravel-newsletter.defaultListName')]['id'];
		$all_lists		= $api->get("lists");
		$lists			= $all_lists['lists'];
		$list			= null;

		foreach ($lists as $list_){
			if ($list_['id'] == $list_id){
				$list = $list_;
			}
		}

		if ($list)
		{
			$page	= intval($request->input('page'));
			$items	= new stdClass;

			$items->total		= intval($list['stats']['member_count']);
			$items->perPage		= 100;
			$items->allPage		= ceil($items->total/$items->perPage);
			$items->currentPage	= ($page > 0 && $page <= $items->allPage)? $page: 1;
			$items->offset		= ($items->currentPage - 1) * $items->perPage;

			$list				= $api->get("lists/{$list_id}/members?status=subscribed&offset={$items->offset}&count={$items->perPage}");
			$members			= $list['members'];

			$items->count		= count($members);

			$this->params['members']		= $members;
			$this->params['items']			= $items;
			$this->params['request']		= $request;
	        $this->params['menu']       	= 'newsletter';

	        return view('dashboard.newsletter.subscriber', $this->params);
		}

		return abort(500);
    }

    public function getIndex(Request $request)
    {
        $q = trim($request->input('q', ''));

        if ($q == '')
        {
            $items = Newsletter::orderBy('created_at', 'desc')->paginate(25);
        }
        else
        {
            $items = Newsletter::where(function($query) use ($q){
                $query->where('letterid', 'like', "%$q%")
                    ->orWhere('subject', 'like', "%$q%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(25);

            $items->appends(array('q' => $q));
        }

        $this->params['q']			= $q;
		$this->params['items']		= $items;
		$this->params['request']	= $request;
        $this->params['menu']       = 'newsletter';

        return view('dashboard.newsletter.index', $this->params);
    }
}
