<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AjaxResponse;

class ApiController extends Controller
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

    public function getLesson(Request $request, AjaxResponse $ajax, $lesson_id){
        try {
            return $ajax->success(\Models\Lesson::find($lesson_id));
        } catch (\Exception $e){
            return $ajax->error($e->getMessage());
        }
    }

    public function getLoggedUserCourses(Request $request, AjaxResponse $ajax){
        try {
            $loggedUser = Auth::user();
            $userCourses = \Models\Plan::with('courses.lessons')->where('id', '=', $loggedUser->plan_id)->first()['courses'];
            return $ajax->success($userCourses);
        } catch (\Exception $e){
            return $ajax->error($e->getMessage());
        }
    }
}