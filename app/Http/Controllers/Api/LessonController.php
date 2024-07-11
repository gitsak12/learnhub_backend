<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{
    //
    public function lessonList(Request $request)
    {
        $id = $request->id;
        try {
            $result = Lesson::where('course_id', '=', $id)->select(
                'id',
                'name',
                'description',
                'thumbnail',
                'video',
            )->get();
            return response()->json([
                'code' => 200,
                'message' => 'My lesson List is here',
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'msg' => 'Internal serve error',
                'data' => $e->getMessage(),
            ], 500);
        }
    }
    public function lessonDetail(Request $request)
    {
        $id = $request->id;
        try {
            $result = Lesson::where('id', '=', $id)->select(
                'name',
                'description',
                'thumbnail',
                'video',
            )->first();
            return response()->json([
                'code' => 200,
                'message' => 'My lesson Detail is here',
                'data' => $result->video,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'msg' => 'Internal serve error',
                'data' => $e->getMessage(),
            ], 500);
        }
    }
}
