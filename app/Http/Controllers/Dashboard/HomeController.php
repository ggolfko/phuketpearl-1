<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Tag;
use App\TagMap;
use App\Enquiry;
use App\Book;
use App\Product;
use App\Tour;
use App\News;
use App\StaticStat;
use NewsletterLaravel;
use Carbon\Carbon;

class HomeController extends Controller {

	public function ajaxGetGoogleAnalytics(Request $request)
    {
        $response	= ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];

		$command	= escapeshellcmd('/var/www/phuketpearl/storage/app/google-analytics/fetch.py');
		$output		= shell_exec($command);
		$token		= trim($output);

		$response['status']     = 'ok';
		$response['message']    = 'success';
		$response['payload']['token'] = $token;

        return response()->json($response);
    }

	public function ajaxPostWarning(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];

		$set = $request->input('set');

		if ($set)
		{
			if ($set == 'hide')
			{
				$response['status']     = 'ok';
		        $response['message']    = 'success';

				return response()->json($response)->withCookie(cookie()->forever('dwarning', false));
			}
			else if ($set == 'show')
			{
				$response['status']     = 'ok';
		        $response['message']    = 'success';

				return response()->json($response)->withCookie(cookie()->forever('dwarning', true));
			}
		}

        return response()->json($response);
    }

	public function ajaxGetSubscribers(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];

		$api			= NewsletterLaravel::getApi();
		$config_lists	= config('laravel-newsletter.lists');
		$list_id		= $config_lists[config('laravel-newsletter.defaultListName')]['id'];
		$all_lists		= $api->get("lists");
		$lists			= $all_lists['lists'];
		$list			= null;
		$members		= 0;

		foreach ($lists as $list_){
			if ($list_['id'] == $list_id){
				$list = $list_;
			}
		}

		if ($list){
			$members = intval($list['stats']['member_count']);
		}

		$stat = StaticStat::where('property', 'count_subscribers')->first();
		$stat->value = $members;

		if ($stat->save())
		{
			$response['status']     = 'ok';
	        $response['message']    = 'success';
			$response['payload']['subscribers'] = $members;
		}

        return response()->json($response);
    }

    public function ajaxGetStat(Request $request)
    {
        $response	= ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];
        $payload	= ['enquiry' => 0, 'book' => 0, 'jewels' => 0, 'tours' => 0, 'news' => 0, 'subscribers' => 0];

		//enquiry
        if ($this->user->role == 'a' || ($this->user->role == 'e' && $this->user->permission_enquiry == '1'))
        {
            $payload['enquiry'] = Enquiry::where('open', '0000-00-00 00:00:00')->count();
        }

		//booking
        if ($this->user->role == 'a' || ($this->user->role == 'e' && $this->user->permission_book == '1'))
        {
            $payload['book'] = Book::where('open', '0000-00-00 00:00:00')->count();
        }

		//jewels
        if ($this->user->role == 'a' || ($this->user->role == 'e' && $this->user->permission_product == '1'))
        {
			$payload['jewels'] = Product::count();
        }

		//tours
        if ($this->user->role == 'a' || ($this->user->role == 'e' && $this->user->permission_tour == '1'))
        {
			$payload['tours'] = Tour::count();
        }

		//news
        if ($this->user->role == 'a' || ($this->user->role == 'e' && $this->user->permission_news == '1'))
        {
			$payload['news'] = News::count();
        }

		//newsletter
        if ($this->user->role == 'a' || ($this->user->role == 'e' && $this->user->permission_newsletter == '1'))
        {
			$stat = StaticStat::where('property', 'count_subscribers')->first();
			$payload['subscribers'] = intval($stat->value);
        }

        $response['status']     = 'ok';
        $response['message']    = 'success';
        $response['payload']    = $payload;

        return response()->json($response);
    }

	public function ajaxPostClear(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];

        //clear tags
        $ids = [];
        foreach (TagMap::get(['tag_id']) as $map){
            $ids[] = $map->tag_id;
        }
        Tag::whereNotIn('id', $ids)->get()->each(function($tag){
            $tag->delete();
        });

        $response['status']     = 'ok';
        $response['message']    = 'success';

        return response()->json($response);
    }

	public function getIndex(Request $request)
	{
		$warning = $request->cookie('dwarning', true);

		$today		= Carbon::now();
		$endDate	= $today->format('Y-m-d');
		$startDate	= $today->addDays(-10)->format('Y-m-d');
		$yesterday	= Carbon::yesterday()->format('d F Y');
		$days30		= Carbon::yesterday()->addDays(-30)->format('d F Y');

		$this->params['menu']		= 'dashboard';
		$this->params['warning']	= $warning;
		$this->params['startDate']	= $startDate;
		$this->params['endDate']	= $endDate;
		$this->params['yesterday']	= $yesterday;
		$this->params['days30']		= $days30;

		return view('dashboard.home.index', $this->params);
	}
}
