<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller {

	public function postLang(Request $request)
	{
		$response = ['ststus' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$code = $request->input('code');
		if ($code && isset($this->config['langs'][$code]))
		{
			if ($this->auth->check()){
				$this->user->locale = $this->config['langs'][$code]['code'];
				if ($this->user->save())
				{
					$response['status'] 	= 'ok';
					$response['message']	= 'success';
				}
			}
			else
			{
				$response['status'] = 'ok';
				return response()->json($response)->withCookie(cookie('lang', $this->config['langs'][$code]['code'], 86400));
			}
		}

		return response()->json($response);
	}
}
