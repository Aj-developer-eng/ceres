<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Payment;
 
class StripePaymentController extends Controller
{
    public $gateway;
    public $completePaymentUrl;
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('Stripe\PaymentIntents');
        $this->gateway->setApiKey('sk_test_51IL0JKItgQ1JK2jSVGZ44VxRph1XLOOTSBet2RQhO6tWwmBb62zfZftk2xxlUubTQyZL0dDZdncDrVBN2tEqMY2f00gK5XnMad');
        $this->completePaymentUrl = url('confirm');
    }
 
    public function index()
    {
        return view('admin/frontend/pages/stripe');
    }
 
    public function charge(Request $request)
    {

        if($request->input('stripeToken'))
        {
            $token = $request->input('stripeToken');
 
            $response = $this->gateway->authorize([
                'amount' => $request->input('amount'),
                'currency' =>'USD',
                'description' => 'This is a X purchase transaction.',
                'token' => $token,
                'returnUrl' => $this->completePaymentUrl,
                'confirm' => true,
            ])->send();
 
            if($response->isSuccessful())
            {
                $response = $this->gateway->capture([
                    'amount' => $request->input('amount'),
                    'currency' => 'USD',
                    'paymentIntentReference' => $response->getPaymentIntentReference(),
                ])->send();
 
                $arr_payment_data = $response->getData();
 
                $this->store_payment([
                    'payment_id' => $arr_payment_data['id'],
                    'payer_email' => $request->input('email'),
                    'amount' => $arr_payment_data['amount']/100,
                    'currency' => 'USD',
                    'payment_status' => $arr_payment_data['status'],
                ]);
 echo "<pre>";
         print_r($arr_payment_data);die;
                return redirect("payment")->with("success", "Payment is successful. Your payment id is: ". $arr_payment_data['id']);
            }
            elseif($response->isRedirect())
            {
                session(['payer_email' => $request->input('email')]);
                $response->redirect();
            }
            else
            {
                return redirect("payment")->with("error", $response->getMessage());
            }
        }
    }
 
    public function confirm(Request $request)
    {
        $response = $this->gateway->confirm([
            'paymentIntentReference' => $request->input('payment_intent'),
            'returnUrl' => $this->completePaymentUrl,
        ])->send();
        if($response->isSuccessful())
        {
            $response = $this->gateway->capture([
                'amount' => $request->input('amount'),
                'currency' => 'USD',
                'paymentIntentReference' => $request->input('payment_intent'),
            ])->send();
 
            $arr_payment_data = $response->getData();
 // dd($arr_payment_data);
            $this->store_payment([
                'payment_id' => $arr_payment_data['id'],
                'payer_email' => session('payer_email'),
                'amount' => $arr_payment_data['amount']/100,
                'currency' => 'USD',
                'payment_status' => $arr_payment_data['status'],
            ]);
 
            return redirect("payment")->with("success", "Payment is successful. Your payment id is: ". $arr_payment_data['id']);
        }
        else
        {
            return redirect("payment")->with("error", $response->getMessage());
        }
    }
 
    public function store_payment($arr_data = [])
    {
        $isPaymentExist = Payment::where('payment_id', $arr_data['payment_id'])->first();  
  
        if(!$isPaymentExist)
        {
            $payment = new Payment;
            $payment->payment_id = $arr_data['payment_id'];
            $payment->payer_email = $arr_data['payer_email'];
            $payment->amount = $arr_data['amount'];
            $payment->currency = 'USD';
            $payment->payment_status = $arr_data['payment_status'];
            $payment->save();
        }
    }
}