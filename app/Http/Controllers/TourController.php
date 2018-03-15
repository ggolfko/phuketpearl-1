<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tour;
use App\Country;
use App\Book;
use App\Checkout;
use App\User;
use Mail;
use DB;

class TourController extends Controller {

    public function ajaxPostBooking(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $token      = $request->input('token');
        $cid        = $request->input('cid');
        $checkoutid = $request->input('checkoutid');
        $tid        = $request->input('tid');
        $tourid     = $request->input('tourid');
        $firstname  = $request->input('firstname');
        $lastname   = $request->input('lastname');
        $email      = $request->input('email');
        $phone      = $request->input('phone');
        $country_id = $request->input('country_id');
        $note       = $request->input('note');
        $paymentid  = $request->input('paymentid');
		$area	  	= $request->input('area');
		$hotel		= $request->input('hotel');
		$room		= $request->input('room');

        if ($token && $cid && $checkoutid && $tid && $tourid && $firstname && $lastname && $email && filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $checkout   = Checkout::find($cid);
            $tour       = Tour::find($tid);

            if (
                ($checkout && $checkout->checkoutid == $checkoutid && $checkout->token == $token && $checkout->transaction == \Crypt::decrypt($token)) &&
                ($tour && $tour->tourid == $tourid && $tour->publish == '1') &&
                ($checkout->tour_id == $tour->id)
            )
            {
				if ($checkout->book_id == 0)
				{
					$response['message'] = trans('error.general');

	                $book = new Book;
	                $book->tour_id      = $tour->id;
	                $book->firstname    = trim($firstname);
	                $book->lastname     = trim($lastname);
	                $book->email        = trim($email);
	                $book->phone        = trim($phone);
	                $book->note         = trim($note);
	                $book->open         = '0000-00-00 00:00:00';
	                $book->completed    = '0000-00-00 00:00:00';
					$book->area			= trim($area);
					$book->hotel		= trim($hotel);
					$book->room			= trim($room);

					$country_assign = false;

					if ($country_id){
						$country = Country::find($country_id);

						if ($country){
							$book->country_id = $country->id;
							$country_assign = true;
						}
					}

					if (!$country_assign){
						$book->country_id = 0;
					}

	                if ($book->save())
	                {
	                    $checkout->book_id = $book->id;

	                    if ($checkout->save())
	                    {
							Checkout::where('book_id', 0)->where('created_at', '<', $checkout->created_at->format('Y-m-d H:i:s'))->get()->each(function($c){
								$c->delete();
							});

	                        $payment = false;
	                        foreach ($tour->getPayments() as $map){
	                            if ($map->payment && $map->payment->paymentid == $paymentid){
	                                $payment = $map->payment;
	                                break;
	                            }
	                        }

	                        if ($payment){
	                            $book->payment_id = $payment->id;
	                            $book->save();
	                        }

							$subject = $this->config['name'] . ' - ' . trans('book.Booking information');

                            Mail::queue('emails.tour.books.client', ['book' => $book, 'config' => $this->config], function($mail) use ($book, $subject){
	                            $mail->to($book->email, $book->firstname.' '.$book->lastname);
								$mail->subject($subject);
	                        });

							$subject = $this->config['name'] . ' - Tour booking';

							Mail::queue('emails.tour.books.admin', ['book' => $book, 'config' => $this->config], function($mail) use ($book, $subject){
								$mail->to(config('app.email'));
								$mail->subject($subject);
	                        });

	                        $response['status']     = 'ok';
	                        $response['message']    = 'success';
	                        $response['payload']['payment']     = $payment? true: false;
	                        $response['payload']['bookid']      = $book->bookid;
	                        $response['payload']['checkout']    = [
	                            'checkoutid'    => $checkout->checkoutid,
	                            'transaction'   => $checkout->transaction
	                        ];
	                    }
	                }
				}
				else
				{
					$response['payload']['error_code'] = 'repeat';
				}
            }
        }

        return response()->json($response);
    }

