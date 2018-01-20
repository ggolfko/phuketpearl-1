<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\User;

class EmployeesController extends Controller {

	public function postPersonEdit(Request $request, $userid)
	{
		$eMessage	= trans('error.procedure');
		$person	= User::where('userid', $userid)->first();

		if ($person)
		{
			$firstname	= trim($request->input('firstname'));
			$lastname	= trim($request->input('lastname'));
			$username	= trim($request->input('username'));
			$email		= trim($request->input('email'));
			$status		= trim($request->input('status'));

            $permission_product     = $request->input('permission_product');
            $permission_tour        = $request->input('permission_tour');
            $permission_book        = $request->input('permission_book');
            $permission_newsletter  = $request->input('permission_newsletter');
            $permission_news        = $request->input('permission_news');
            $permission_contact     = $request->input('permission_contact');
            $permission_document    = $request->input('permission_document');
			$permission_setting		= $request->input('permission_setting');
			$permission_employee	= $request->input('permission_employee');
            $permission_gallery     = $request->input('permission_gallery');
            $permission_video       = $request->input('permission_video');
            $permission_payment     = $request->input('permission_payment');
            $permission_enquiry     = $request->input('permission_enquiry');

			if (
				$firstname && $lastname && $username && $email && $status &&
				in_array($status, ['a', 'b']) &&
				preg_match("/^[a-zA-Z0-9_.]+$/", $username) && strlen($username) > 4 &&
	            filter_var($email, FILTER_VALIDATE_EMAIL)
			)
			{
				$eMessage = trans('error.general');

				$eUsername = User::where('username', $username)->first();
				if (!$eUsername || ($eUsername->userid == $person->userid))
				{
					$eEmail = User::where('email', $email)->first();
					if (!$eEmail || ($eEmail->userid == $person->userid))
					{
						$person->username	= $username;
						$person->email		= $email;
						$person->firstname	= $firstname;
						$person->lastname	= $lastname;
						$person->status		= $status;
                        $person->permission_product     = $permission_product == 'true'? true: false;
                        $person->permission_tour        = $permission_tour == 'true'? true: false;
                        $person->permission_book        = $permission_book == 'true'? true: false;
                        $person->permission_newsletter  = $permission_newsletter == 'true'? true: false;
                        $person->permission_news        = $permission_news == 'true'? true: false;
                        $person->permission_contact     = $permission_contact == 'true'? true: false;
                        $person->permission_document    = $permission_document == 'true'? true: false;
						$person->permission_setting		= $permission_setting == 'true'? true: false;
						$person->permission_employee	= $permission_employee == 'true'? true: false;
                        $person->permission_gallery     = $permission_gallery == 'true'? true: false;
                        $person->permission_video       = $permission_video == 'true'? true: false;
                        $person->permission_payment     = $permission_payment == 'true'? true: false;
                        $person->permission_enquiry     = $permission_enquiry == 'true'? true: false;

						if ($person->save())
						{
							return redirect("dashboard/employees/{$person->userid}")->with('sMessage', trans('employee.Save changes employee data successfully.'));
						}
					}
					else {
						$eMessage = trans('auth.This email address is already in use, please choose another email address.');
					}
				}
				else {
					$eMessage = trans('auth.This username is already in use, please choose another username.');
				}
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
	}

	public function ajaxPostPersonExistsEmail(Request $request, $userid)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$email	= trim($request->input('email'));
		$person	= User::where('userid', $userid)->first();

		if ($email && $person)
		{
			$response['message'] = trans('error.general');
			$exists = User::where('email', $email)->first();

			$response['status']		= 'ok';
			$response['message']	= 'success';
			$response['payload']['exists'] = ($exists && $exists->userid != $person->userid)? true: false;
		}

		return response()->json($response);
	}

	public function ajaxPostPersonExistsUsername(Request $request, $userid)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$username	= trim($request->input('username'));
		$person		= User::where('userid', $userid)->first();

		if ($username && $person)
		{
			$response['message'] = trans('error.general');
			$exists = User::where('username', $username)->first();

			$response['status']		= 'ok';
			$response['message']	= 'success';
			$response['payload']['exists'] = ($exists && $exists->userid != $person->userid)? true: false;
		}

		return response()->json($response);
	}

	public function getPersonEdit(Request $request, $userid)
	{
		$person = User::where('userid', $userid)->first();
		if ($person)
		{
            $this->params['request']    = $request;
			$this->params['person']	    = $person;
			$this->params['menu']	    = 'employee';

			return view('dashboard.employees.edit', $this->params);
		}

		return abort(404);
	}

	public function getPerson(Request $request, $userid)
	{
		$person = User::where('userid', $userid)->first();
		if ($person)
		{
			$this->params['person']	= $person;
			$this->params['menu']	= 'employee';

			return view('dashboard.employees.person', $this->params);
		}

		return abort(404);
	}

	public function ajaxPostDeletePerson(Request $request, $userid)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$id = $request->input('id');
		if ($id)
		{
			$response['message'] = trans('error.general');

			$user = User::find($id);
			if ($user && $user->userid == $userid)
			{
				if ($user->userid == $this->user->userid)
				{
					$response['message'] = trans('employee.You can not delete your own account.');
				}
				else if ($user->delete())
				{
					$response['status']		= 'ok';
					$response['message']	= 'success';
				}
			}
		}

