<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function getViewLesson(Request $request, $lesson_id){
        return Twig::render('auth/lesson/view', [
            'lesson_id'         => $lesson_id
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
