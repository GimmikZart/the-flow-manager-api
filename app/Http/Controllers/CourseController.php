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
        $course = Course::findOrFail($id);

        $course['active_students'] = DB::table('courses_students')
            ->join('students', 'students.students_id', '=', 'courses_students.student_id')
            ->where([
                ['courses_students.course_id', '=', $id],
                ['courses_students.active', '=', 0]
            ])
            ->select('students.students_id', 'students.name', 'students.lastname', 'students.gender', 'students.telephone', 'students.email', 'students.fiscalCode', 'courses_students.start_date')
            ->get();

        $course['past_students'] = DB::table('courses_students')
            ->join('students', 'students.students_id', '=', 'courses_students.student_id')
            ->where([
                ['courses_students.course_id', '=', $id],
                ['courses_students.active', '=', 1]
            ])
            ->select('students.students_id', 'students.name', 'students.lastname', 'students.gender', 'students.telephone', 'courses_students.start_date', 'courses_students.end_date')
            ->get();

        return $course;
    }

    public function list()
    {
        $courses = Course::all();
        return $courses;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
        ]);

        $course = Course::create($request->all());

        return $course;
    }

    public function delete($id)
    {
        $player = Course::findOrFail($id);
        $player->delete();

        return response()->json(null, 204);
    }
}
