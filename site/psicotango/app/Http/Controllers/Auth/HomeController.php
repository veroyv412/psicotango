<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mockery\Exception;
use TwigBridge\Facade\Twig;
use App\Services\AjaxResponse;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCheckoutPlan(Request $request, $plan_id){
        return Twig::render('auth/checkout-plan', [
            'plan_id'           => $plan_id,
            'mp_public_key'     => config('mercadopago.credentials.public_key')
        ]);
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

    public function refreshToken(){

    }

    public function getViewLesson(Request $request, $lesson_id){

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
