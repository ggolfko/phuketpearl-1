<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Contact;
use App\ContactReply;
use Mail;

class ContactsController extends Controller {

    public function ajaxPostReply(Request $request, $contactid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $contact    = Contact::where('contactid', $contactid)->first();
        $message    = $request->input('message');

        if ($contact && $message)
        {
            $reply = new ContactReply;
            $reply->contact_id  = $contact->id;
            $reply->user_id     = $this->user->id;
            $reply->type        = 's';
            $reply->message     = trim($message);

            if ($reply->save()){
                $contact->reply = true;
                $contact->save();

                $response['status']     = 'ok';
                $response['message']    = 'success';
                $response['payload']['replyid'] = $reply->replyid;

                if (isset($this->config['langs'][$contact->locale])){
                    app()->setLocale($contact->locale);
                }

                Mail::send('emails.contact.reply', ['config' => $this->config, 'contact' => $contact, 'reply' => $reply], function($mail) use ($contact){
                    $mail->to($contact->email, "{$contact->firstname} {$contact->lastname}")->subject(trans('_.Reply').': '.$contact->topic);
                });
            }
        }

        return response()->json($response);
    }

    public function getRead(Request $request, $contactid)
    {
        $contact = Contact::where('contactid', $contactid)->first();

        if ($contact)
        {
            $contact->open = date('Y-m-d H:i:s');
            $contact->save();

            $this->params['contact']	= $contact;
    		$this->params['request']	= $request;
            $this->params['menu']       = 'contact';

            return view('dashboard.contacts.read', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostDeleteAll()
    {
        $response = ['status' => 'error', 'message' => trans('error.general'), 'payload' => []];
        $contacts = Contact::all();

        $contacts->each(function($contact){
            $contact->replies->each(function($reply){
                $reply->delete();
            });
            $contact->delete();
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
                if (isset($item['id']) && isset($item['contactid'])){
                    $contact = Contact::find($item['id']);

                    if ($contact && $contact->contactid == $item['contactid']){
                        $contact->replies->each(function($reply){
                            $reply->delete();
                        });

                        if (!$contact->delete()){
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

    public function ajaxPostDelete(Request $request, $contactid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $contact = Contact::find($id);

            if ($contact && $contact->contactid == $contactid)
            {
                $response['message'] = trans('error.general');

                $contact->replies->each(function($reply){
                    $reply->delete();
                });

                if ($contact->delete()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function getIndex(Request $request)
    {
        $q          = trim($request->input('q', ''));
        $only       = $request->input('only');

        if ($only == 'unread')
        {
            $items      = Contact::where('open', '0000-00-00 00:00:00')->orderBy('created_at', 'desc')->paginate(25);
            $notopen    = $items->total();
        }
        else
        {
            $notopen = Contact::where('open', '0000-00-00 00:00:00')->count();

            if ($q == '')
            {
                $items = Contact::orderBy('created_at', 'desc')->paginate(25);
            }
            else
            {
                $items = Contact::where(function($query) use ($q){
                    $query->where('contactid', 'like', "%$q%")
                        ->orWhere('firstname', 'like', "%$q%")
                        ->orWhere('lastname', 'like', "%$q%")
                        ->orWhere('phone', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%")
                        ->orWhere('topic', 'like', "%$q%")
                        ->orWhere('message', 'like', "%$q%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(25);

                $items->appends(array('q' => $q));
            }
        }

        $this->params['q']			= $q;
        $this->params['notopen']    = $notopen;
		$this->params['items']		= $items;
		$this->params['request']	= $request;
        $this->params['menu']       = 'contact';

        return view('dashboard.contacts.index', $this->params);
    }
}
