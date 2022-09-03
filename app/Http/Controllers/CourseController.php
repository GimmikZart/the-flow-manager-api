<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Resources\Course as CourseResource;
use App\Http\Resources\CourseCollection;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        //return new CourseCollection(Course::all());
        $courses = Course::all();
        foreach ($courses as $key => $course) {
            $course->totalStudents = DB::table('courses_students')
                ->where('course_id', '=', $course->courses_id)
                ->count();
            $course->activeStudents = DB::table('courses_students')
                ->where('course_id', '=', $course->courses_id)
                ->where('active', '=', 0)
                ->count();
            $course->unpaidCounter = DB::table('courses_students')
                ->where('course_id', '=', $course->courses_id)
                ->where('courses_students.active', '=', 0)
                ->join('payments', 'payments.course_instance_id', '=', 'courses_students.courses_students_id')
                ->where('payments.status', '=', null)
                ->count();
        }

        return $courses;
    }

    public function show($id)
    {
        return new CourseResource(Course::findOrFail($id));
    }

    public function list()
    {
        $courses = Course::all();
        return $courses;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $player = Course::create($request->all());

        return (new CourseCollection($player))
            ->response()
            ->setStatusCode(201);
    }

    public function delete($id)
    {
        $player = Course::findOrFail($id);
        $player->delete();

        return response()->json(null, 204);
    }
}
