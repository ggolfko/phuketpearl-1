<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Enquiry;
use App\EnquiryMessage;
use Mail;

class EnquiryController extends Controller {

    public function ajaxPostSendMessage(Request $request, $enquiryid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];
        $id         = $request->input('id');
        $text       = $request->input('text');

        if ($id && $text)
        {
            $enquiry = Enquiry::find($id);

            if ($enquiry && $enquiry->enquiryid == $enquiryid)
            {
                $response['message'] = trans('error.general');

                $message = new EnquiryMessage;
                $message->enquiry_id    = $enquiry->id;
                $message->user_id       = $this->user->id;
                $message->text          = trim($text);

                if ($message->save())
                {
                    if ($enquiry->product){
                        $title = $enquiry->product->getTitle($this->config['lang']['code']);
                        Mail::queue('emails.enquiry.message_client', ['enquiry' => $enquiry, 'text' => $message->text, 'config' => $this->config], function($mail) use ($enquiry, $title){
                            $mail->to($enquiry->email, $enquiry->fullname)->subject(trans('enquiry.Make an enquiry').' - '.$title);
                        });
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['payload']['messageid'] = $message->messageid;
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostDeleteAll(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];

        $enquiries = Enquiry::all();
        foreach ($enquiries as $enquiry){
            $enquiry->messages->each(function($message){
                $message->delete();
            });

            $enquiry->delete();
        }

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
                if (isset($item['id']) && isset($item['enquiryid'])){
                    $enquiry = Enquiry::find($item['id']);
                    if ($enquiry && $enquiry->enquiryid == $item['enquiryid']){
                        $enquiry->messages->each(function($message){
                            $message->delete();
                        });

                        if (!$enquiry->delete()){
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

    public function ajaxPostDelete(Request $request, $enquiryid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $enquiry = Enquiry::find($id);

            if ($enquiry && $enquiry->enquiryid == $enquiryid)
            {
                $response['message'] = trans('error.general');

                $enquiry->messages->each(function($message){
                    $message->delete();
                });

                if ($enquiry->delete()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function getItem(Request $request, $enquiryid)
    {
        $enquiry = Enquiry::where('enquiryid', $enquiryid)->first();

        if ($enquiry)
        {
            $enquiry->open = date('Y-m-d H:i:s');
            $enquiry->save();

            $this->params['enquiry']    = $enquiry;
            $this->params['request']    = $request;
            $this->params['menu']       = 'enquiry';

            return view('dashboard.enquiry.item', $this->params);
        }

        return abort(404);
    }

    public function getIndex(Request $request)
    {
        $q          = trim($request->input('q', ''));
        $only       = $request->input('only');

        if ($only == 'unread')
        {
            $items      = Enquiry::where('open', '0000-00-00 00:00:00')->orderBy('created_at', 'desc')->paginate(25);
            $notopen    = $items->total();
        }
        else
        {
            $notopen = Enquiry::where('open', '0000-00-00 00:00:00')->count();

            if ($q == '')
            {
                $items = Enquiry::orderBy('created_at', 'desc')->paginate(25);
            }
            else
            {
                $items = Enquiry::where(function($query) use ($q){
                    $query->where('enquiryid', 'like', "%$q%")
                        ->orWhere('fullname', 'like', "%$q%")
                        ->orWhere('phone', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%")
                        ->orWhere('detail', 'like', "%$q%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(25);

                $items->appends(array('q' => $q));
            }
        }

        $this->params['q']          = $q;
        $this->params['notopen']    = $notopen;
        $this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'enquiry';

        return view('dashboard.enquiry.index', $this->params);
    }
}
