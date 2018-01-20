<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Book;
use App\Checkout;
use App\BookMessage;
use Mail;
use File;

class BookingController extends Controller {

    public function getProof(Request $request, $bookid)
    {
        $book = Book::where('bookid', $bookid)->first();

        if ($book && $book->payment && $book->payment->code == 'thaibanks')
        {
            $this->params['book']       = $book;
            $this->params['request']    = $request;
            $this->params['menu']       = 'book';

            return view('dashboard.books.proof', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostSendMessage(Request $request, $bookid)
    {
        $response   = ['stauts' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $text       = $request->input('text');
        $book       = Book::where('bookid', $bookid)->first();

        if ($book && trim($text) != '')
        {
            $response['message'] = trans('error.general');

            $message = new BookMessage;
            $message->book_id   = $book->id;
            $message->user_id   = $this->user->id;
            $message->text      = trim($text);

            if ($message->save()){
                if ($book->tour){
                    $title = $book->tour->getTitle($this->config['lang']['code']);
                    Mail::queue('emails.books.message_client', ['book' => $book, 'text' => $message->text, 'config' => $this->config], function($mail) use ($book, $title){
                        $mail->to($book->email, $book->firstname.' '.$book->lastname)->subject(trans('book.Tour booking status').' - '.$title);
                    });
                }

                $response['status']     = 'ok';
                $response['message']    = 'success';
                $response['payload']['messageid'] = $message->messageid;
            }
        }

        return response()->json($response);
    }

    public function ajaxPostDelete(Request $request, $bookid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $book = Book::find($id);
            if ($book && $book->bookid == $bookid)
            {
                $response['message'] = trans('error.general');

                $book->messages->each(function($message){
                    $message->delete();
                });

                $book->informs->each(function($inform){
                    if (File::exists(public_path('app/inform/'.$inform->informid.'.png'))){
                        File::delete(public_path('app/inform/'.$inform->informid.'.png'));
                    }
                    $inform->delete();
                });

                if ($book->checkout){
                    $book->checkout->delete();
                }
                if ($book->delete()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostDeleteAll(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];

        $books = Book::all();
        foreach ($books as $book){
            $book->messages->each(function($message){
                $message->delete();
            });

            $book->informs->each(function($inform){
                if (File::exists(public_path('app/inform/'.$inform->informid.'.png'))){
                    File::delete(public_path('app/inform/'.$inform->informid.'.png'));
                }
                $inform->delete();
            });

            if ($book->checkout){
                $book->checkout->delete();
            }
            $book->delete();
        }

        $checkouts = Checkout::where('book_id', 0)->get();
        $checkouts->each(function($checkout){
            $checkout->delete();
        });

        $response['status']     = 'ok';
        $response['message']    = 'success';

        return response()->json($response);
    }

    public function ajaxPostDeletes(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $items      = $request->input('items');

        if ($items)
        {
            $success = true;

            foreach ($items as $item){
                if (isset($item['id']) && isset($item['bookid'])){
                    $book = Book::find($item['id']);
                    if ($book && $book->bookid == $item['bookid'] && $book->checkout){
                        $book->messages->each(function($message){
                            $message->delete();
                        });

                        $book->informs->each(function($inform){
                            if (File::exists(public_path('app/inform/'.$inform->informid.'.png'))){
                                File::delete(public_path('app/inform/'.$inform->informid.'.png'));
                            }
                            $inform->delete();
                        });

                        if (!$book->checkout->delete() || !$book->delete()){
                            $success = false;
                        }
                    }
                }
            }

            if ($success){
                $response['status']     = 'ok';
                $response['message']    = 'success';
            }
        }

        return response()->json($response);
    }

    public function getDetail(Request $request, $bookid)
    {
        $book = Book::where('bookid', $bookid)->first();

        if ($book)
        {
            if ($book->open == '0000-00-00 00:00:00'){
                $book->open = date('Y-m-d H:i:s');
                $book->save();
            }

            $this->params['book']       = $book;
            $this->params['request']    = $request;
            $this->params['menu']       = 'book';

            return view('dashboard.books.detail', $this->params);
        }

        return abort(404);
    }

    public function getIndex(Request $request)
    {
        $q          = trim($request->input('q', ''));
        $only       = $request->input('only');

        if ($only == 'unread')
        {
            $items      = Book::where('open', '0000-00-00 00:00:00')->orderBy('created_at', 'desc')->paginate(25);
            $notopen    = $items->total();
        }
        else
        {
            $notopen = Book::where('open', '0000-00-00 00:00:00')->count();

            if ($q == '')
            {
                $items = Book::orderBy('created_at', 'desc')->paginate(25);
            }
            else
            {
                $items = Book::where(function($query) use ($q){
                    $query->where('bookid', 'like', "%$q%")
                        ->orWhere('firstname', 'like', "%$q%")
                        ->orWhere('lastname', 'like', "%$q%")
                        ->orWhere('phone', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%")
                        ->orWhere('note', 'like', "%$q%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(25);

                $items->appends(array('q' => $q));
            }
        }

        $this->params['q']			= $q;
        $this->params['notopen']    = $notopen;
        $this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'book';

        return view('dashboard.books.index', $this->params);
    }
}
