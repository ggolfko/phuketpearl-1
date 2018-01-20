<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

class AuthController extends Controller {

	public function postReset(Request $request, $token)
	{
		$email		= $request->input('email');
		$password	= $request->input('password');
		$cpassword	= $request->input('password_confirmation');
		$eMessage	= trans('error.procedure');

		if ($email && $password && $cpassword)
		{
			$eMessage = trans('error.general');
			if(
				preg_match("/^[a-zA-Z0-9]+$/", $password) && strlen($password) > 5 &&
				preg_match("/^[a-zA-Z0-9]+$/", $cpassword) && strlen($cpassword) > 5 &&
				$password == $cpassword
			)
			{
				$credentials = array(
					'token'	=> $token,
					'email' => $email,
					'password' => $password,
					'password_confirmation' => $cpassword
				);

				$execution = \Password::reset($credentials, function($user, $password) {
					$user->password		= \Hash::make($password);
	                $user->rpassword	= '';
					$user->save();
				});

				switch ($execution)
				{
					case \Password::PASSWORD_RESET:
						return redirect('dashboard/auth/login')->with('sMessage', trans('auth.Your password has been reset, please log in with your new information.'));
						break;

					default:
						$eMessage = trans($execution);
				}
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
	}

	public function getReset(Request $request, $token)
	{
        $this->params['request'] = $request;
        
		return view('dashboard.auth.reset', $this->params);
	}

	public function getLogin(Request $request)
	{
        $this->params['request']  = $request;
		$this->params['redirect'] = $request->input('_rdi');

		return view('dashboard.auth.login', $this->params);
	}

	public function postLogin(Request $request)
	{
		$username	= $request->input('username');
		$password	= $request->input('password');
		$remember	= $request->input('remember')? true: false;
		$redirect	= $request->input('_rdi');
		$errorMessage = trans('error.procedure');

		if ($username && $password)
		{
			if ($this->auth->attempt(['username' => $username, 'password' => $password], $remember))
			{
				$user = $this->auth->user();
				if ($user->role == 'a' && ($user->status == 'a' || $user->status == 'p'))
				{
					return redirect($redirect? $redirect :'dashboard');
				}
				else {
					$eMessage = trans('auth.You do not have permission to use this section.');
				}
			}
			else {
				$eMessage = trans('auth.Your information is not correct, please check your information and try again.');
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
	}

	public function getLogout()
	{
		$this->auth->logout();
		return redirect('dashboard/auth/login');
	}

	public function ajaxPostReminder(Request $request)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$email = $request->input('email');
		if ($email && filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$response['message'] = trans('error.general');

			$reminder = \Password::sendResetLink(['email' => $email], function($message) {
				$message->subject(trans('auth.Reset your password'));
	        });

			switch ($reminder)
			{
				case \Password::RESET_LINK_SENT:
					$response['status']		= 'ok';
					$response['message']	= trans('auth.EMAIL_REMINDER_SENT', ['email' => $email]);
					break;

	            case \Password::INVALID_USER:
					$response['message']	= trans('auth.Your email address does not exist in the system, please check again.');
					break;
	        }
		}

		return response()->json($response);
	}

	public function getAccount(Request $request)
	{
        $this->params['request'] = $request;

		return view('dashboard.auth.account', $this->params);
	}

	public function postAccount(Request $request)
	{
		$form = $request->input('form');

		if ($form)
		{
			//personal
			if ($form == 'personal')
			{
				$eMessage	= trans('error.procedure');
				$firstname	= trim($request->input('firstname'));
				$lastname	= trim($request->input('lastname'));
				$username	= trim($request->input('username'));
				$email		= trim($request->input('email'));

				if ($firstname && $lastname && $username && $email)
				{
					if ($firstname != '' && $lastname != '' && $username != '' && $email != '')
					{
						if (preg_match("/^[a-zA-Z0-9_.]+$/", $username && strlen($username) > 4))
						{
							$eUsername = \App\User::where('username', $username)->first();

							if (!$eUsername || ($eUsername && $eUsername->id == $this->user->id))
							{
								if (filter_var($email, FILTER_VALIDATE_EMAIL))
								{
									$eEmail = \App\User::where('email', $email)->first();

									if (!$eEmail || ($eEmail && $eEmail->id == $this->user->id))
									{
										$this->user->firstname	= $firstname;
										$this->user->lastname	= $lastname;
										$this->user->username	= $username;
										$this->user->email		= $email;

										if ($this->user->save()){
											return redirect()->back()->with('sMessagePersonal', trans('auth.Your personal information has been updated successfully.'));
										}
										else {
											$eMessage = trans('error.general');
										}
									}
									else {
										$eMessage = trans('auth.This email address is already in use, please choose another email address.');
									}
								}
								else {
									$eMessage = trans('auth.The format of the email address is invalid, please check again.');
								}
							}
							else {
								$eMessage = trans('auth.This username is already in use, please choose another username.');
							}
						}
						else {
							$eMessage = trans('auth.Regulations of the username is not valid, please check again.');
						}
					}
				}
				return redirect()->back()->with('eMessagePersonal', $eMessage);
			}
			//password
			else if ($form == 'password')
			{
				$eMessage	= trans('error.procedure');
				$opassword	= $request->input('opassword');
				$password	= $request->input('password');
				$cpassword	= $request->input('cpassword');

				if ($opassword && $password && $cpassword)
				{
					if ($opassword != '' && $password != '' && $cpassword != '')
					{
						if (\Hash::check($opassword, $this->user->password))
						{
							if (
								preg_match("/^[a-zA-Z0-9]+$/", $password) && strlen($password) > 5 &&
								preg_match("/^[a-zA-Z0-9]+$/", $cpassword) && strlen($cpassword) > 5
							){
								if ($cpassword == $password)
								{
									$this->user->password	= \Hash::make($password);
									$this->user->rpassword	= '';

									if ($this->user->save()){
										return redirect()->back()->with('sMessagePassword', trans('auth.Your password has been updated successfully.'));
									}
									else {
										$eMessage = trans('error.general');
									}
								}
								else {
									$eMessage = trans('auth.The new password does not match.');
								}
							}
							else {
								$eMessage = trans('auth.Regulations of the password is incorrect, please check again.');
							}
						}
						else {
							$eMessage = trans('auth.Your old password is incorrect.');
						}
					}
				}
				return redirect()->back()->with('eMessagePassword', $eMessage);
			}
		}

		return redirect()->back();
	}
}
