<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Payment;
use App\Bank;
use App\BankMap;

class PaymentController extends Controller {

    public function ajaxPostRemoveBankMap(Request $request)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $map = BankMap::find($id);
            if ($map)
            {
                if ($map->delete()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postUpdate(Request $request)
    {
        $form = $request->input('form');

        //paypal
        if ($form == 'paypal')
        {
            $eMessage   = trans('error.procedure');
            $email      = $request->input('email');
            if ($email && filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $eMessage   = trans('error.general');
                $paypal     = Payment::where('code', 'paypal')->first();
                $paypal->email = trim($email);
                if ($paypal->save()){
                    return redirect()->back()->with('sMessage_Paypal', trans('_.Save changes successfully.'));
                }
            }
            return redirect()->back()->with('eMessage_Paypal', $eMessage);
        }
        //paysbuy
        if ($form == 'paysbuy')
        {
            $eMessage   = trans('error.procedure');
            $email      = $request->input('email');
            if ($email && filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $eMessage   = trans('error.general');
                $paysbuy    = Payment::where('code', 'paysbuy')->first();
                $paysbuy->email = trim($email);
                if ($paysbuy->save()){
                    return redirect()->back()->with('sMessage_Paysbuy', trans('_.Save changes successfully.'));
                }
            }
            return redirect()->back()->with('eMessage_Paysbuy', $eMessage);
        }
        //banks
        if ($form == 'banks')
        {
            $eMessage = trans('error.procedure');
            $account    = $request->input('account');
            $number     = $request->input('number');
            $type       = $request->input('type');
            $branch     = $request->input('branch');
            $bank_id    = $request->input('bank_id');
            $bankid     = $request->input('bankid');

            if (trim($account) && trim($number) && trim($type) && trim($branch) && $bank_id && $bankid)
            {
                $bank = Bank::find($bank_id);
                if ($bank && $bank->bankid == $bankid)
                {
                    $eMessage   = trans('error.general');
                    $payment    = Payment::where('code', 'thaibanks')->first();
                    $map = new BankMap;
                    $map->payment_id    = $payment->id;
                    $map->bank_id       = $bank->id;
                    $map->account       = trim($account);
                    $map->branch        = trim($branch);
                    $map->type          = trim($type);
                    $map->number        = trim($number);

                    if ($map->save()){
                        return redirect()->back()->with('sMessage_Banks', trans('payment.Add a new bank account successfully.'));
                    }
                }
            }

            return redirect()->back()->with('eMessage_Banks', $eMessage);
        }

        return redirect()->back();
    }

    public function getIndex(Request $request)
    {
		$onsite     = Payment::where('code', 'onsite')->first();
        $credit     = Payment::where('code', 'credit_debit')->first();
        $bank       = Payment::where('code', 'thaibanks')->first();
        $banks      = Bank::all();

		$this->params['onsite']		= $onsite;
		$this->params['credit']		= $credit;
        $this->params['banks']		= $banks;
        $this->params['bank']		= $bank;
        $this->params['request']	= $request;
        $this->params['menu']		= 'payment';

        return view('dashboard.payments.index', $this->params);
    }
}
