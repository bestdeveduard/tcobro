<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\PayerInfo;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Redirect;
use URL;

class PaymentController extends Controller
{
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }    

    public function payWithpaypal(Request $request)
    {
        $user_id = $request->get('user_id');
        $price = $request->get('price');
        $plan_id = $request->get('plan_id');
        $plan_duration = $request->get('plan_duration');
        
        \Session::put('user_id', $user_id);
        \Session::put('plan_id', $plan_id);
        \Session::put('plan_duration', $plan_duration);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();        
        $item_1->setName('Plan Item') /** item name **/
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setPrice($request->get('price')); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('price'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
            ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {                
                Flash::warning("Connection timeout");
                $msg = 'Connection timeout';
                return redirect('plan_pay')->with('msg', $msg);                
            } else {                
                Flash::warning("Some error occur, sorry for inconvenient");
                $msg = 'Some error occur, sorry for inconvenient';
                return redirect('plan_pay')->with('msg', $msg);                
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        \Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }        
        
        Flash::warning("Unknown error occurred");
        $msg = 'Unknown error occurred';
        return redirect('plan_pay')->with('msg', $msg);
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = \Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        \Session::forget('paypal_payment_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            Flash::warning("Unknown error occurred");
            $msg = 'Unknown error occurred';
            return redirect('plan_pay')->with('msg', $msg);            
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            
            $user_id = \Session::get('user_id');
            $plan_id = \Session::get('plan_id');
            $plan_duration = \Session::get('plan_duration');

            $business = DB::table('users')->orderBy('business_id','DESC')->first();

            $l = User::find($user_id);
            $l->business_id = $business->business_id + 1;
            $l->plan_id = $plan_id;
            $l->plan_status= 1;
            $l->plan_active_date = date('Y-m-d');
            $l->plan_expired_date = date_format(date_add(date_create(date('Y-m-d')),
                    date_interval_create_from_date_string($plan_duration.' days')),
                    'Y-m-d');
            $l->save();

            \Session::forget('user_id');
            \Session::forget('plan_id');
            \Session::forget('plan_duration');

            Flash::success("You have a plan and can login now.");
            $msg = "You have a plan and can login now.";
            return redirect('admin')->with('msg', $msg);
        }
        
        Flash::warning("Payment failed");
        $msg = 'Payment failed';
        return redirect('plan_pay')->with('msg', $msg);
    }
}