		return response()->json($response);
	}

	public function postCreate(Request $request)
	{
		$firstname	= trim($request->input('firstname'));
		$lastname	= trim($request->input('lastname'));
		$username	= trim($request->input('username'));
		$email		= trim($request->input('email'));
		$status		= trim($request->input('status'));

		$permission_product		= $request->input('permission_product');
        $permission_tour		= $request->input('permission_tour');
        $permission_book		= $request->input('permission_book');
        $permission_newsletter  = $request->input('permission_newsletter');
        $permission_news        = $request->input('permission_news');
        $permission_contact     = $request->input('permission_contact');
        $permission_document    = $request->input('permission_document');
        $permission_setting		= $request->input('permission_setting');
		$permission_employee	= $request->input('permission_employee');
        $permission_gallery     = $request->input('permission_gallery');
        $permission_video       = $request->input('permission_video');
        $permission_payment     = $request->input('permission_payment');
        $permission_enquiry     = $request->input('permission_enquiry');

		$eMessage = trans('error.procedure');

		if (
			$firstname && $lastname && $username && $email && $status &&
			in_array($status, ['a', 'b']) &&
			preg_match("/^[a-zA-Z0-9_.]+$/", $username) && strlen($username) > 4 &&
            filter_var($email, FILTER_VALIDATE_EMAIL)
		)
		{
			$eMessage = trans('error.general');

			$eUsername = User::where('username', $username)->first();
			if (!$eUsername)
			{
				$eEmail = User::where('email', $email)->first();
				if (!$eEmail)
				{
					$user = new User;
					$user->username		= $username;
					$user->email		= $email;
					$user->firstname	= $firstname;
					$user->lastname		= $lastname;
					$user->locale		= $this->config['default_lang'];
					$user->role			= 'e';
					$user->status		= $status;
                    $user->permission_product       = $permission_product == 'true'? true: false;
                    $user->permission_tour          = $permission_tour == 'true'? true: false;
                    $user->permission_book          = $permission_book == 'true'? true: false;
                    $user->permission_newsletter    = $permission_newsletter == 'true'? true: false;
                    $user->permission_news          = $permission_news == 'true'? true: false;
                    $user->permission_contact       = $permission_contact == 'true'? true: false;
                    $user->permission_document      = $permission_document == 'true'? true: false;
					$user->permission_setting	    = $permission_setting == 'true'? true: false;
					$user->permission_employee	    = $permission_employee == 'true'? true: false;
                    $user->permission_gallery	    = $permission_gallery == 'true'? true: false;
                    $user->permission_video  	    = $permission_video == 'true'? true: false;
                    $user->permission_payment  	    = $permission_payment == 'true'? true: false;
                    $user->permission_enquiry  	    = $permission_enquiry == 'true'? true: false;

					if ($user->save())
					{
						return redirect('dashboard/employees?uid='. $user->userid)->with('sMessage', trans('employee.ADD_SUCCESSFULLY', ['password' => \Crypt::decrypt($user->rpassword)]));
					}
				}
				else {
					$eMessage = trans('auth.This email address is already in use, please choose another email address.');
				}
			}
			else {
				$eMessage = trans('auth.This username is already in use, please choose another username.');
			}
		}

		return redirect()->back()->with('eMessage', $eMessage);
	}

	public function ajaxPostExistsEmail(Request $request)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$email = trim($request->input('email'));
		if ($email)
		{
			$response['message'] = trans('error.general');

			$user = User::where('email', $email)->first();

			$response['status']		= 'ok';
			$response['message']	= 'success';
			$response['payload']['exists'] = $user? true: false;
		}

		return response()->json($response);
	}

	public function ajaxPostExistsUsername(Request $request)
	{
		$response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

		$username = trim($request->input('username'));
		if ($username)
		{
			$response['message'] = trans('error.general');

			$user = User::where('username', $username)->first();

			$response['status']		= 'ok';
			$response['message']	= 'success';
			$response['payload']['exists'] = $user? true: false;
		}

		return response()->json($response);
	}

	public function getCreate(Request $request)
	{
        $this->params['request']    = $request;
		$this->params['menu']	    = 'employee';

		return view('dashboard.employees.create', $this->params);
	}

	public function getIndex(Request $request)
	{
		$q	= trim($request->input('q', ''));

		if ($q == '')
        {
			$people	= User::where('role', 'e')
				->orderBy('firstname', 'asc')
				->orderBy('lastname', 'asc')
				->paginate(25);
        }
        else
        {
            $people	= User::where('role', 'e')
                ->where(function($query) use ($q){
                    $query->where('firstname', 'like', "%$q%")
                        ->orWhere('lastname', 'like', "%$q%")
                        ->orWhere('username', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%");
                })
                ->orderBy('firstname', 'asc')
                ->orderBy('lastname', 'asc')
                ->paginate(25);

            $people->appends(array('q' => $q));
        }

		$this->params['q']			= $q;
		$this->params['people']		= $people;
		$this->params['request']	= $request;
		$this->params['menu']		= 'employee';

		return view('dashboard.employees.index', $this->params);
	}
}
