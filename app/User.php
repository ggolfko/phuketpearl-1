<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	protected static function createId()
    {
        $id = date('dmyHis');
		for ($i=0;$i<4;$i++)
            $id .= rand(0,9);
        $item = User::where('userid', $id)->count();
        return $item > 0? User::createId(): $id;
    }

	public static function randomPassword(){
		$alphabet		= '1234567890';
		$pass			= array();
		$alphaLength	= strlen($alphabet) - 1;
		for ($i = 0; $i < 6; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}

	public static function boot()
    {
        parent::boot();

        static::creating(function($model){
			$model->userid = self::createId();

			$password = self::randomPassword();
			$model->password	= \Hash::make($password);
			$model->rpassword	= \Crypt::encrypt($password);
        });
    }

	public function getRole()
	{
		$role = config('app.role');
		return $role[$this->role]? $role[$this->role]: '';
	}

	public function getStatus()
	{
		$status = config('app.status');
		return $status[$this->status]? $status[$this->status]: '';
	}

	public function getLanguage()
	{
		$text		= '';
		$locales	= config('app.locales');

		if (isset($locales[$this->locale]))
		{
			$text = $locales[$this->locale]['title'];
		}

		return $text;
	}

	public function getPermission()
	{
		$lists = [];

        if ($this->permission_product == '1'){
			$lists[] = trans('employee.Product management');
		}
        if ($this->permission_newsletter == '1'){
			$lists[] = trans('_.Newsletter');
		}
        if ($this->permission_news == '1'){
			$lists[] = trans('_.News');
		}
        if ($this->permission_contact == '1'){
			$lists[] = trans('_.Contacts');
		}
        if ($this->permission_document == '1'){
			$lists[] = trans('_.Documents');
		}
		if ($this->permission_setting == '1'){
			$lists[] = trans('employee.The settings of the site');
		}
		if ($this->permission_employee == '1'){
			$lists[] = trans('employee.Employee management');
		}
        if ($this->permission_gallery == '1'){
			$lists[] = trans('_.Gallery');
		}
        if ($this->permission_video == '1'){
			$lists[] = trans('_.Videos');
		}

		return count($lists) < 1? ' - ': implode($lists, ', ');
	}
}
