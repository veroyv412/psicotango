<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TwigBridge\Facade\Twig;

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
}
