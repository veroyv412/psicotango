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
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getHome(Request $request, LaravelLocalization $e){
        $loggedUser = Auth::user();

        if ( !empty($loggedUser) ){
            $userCourses = \Models\Plan::with('courses.lessons')->where('id', '=', $loggedUser->plan_id)->first()['courses'];

            return Twig::render('auth/index', [
                'logged_user'       => $loggedUser,
                'user_courses'      => $userCourses
            ]);
        } else {
            return Twig::render('index', []);
        }
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
