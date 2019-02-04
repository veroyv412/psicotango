<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Exception;
use TwigBridge\Facade\Twig;
use App\Services\AjaxResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $_paypalContext;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->_paypalContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            ));

        $sandbox = config('app.env') == 'local' ? true : false;
        if ( $sandbox ){
            $this->_paypalContext->setConfig(array(
                'mode' => 'sandbox',
                'service.EndPoint' => 'https://api.sandbox.paypal.com',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'FINE'
            ));
        } else {
            $this->_paypalContext->setConfig(array(
                'mode' => 'live',
                'service.EndPoint' => 'https://api.paypal.com',
                'http.ConnectionTimeOut' => 30,
                'log.LogEnabled' => true,
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => 'FINE'
            ));
        }
    }

    public function getCourses(){
        $user = Auth::user();
        if ( empty($user->plan_id) ){
            return Twig::render('auth/select-plan', []);
        } else {
            return Twig::render('auth/courses', [
                'tab' => 'courses'
            ]);
        }
    }

    public function getCheckoutPlan(Request $request, $plan_id){
        $user = Auth::user();
        $trans = app('translator');

        $plan_id = request('plan_id');
        $plan = \Models\Plan::find($plan_id);
        if ( empty($plan) ) {
            Session::flash('error', $trans->get('messages.invalid_plan'));
            return redirect('/');
        }

        $PayerInfo = new \PayPal\Api\PayerInfo();
        $PayerInfo->setShippingAddress(null);

        $payer = new \PayPal\Api\Payer();
        $payer->setPayerInfo($PayerInfo);
        $payer->setPaymentMethod('paypal');

        $item1 = new \PayPal\Api\Item();
        $item1->setName($plan->name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku($plan->name) // Similar to `item_number` in Classic API
            ->setPrice($plan->price);

        $itemList = new \PayPal\Api\ItemList();
        $itemList->setItems(array($item1));

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($plan->price);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setItemList($itemList);
        $transaction->setAmount($amount);
        $transaction->setDescription($plan->name);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl(url('/checkout/paypal-success/user/'.$user->id.'/plan/'.$plan_id))
            ->setCancelUrl(url('/checkout/paypal-cancel/user/'.$user->id.'/plan/'.$plan_id));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->_paypalContext);
            return redirect($payment->getApprovalLink());
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            Session::flash('error', $ex->getMessage());
            return redirect('/');
        }
    }

    public function getPaypalSuccess(Request $request, $user_id, $plan_id){
        $trans = app('translator');

        $payment = \PayPal\Api\Payment::get($request->get('paymentId'), $this->_paypalContext);
        if (!empty($payment)){

            try {
                $execution = new PaymentExecution();
                $execution->setPayerId($request->get('PayerID'));

                $result = $payment->execute($execution, $this->_paypalContext);

                Log::debug('===== LOG for PaymentID : ' . $request->get('paymentId') . ' =====');
                Log::debug($result);

                $user = Auth::user();
                $user->plan_id = $plan_id;
                $user->save();

                $plan = \Models\Plan::find($plan_id);

                $registration = new \Models\Registration();
                $registration->user_id = $user->id;
                $registration->user_name = $user->name;
                $registration->user_lastname = $user->last_name;
                $registration->plan_id = $plan_id;
                $registration->price = number_format($plan->price, 2);
                $registration->payment_id = $request->get('paymentId');
                $registration->paypal_payer_id = $request->get('PayerID');
                $registration->method = 'paypal';

                $fee = (25*$plan->price)/100;
                $registration->fee_price = number_format( $fee, 2);
                $registration->save();

                Mail::send('emails.welcome', ['plan' => $plan], function ($m) use ($user){
                    $m->from('info@psicotango.com', 'Psicotango');
                    $m->to($user->email, $user->name)->subject('Bienvenidos a Psicotango');
                });

                Mail::send('emails.welcome', ['plan' => $plan], function ($m) use ($user){
                    $m->from('psicotango@gmail.com', 'Psicotango');
                    $m->to('veroyv412@gmail.com', 'Veronica')->subject('Bienvenidos a Psicotango');
                });

                Mail::send('emails.welcome', ['plan' => $plan], function ($m) use ($user){
                    $m->from('psicotango@gmail.com', 'Psicotango');
                    $m->to('perimonica1@gmail.com', 'Monica Peri')->subject('Bienvenidos a Psicotango');
                });

                Mail::send('emails.welcome', ['plan' => $plan], function ($m) use ($user){
                    $m->from('psicotango@gmail.com', 'Psicotango');
                    $m->to('nacholavalle@hotmail.com', 'Ignacio Lavalle')->subject('Bienvenidos a Psicotango');
                });

                Session::flash('success', $trans->get('messages.welcome_payment'));
                return redirect('/courses');
            } catch (\PayPal\Exception\PayPalConnectionException $ex) {
                Session::flash('error', $ex->getMessage());
                return redirect('/');
            }
        }

        Session::flash('error', $trans->get('messages.error_with_payment'));
        return redirect('/');
    }

    public function getPaypalPayment(Request $request){
        try {
            $payment = \PayPal\Api\Payment::get($request->get('paymentId'), $this->_paypalContext);
            dd($payment);
        } catch (Exception $e){
            dd($e->getMessage());
        }

    }

    public function getPaypalExecution(Request $request){
        try {
            $payment = \PayPal\Api\Payment::get($request->get('paymentId'), $this->_paypalContext);

            $execution = new PaymentExecution();
            $execution->setPayerId($request->get('PayerID'));

            $result = $payment->execute($execution, $this->_paypalContext);

            dd($result);
        } catch (Exception $e){
            dd($e->getMessage());
        }

    }

    public function getPaypalCancel(Request $request){
        return Twig::render('paypal-cancel', ['tab' => 'paypal-cancel']);
    }

    public function postCheckoutPlan(Request $request, AjaxResponse $ajax){
        $trans = app('translator');

        $plan_id = request('plan_id');
        $plan = \Models\Plan::find($plan_id);
        if ( empty($plan) ){
            return response()->json([
                'errors' => [
                    [ 'code' => 'invalid_plan', 'description' => $trans->get('messages.invalid_plan') ]
                ]
            ], 400);
        }

        try {
            $user = Auth::user();
            $user->plan_id = request('plan_id');
            //$user->save();

            $mercadoPago = \Models\MercadoPago::first();
            if ( !empty($mercadoPago) ){
                $userToken = $mercadoPago->mp_access_token;

                $dateTimeExpires = new \DateTime();
                $dateTimeExpires->setTimestamp($mercadoPago->mp_expires_in);

                $today = new \DateTime();
                if ( $today >= $dateTimeExpires ){
                    //$userToken = $this->refreshToken();
                }

                $mp = new \MP($userToken);
                $mp->sandbox_mode(true);

                $payment_data = array(
                    "transaction_amount" => floor($plan->price),
                    "token" => request('card_token'),
                    "description" => $plan->name,
                    "installments" => 1,
                    "payer" => array (
                        "id" => $mercadoPago->mp_user_id
                    ),
                    "payment_method_id" => request('payment_method'),
                    "application_fee" => 2.56
                );

                $payment = $mp->post("/v1/payments", $payment_data);

                return $ajax->success([
                    'user' => $user,
                    'message' => $trans->get('messages.payment_successfully')
                ]);
            }
        } catch (\Exception $e){
            return response()->json([
                'errors' => [
                    [ 'code' => $e->getCode(), 'description' => $e->getMessage() ]
                ]
            ], 400);
        }

    }

    public function getViewLesson(Request $request, $lesson_id){
        $trans = app('translator');

        $user = Auth::user();
        $lesson = \Models\Lesson::with('course.plans')->find($lesson_id);
        if ( empty($lesson)){
            Session::flash('error', $trans->get('messages.invalid_lesson'));
            return redirect('/courses');
        }

        $plans = $lesson->course->plans()->get()->toarray();
        if ( array_search($user->plan_id, array_column($plans, 'id')) === false ){
            Session::flash('error', $trans->get('messages.invalid_lesson'));
            return redirect('/courses');
        }

        return Twig::render('auth/lesson/view', [
            'lesson' => $lesson,
            'lesson_id' => $lesson_id,
            'tab' => 'courses'
        ]);
    }

    public function getProfile(Request $request){
        return Twig::render('auth/profile', []);
    }

    public function postProfile(Request $request, AjaxResponse $ajax){
        $trans = app('translator');

        $user = Auth::user();

        if ( $user->email !=  request('email')){
            $this->validate($request, [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255'
            ]);
        }


        $user = Auth::user();
        $user->name = request('name');
        $user->last_name = request('last_name');
        $user->email = request('email');
        $user->save();

        Session::flash('success', $trans->get('messages.profile_settings_saved_successfully'));

        return $ajax->success([
            'user' => $user,
            'message' => $trans->get('messages.profile_settings_saved_successfully')
        ]);
    }

}
