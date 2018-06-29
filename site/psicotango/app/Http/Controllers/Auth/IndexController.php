<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TwigBridge\Facade\Twig;

class IndexController extends Controller
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

    public function getViewLesson(Request $request){
        $loggedUser = Auth::user();
        
        return Twig::render('auth/view-lesson', [
            'logged_user'       => $loggedUser,
        ]);
    }
}
