<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscribe;
use NewsletterLaravel;

class SubscribeController extends Controller {

    public function ajaxPostAdd(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $email      = trim($request->input('email'));

        if ($email && filter_var($email, FILTER_VALIDATE_EMAIL))
        {
			$response['message'] = trans('error.general');

			$hasMember = NewsletterLaravel::hasMember($email);

			if ($hasMember)
			{
				$member = NewsletterLaravel::getMember($email);

				if (isset($member['status']))
				{
					if ($member['status'] == 'subscribed')
					{
						$response['status']     = 'ok';
		                $response['message']    = 'success';
					}
					else if ($member['status'] == 'unsubscribed')
					{
						NewsletterLaravel::delete($email);

						$subscribe = NewsletterLaravel::subscribe($email);

						if ( $subscribe && isset($subscribe['status']) && $subscribe['status'] == 'subscribed' ){
							$response['status']     = 'ok';
			                $response['message']    = 'success';
						}
					}
				}
			}
			else
			{
				$subscribe = NewsletterLaravel::subscribe($email);

				if ( $subscribe && isset($subscribe['status']) && $subscribe['status'] == 'subscribed' ){
					$response['status']     = 'ok';
	                $response['message']    = 'success';
				}
			}
        }

        return response()->json($response);
    }
}
