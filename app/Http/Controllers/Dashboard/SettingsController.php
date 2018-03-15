<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Config;
use App\Gallery;
use File;
use Image;

class SettingsController extends Controller {

	public function ajaxPostFbImage(Request $request)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		if ($request->hasFile('file'))
		{
			$file	= $request->file('file');
			$ext	= $file->getClientOriginalExtension();

			if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
			{
				$temp = tempFile($file);

				if ($temp)
				{
					$response['status']     = 'ok';
					$response['message']    = 'success';
					$response['payload']['image'] = $temp;
				}
			}
			else {
				$response['message'] = trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.');
			}
		}

		return response()->json($response);
	}

	public function ajaxPostUpdate(Request $request)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$property	= $request->input('property');
		$value		= $request->input('value');

		if ($property)
		{
			//sitename
			if ($property == 'sitename' && $value && trim($value) != '')
			{
				$config = \App\Config::where('property', 'name')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
            //description
			else if ($property == 'description' && $value && trim($value) != '')
			{
				$config = \App\Config::where('property', 'description')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//home title
			else if ($property == 'home_title' && $value && trim($value) != '')
			{
				$config = \App\Config::where('property', 'home_title')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
            //keywords
			else if ($property == 'keywords' && $value)
			{
				$config	= \App\Config::where('property', 'keywords')->first();
				$data	= [];

                $keywords = explode(',', $value);

                foreach ($keywords as $keyword)
				{
					$item = trim($keyword);

					if ($item != ''){
						$data[] = $item;
					}
                }

                $config->value = json_encode($data);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//copyright
			else if ($property == 'copyright' && $value && trim($value) != '')
			{
				$config = \App\Config::where('property', 'copyright')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//phone number
			else if ($property == 'phone' && $value)
			{
				$config	= \App\Config::where('property', 'contact_phone')->first();
				$data	= [];

				foreach ($value as $item)
				{
                    $entry	= [];
					$phones	= explode(',', $item['data']);

					foreach ($phones as $phone)
					{
						$node = trim($phone);

						if ($node != ''){
							$entry[] = $node;
						}
					}

					$data[$item['locale']] = $entry;
                }

                $config->value = json_encode($data);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//fax
			else if ($property == 'fax' && $value)
			{
				$config	= \App\Config::where('property', 'contact_fax')->first();
				$data	= [];

				foreach ($value as $item)
				{
                    $entry	= [];
					$faxes	= explode(',', $item['data']);

					foreach ($faxes as $fax)
					{
						$node = trim($fax);

						if ($node != ''){
							$entry[] = $node;
						}
					}

					$data[$item['locale']] = $entry;
                }

                $config->value = json_encode($data);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//email address
			else if ($property == 'email')
			{
                $config	= \App\Config::where('property', 'contact_email')->first();
				$data	= [];

                $emails = explode(',', $value);

                foreach ($emails as $email)
				{
					$item = trim($email);

					if ($item != ''){
						$data[] = $item;
					}
                }

                $config->value = json_encode($data);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//default lang
			else if ($property == 'defaultlang' && $value)
			{
				$locales = [];

				foreach ($this->config['langs'] as $locale)
				{
					$locales[] = $locale['code'];
				}

				if (in_array($value, $locales))
				{
					$config = \App\Config::where('property', 'default_locale')->first();

					$config->value = strtolower($value);

					if ($config->save())
					{
						$response['status']		= 'ok';
						$response['message']	= 'success';
					}
				}
			}
            //address
			else if ($property == 'address')
			{
				$config = \App\Config::where('property', 'contact_address')->first();
				$data	= [];

				foreach ($value as $item)
				{
					$data[$item['locale']] = trim($item['data']);
				}

				$config->value = json_encode($data);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
            //opening hours
			else if ($property == 'opening')
			{
				$config = \App\Config::where('property', 'opening_hours')->first();
				$data	= [];
				foreach ($value as $item)
				{
					$data[$item['locale']] = trim($item['data']);
				}

				$config->value = json_encode($data);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
            //map
			else if ($property == 'map')
			{
				$config = \App\Config::where('property', 'map')->first();
				$data	= [];

				foreach ($value as $item)
				{
					$data[$item['locale']] = trim($item['data']);
				}

				$config->value = $config->value = json_encode($data);($data);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//facebook
			else if ($property == 'facebook')
			{
				$config = \App\Config::where('property', 'social_facebook')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//twitter
			else if ($property == 'twitter')
			{
				$config = \App\Config::where('property', 'social_twitter')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//instagram
			else if ($property == 'instagram')
			{
				$config = \App\Config::where('property', 'social_instagram')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//pinterest
			else if ($property == 'pinterest')
			{
				$config = \App\Config::where('property', 'social_pinterest')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//googleplus
			else if ($property == 'googleplus')
			{
				$config = \App\Config::where('property', 'social_googleplus')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//youtube
			else if ($property == 'youtube')
			{
				$config = \App\Config::where('property', 'social_youtube')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//line
			else if ($property == 'line')
			{
				$config = \App\Config::where('property', 'social_line')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//viber
			else if ($property == 'viber')
			{
				$config = \App\Config::where('property', 'social_viber')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}

			//Wechat
			else if ($property == 'wechat')
			{
				$config = \App\Config::where('property', 'social_wechat')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//whatapp
			else if ($property == 'whatapp')
			{
				$config = \App\Config::where('property', 'social_whatapp')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}

			//facebook app id
			else if ($property == 'fb_appid' && $value && trim($value) != '')
			{
				$config = \App\Config::where('property', 'fb_appid')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//facebook title
			else if ($property == 'fb_title' && $value && trim($value) != '')
			{
				$config = \App\Config::where('property', 'fb_title')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//facebook description
			else if ($property == 'fb_description' && $value && trim($value) != '')
			{
				$config = \App\Config::where('property', 'fb_description')->first();

				$config->value = trim($value);

				if ($config->save())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
			//facebook image
			else if ($property == 'fb_image' && $value)
			{
				if ( isset($value['name']) && isset($value['ext']) && isset($value['file']) && File::exists( public_path($value['file']) ))
				{
					$id     = Gallery::createId();
					$image	= Image::make( public_path($value['file']) );

					if ($image->save(public_path("app/fbimage/{$id}.png"), 100))
					{
						$config = \App\Config::where('property', 'fb_image')->first();

						$config->value = $id;

						if ($config->save())
						{
							clearTempFiles();

							$response['status']		= 'ok';
							$response['message']	= 'success';
							$response['payload']['id'] = $id;
						}
					}
				}
			}
		}

		return response()->json($response);
	}

	public function getIndex()
	{
        $opening_hours	= Config::where('property', 'opening_hours')->first()->value;
        $map			= Config::where('property', 'map')->first()->value;
		$address		= Config::where('property', 'contact_address')->first()->value;
		$home_title		= Config::where('property', 'home_title')->first()->value;
		$fb_appid		= Config::where('property', 'fb_appid')->first()->value;
		$fb_title		= Config::where('property', 'fb_title')->first()->value;
		$fb_description	= Config::where('property', 'fb_description')->first()->value;
		$fb_image		= Config::where('property', 'fb_image')->first()->value;
		$line			= Config::where('property', 'social_line')->first()->value;

        $this->params['opening_hours']	= $opening_hours;
        $this->params['map']			= json_decode($map);
		$this->params['address']		= json_decode($address);
		$this->params['home_title']		= $home_title;
		$this->params['fb_appid']		= $fb_appid;
		$this->params['fb_title']		= $fb_title;
		$this->params['fb_description']	= $fb_description;
		$this->params['fb_image']		= $fb_image;
		$this->params['menu']			= 'setting';

		return view('dashboard.settings.index', $this->params);
	}
}
