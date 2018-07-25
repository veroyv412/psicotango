<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TwigBridge\Facade\Twig;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\LaravelLocalization;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getHome(Request $request){
        if ( !empty(Auth::check()) ){
            return Twig::render('auth/index', []);
        } else {
            return Twig::render('index', []);
        }
    }
    
    public function getMercadoPagoConnectRedirect(Request $request){
        try {
            $trans = app('translator');
            $mpCode = $request->get('code');
            $accessToken = config('mercadopago.credentials.access_token');
            $redirectUrl = url('/mpconnect-redirect');
            $locale = App::getLocale();

            $mp = new \MP($accessToken);

            $data = array(
                "uri" => "/oauth/token",
                "data" => array(
                    "client_secret" => $mp->get_access_token(),
                    "grant_type" => "authorization_code",
                    "code" => $mpCode,
                    "redirect_uri" => $redirectUrl
                ),
                "headers" => array(
                    "content-type" => "application/x-www-form-urlencoded"
                ),
                "authenticate" => false
            );

            $results = $mp->post($data);

            $user = Auth::user();
            $user->mp_access_token = $results['response']['access_token'];
            $user->mp_refresh_token = $results['response']['refresh_token'];
            $user->mp_user_id = $results['response']['user_id'];
            $user->mp_expires_id = $results['response']['expires_in'];
            $user->save();

            Session::flash('success', $trans->get('messages.mercadopago_connect_success'));
        } catch (\Exception $e){
            Session::flash('error', $e->getMessage());
        }

        redirect('/');
    }
    
    /* Email */
    public function getEmailUserByDeal(Request $request){
        $loggedUser = Auth::user();
        $deal = \Models\Deal::with('category')
            ->with('business')
            ->with('images')
            ->where('id', '=', 3)
            ->first();

        /*Mail::send('emails.user_buy_deal', [], function ($m) {
            $m->from('hello@app.com', 'Your Application');
            $m->to('veroyv412@gmail.com', 'Veronica Test')->subject('Tu Coupon de Descuento');
        });*/

        return Twig::render('emails.user_buy_deal', ['deal' => $deal, 'logged_user' => $loggedUser]);
    }
    
    public function getEmailBusinessByDeal(Request $request){
        $loggedUser = Auth::user();
        $deal = \Models\Deal::with('category')
            ->with('business')
            ->with('images')
            ->where('id', '=', 3)
            ->first();

        return Twig::render('emails.business_buy_deal', ['deal' => $deal, 'logged_user' => $loggedUser]);
    }
}