    public function postDetail(Request $request, $url)
    {
        $tour = Tour::where('url', $url)->where('publish', '1')->first();

        if ($tour)
        {
            $passed = false;

            //package
            if ($tour->price_type == 'package')
            {
                if ($request->has('total') && $request->has('date') && $request->has('packages'))
                {
                    $total      = $request->input('total');
                    $packages   = $request->input('packages');
					$extra_id	= $request->input('extra');

					$extra = $tour->extras()->where('extraid', $extra_id)->first();

					if ($extra)
					{
						if ($total == (($packages*$tour->price_package)+$extra->price) )
						{
	                        $passed = true;
	                        $checkout = new Checkout;
	                        $checkout->total    = $total;
	                        $checkout->packages = $packages;
	                        $checkout->adults   = 0;
	                        $checkout->children = 0;
							$checkout->extra_id	= $extra->id;
	                    }
					}
					else
					{
						if ($total == ($packages*$tour->price_package))
						{
	                        $passed = true;
	                        $checkout = new Checkout;
	                        $checkout->total    = $total;
	                        $checkout->packages = $packages;
	                        $checkout->adults   = 0;
	                        $checkout->children = 0;
							$checkout->extra_id	= 0;
	                    }
					}
                }
            }
            //person
            else if ($tour->price_type == 'person')
            {
                if ($request->has('total') && $request->has('date') && $request->has('time') && $request->has('adults') && $request->has('children'))
                {
                    $total      = $request->input('total');
                    $adults     = $request->input('adults');
                    $children   = $request->input('children');

                    if ($total == (($adults*$tour->price_person_adult) + ($children*$tour->price_person_child))){
                        $passed = true;
                        $checkout = new Checkout;
                        $checkout->total    = $total;
                        $checkout->packages = 0;
                        $checkout->adults   = $adults;
                        $checkout->children = $children;
						$checkout->extra_id	= 0;
                    }
                }
            }
			//free
            else if ($tour->price_type == 'free')
            {
                if ($request->has('total') && $request->has('date') && $request->has('time') && $request->has('adults') && $request->has('children'))
                {
                    $total      = $request->input('total');
                    $adults     = $request->input('adults');
                    $children   = $request->input('children');

                    $passed = true;
					$checkout = new Checkout;
					$checkout->total    = $total;
					$checkout->packages = 0;
					$checkout->adults   = $adults;
					$checkout->children = $children;
					$checkout->extra_id	= 0;
                }
            }

            if ($passed)
            {
                $checkout->tour_id  = $tour->id;
                $checkout->book_id  = 0;
                $checkout->date     = $request->input('date');
				$checkout->time     = $request->input('time');

                if ($checkout->save())
                {
                    return redirect("tours/{$tour->url}.html?transaction={$checkout->transaction}&checkoutid={$checkout->checkoutid}")->with('checkout_token', $checkout->token);
                }
            }
        }

        return abort(404);
    }

    public function getDetail(Request $request, $url)
    {
        $tour = Tour::where('url', $url)->where('publish', '1')->first();

        if ($tour)
        {
			$title = $tour->getTitle($this->config['lang']['code']);

            $this->params['request']    = $request;
            $this->params['tour']       = $tour;
            $this->params['title']      = $title.' - '.$this->config['name'];
            $this->params['menu']       = 'visitus';
            $this->params['submenu']    = 'tour';

            $tags = [];
            foreach($tour->getTags() as $map){
                if($map->tag){
                    $tags[] = $map->tag->text;
                }
            }
            $keywords = array_merge($tags, $this->config['keywords']);
            $this->params['meta_keywords']      = implode(',', $keywords);
            $this->params['meta_description']   = $this->params['title'];

            if ($request->has('transaction') && $request->has('checkoutid') && session()->has('checkout_token'))
            {
                $transaction    = $request->input('transaction');
                $checkoutid     = $request->input('checkoutid');
                $token          = session('checkout_token');

                $checkout = Checkout::where('checkoutid', $checkoutid)->first();

                if ($checkout && $checkout->book_id == 0 && $checkout->transaction == $transaction && $checkout->token == $token && $checkout->transaction == \Crypt::decrypt($token))
                {
                    $this->params['checkout'] = $checkout;
                    return view('frontend.tour.checkout', $this->params);
                }
            }

            $views = $request->cookie('VIEWED')? unserialize($request->cookie('VIEWED')): [];
            if (isset($views['tours'])){
                if (!in_array($tour->tourid, $views['tours'])){
                    $views['tours'][] = $tour->tourid;

                    $tour->views = $tour->views+1;
                    $tour->save();
                }
            }
            else {
                $views['tours'] = [];
                $views['tours'][] = $tour->tourid;

                $tour->views = $tour->views+1;
                $tour->save();
            }
            \Cookie::queue('VIEWED', serialize($views), 60*24*3);

            $randoms = Tour::where('publish', '1')->where('id', '!=', $tour->id)->orderBy(DB::raw('RAND()'))->take(3)->get();
            $this->params['randoms'] = $randoms;

            $disabled = [];
            foreach (json_decode($tour->disabled) as $date) {
                $disabled[] = dateTime($date, 'd-m-Y');
            }
            $this->params['disabled'] = $disabled;

			$og_tags = [
				'title' => $title,
				'description' => str_limit(strip_tags($tour->getDetail($this->config['lang']['code'])), 150)
			];

			$countImage = $tour->images->count();

			if ($countImage > 0){
				if ($countImage == 1){
					$image = $tour->images->first();
					$og_tags['image'] = config('app.url') . "/app/tour/{$tour->tourid}/{$image->imageid}.png";
				}
				else {
					$og_tags['images'] = [];

					foreach ($tour->images as $image){
						$og_tags['images'][] = config('app.url') . "/app/tour/{$tour->tourid}/{$image->imageid}.png";
					}
				}
			}

			$this->params['og_tags'] = $og_tags;

            return view('frontend.tour.detail', $this->params);
        }

        return abort(404);
    }

    public function getIndex()
    {
        $tours = Tour::where('publish', '1')->orderBy('created_at', 'desc')->paginate(12);

        $this->params['tours']      = $tours;
        $this->params['title']      = trans('_.Booking Tour').' - '.$this->config['name'];
        $this->params['menu']       = 'tour';
        $this->params['submenu']    = 'tour';

        return view('frontend.tour.index', $this->params);
    }
}
