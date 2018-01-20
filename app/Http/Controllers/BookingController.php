<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Checkout;
use App\Inform;
use App\BankMap;
use App\Tour;
use App\User;
use DB;
use Mail;

class BookingController extends Controller {

    public function ajaxPostSuccess(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        $bookid         = $request->input('bookid');
        $checkoutid     = $request->input('checkoutid');
        $transaction    = $request->input('transaction');

        if ($bookid && $checkoutid && $transaction)
        {
            $book       = Book::where('bookid', $bookid)->first();
            $checkout   = Checkout::where('checkoutid', $checkoutid)->first();

            if ($book && $book->tour && $book->payment && $book->payment->code == 'credit_debit' && $checkout && $checkout->book_id == $book->id && $checkout->transaction == $transaction)
            {
                $response['message'] = trans('error.general');

				$subject = $this->config['name'] . ' - Payment completed';

				Mail::queue('emails.books.inform_admin', ['book' => $book, 'config' => $this->config], function($mail) use ($book, $subject){
					$mail->from($book->email, $book->firstname.' '.$book->lastname);
					$mail->to(config('mail.from')['address']);
					$mail->subject($subject);
				});

                $response['status']     = 'ok';
                $response['message']    = 'success';
            }
        }

        return response()->json($response);
    }

    public function ajaxPostInform(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        $bookid         = $request->input('bookid');
        $checkoutid     = $request->input('checkoutid');
        $transaction    = $request->input('transaction');
        $map_id         = $request->input('map_id');
        $time           = $request->input('time');
        $amount         = $request->input('amount');
        $note           = $request->input('note');

        if ($bookid && $checkoutid && $transaction && $map_id && $time && preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $time) && $amount && $request->hasFile('image'))
        {
            $book       = Book::where('bookid', $bookid)->first();
            $checkout   = Checkout::where('checkoutid', $checkoutid)->first();
            $map        = BankMap::find($map_id);

            if ($book && $book->tour && $book->payment && $book->payment->code == 'thaibanks' && $checkout && $checkout->book_id == $book->id && $checkout->transaction == $transaction && $map)
            {
                $valid = false;
                foreach ($book->payment->banks as $j){
                    if ($j->id == $map->id){
                        $valid = true;
                    }
                }

                if ($valid)
                {
                    $file   = $request->file('image');
                    $ext    = $file->getClientOriginalExtension();
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
                    {
                        $response['message'] = trans('error.general');

                        $id     = Inform::createId();
                        $image  = \Image::make($file);

                        if ($image->save(public_path("app/inform/{$id}.png"), 100))
                        {
                            $inform = new Inform;
                            $inform->informid   = $id;
                            $inform->book_id    = $book->id;
                            $inform->map_id     = $map->id;
                            $inform->time       = $time;
                            $inform->amount     = trim($amount);
                            $inform->note       = trim($note);

                            $book->completed = date('Y-m-d H:i:s');

                            if ($inform->save() && $book->save()){

								$subject = $this->config['name'] . ' - Payment completed';

								Mail::queue('emails.books.inform_admin', ['book' => $book, 'config' => $this->config], function($mail) use ($book, $subject){
		                            $mail->from($book->email, $book->firstname.' '.$book->lastname);
									$mail->to(config('mail.from')['address']);
									$mail->subject($subject);
		                        });

                                $response['status']     = 'ok';
								$response['message']    = 'success';
                            }
                        }
                    }
                }
            }
        }

        return response()->json($response);
    }

    public function anySuccess(Request $request, $bookid)
    {
        $book = Book::where('bookid', $bookid)->first();

        if ($book && $book->tour && $book->payment && $request->has('transaction') && $request->has('checkoutid'))
        {
            $transaction    = $request->input('transaction');
            $checkoutid     = $request->input('checkoutid');

            $checkout = Checkout::where('checkoutid', $checkoutid)->first();

            if ($checkout && $checkout->book_id == $book->id && $checkout->transaction == $transaction)
            {
                if ($book->payment->code == 'credit_debit'){
                    if ($book->completed == '0000-00-00 00:00:00'){
                        $book->completed = date('Y-m-d H:i:s');
                        $book->save();
                    }
                }

                $tours = Tour::where('publish', '1')->where('id', '!=', $book->tour->id)->orderBy(DB::raw('RAND()'))->take(1)->get();
                $this->params['tours'] = $tours;

                $this->params['book']       = $book;
                $this->params['checkout']   = $checkout;
                $this->params['request']    = $request;
                $this->params['title']      = trans('_.Booking Tour').' - '.$this->config['name'];
                $this->params['menu']       = 'visitus';
                $this->params['submenu']    = 'tour';

                return view('frontend.books.success', $this->params);
            }
        }

        return abort(404);
    }

    public function getPayment(Request $request, $bookid)
    {
        $book = Book::where('bookid', $bookid)->first();

        if ($book && $book->tour && $book->payment && $request->has('transaction') && $request->has('checkoutid'))
        {
            $transaction    = $request->input('transaction');
            $checkoutid     = $request->input('checkoutid');

            $checkout = Checkout::where('checkoutid', $checkoutid)->first();

            if ($checkout && $checkout->book_id == $book->id && $checkout->transaction == $transaction)
            {
                $tours = Tour::where('publish', '1')->where('id', '!=', $book->tour->id)->orderBy(DB::raw('RAND()'))->take(2)->get();
                $this->params['tours'] = $tours;

                $this->params['book']       = $book;
                $this->params['checkout']   = $checkout;
                $this->params['request']    = $request;
                $this->params['title']      = trans('_.Booking Tour').' - '.$this->config['name'];
                $this->params['menu']       = 'visitus';
                $this->params['submenu']    = 'tour';

                return view('frontend.books.payment', $this->params);
            }
        }

        return abort(404);
    }
}
