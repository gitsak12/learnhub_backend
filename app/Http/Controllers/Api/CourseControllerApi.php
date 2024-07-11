<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;

class CourseControllerApi extends Controller
{
    //
    public function courseList()
    {
        //select method helps you to get select which database column you want to accept
        //if you dont give select that means you dont want to select any method 
        $result = Course::select('name', 'thumbnail', 'lesson_num', 'price', 'id')->get();
        return response()->json([
            'code' => 200,
            'msg' => 'Course list',
            'data' => $result
        ], 200);
    }

    public function courseDetail(Request $request)
    {
        try {
            $id = $request->id;
            $result = Course::where('id', '=', $id)->select(
                'id',
                'name',
                'user_token',
                'description',
                'thumbnail',
                'lesson_num',
                'video_length',
                'price',
            )->first();
            return response()->json(
                [
                    'code' => 200,
                    'mssg' => 'My course details is here',
                    'data' => $result,
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'code' => 500,
                    'msg' => $e->getMessage(),
                    'data' => null,
                ],
                500
            );
        }
    }


    public function authorCourseList(Request $request)
    {
        $token = $request->token;
        $result = Course::where('user_token', '=', $token)->
            select('id', 'name', 'thumbnail', 'price', 'lesson_num', 'score', 'description')->get();
        return response()->json(
            [
                'code' => 200,
                'msg' => 'Courses of Author',
                'data' => $result,
            ],
            200
        );
    }

    public function courseAuthor(Request $request)
    {
        $token = $request->token;
        $result = DB::table('admin_users')->where('token', '=', $token)->
            select('token', 'name', 'avatar', 'description')->first();
        return response()->json(
            [
                'code' => 200,
                'msg' => 'Course Author',
                'data' => $result,
            ],
            200
        );
    }

    public function coursesSearchDefault(Request $request)
    {
        $result = Course::where('recommended', '=', 1)
            ->select('name', 'thumbnail', 'lesson_num', 'price', 'id')->get();

        return response()->json([
            'code' => 200,
            'msg' => 'The default courses',
            'data' => $result
        ], 200);
    }
    public function coursesSearch(Request $request)
    {
        $search = $request->search;
        $result = Course::where('name', 'like', "%" . $search . "%")
            ->select('name', 'thumbnail', 'lesson_num', 'price', 'id')->get();

        return response()->json([
            'code' => 200,
            'msg' => 'The Courses You search',
            'data' => $result
        ], 200);
    }

}
