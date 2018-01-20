<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tour;
use Mail;
use DB;

class ContactController extends Controller {

    public function ajaxPostCreate(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        $firstname  = $request->input('firstname');
        $lastname   = $request->input('lastname');
        $email      = $request->input('email');
        $phone      = $request->input('phone');
        $topic      = $request->input('topic');
        $message    = $request->input('message');

        if (
            $firstname && trim($firstname) != '' &&
            $lastname && trim($lastname) != '' &&
            $email && trim($email) != '' && filter_var($email, FILTER_VALIDATE_EMAIL) &&
            $phone && trim($phone) != '' &&
            $topic && trim($topic) != '' &&
            $message && trim($message) != ''
        )
        {
			$data = [
				'topic'		=> $topic,
				'text'		=> $message,
				'firstname'	=> $firstname,
				'lastname'	=> $lastname,
				'email'		=> $email,
				'phone'		=> $phone
			];

			$subject = $this->config['name'] . ' - Contact message';

			$sent = Mail::send('emails.contact', $data, function($mail) use ($data, $subject){
				$mail->from($data['email'], "{$data['firstname']} {$data['lastname']}");
				$mail->to(config('app.email'));
				$mail->subject($subject);
			});

			if ($sent)
			{
				$response['status']     = 'ok';
				$response['message']    = 'success';
			}
        }

        return response()->json($response);
    }

    public function getIndex(Request $request)
    {
        $this->params['title']      = trans('_.Contact us').' - '.$this->config['name'];
        $this->params['menu']       = 'working';
        $this->params['submenu']    = 'contactus';

        $tours = Tour::where('publish', '1')->orderByRaw("RAND()")->take(4)->get();
        $this->params['tours'] = $tours;

		//faxes
		$faxes = json_decode(\App\Config::where('property', 'contact_fax')->first()->value);

		if (isset($faxes->{$this->config['lang']['code']})){
			$fax = $faxes->{$this->config['lang']['code']};
		}
		else {
			$fax = [];
		}

		$this->params['faxes'] = $fax;

        return view('frontend.contact.index', $this->params);
    }
}
