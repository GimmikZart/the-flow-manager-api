<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherCourse as WorkingTeacher;
use App\Http\Resources\Teacher as TeacherResource;
use App\Http\Resources\TeacherCollection;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = DB::table('teachers')
            ->get();

        foreach ($teachers as $key => $teacher) {
            $teacher->courseNumber = DB::table('courses_teachers')
                ->where('teacher_id', '=', $teacher->teachers_id)
                ->count();

            $teacher->activeCourseNumber = DB::table('courses_teachers')
                ->where('teacher_id', '=', $teacher->teachers_id)
                ->where('active', '=', 0)
                ->count();

            $teacher->salaries = DB::table('salaries')
                ->where('teacher_id', '=', $teacher->teachers_id)
                ->where('status', '=', null)
                ->count();
        }
        return  $teachers;
        //return new TeacherCollection(Teacher::all());
    }

    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);

        $teacher['courses'] = DB::table('courses_teachers')
            ->join('courses', 'courses.courses_id', '=', 'courses_teachers.course_id')
            ->where('courses_teachers.teacher_id', '=', $id)
            ->select('courses_teachers.courses_teachers_id', 'name', 'start_date', 'end_date', 'course_id', 'active', 'type', 'unit', 'work_hours')
            ->get();

        $teacher['salaries'] = DB::table('salaries')

            ->join('courses_teachers', 'salaries.course_instance_id', '=', 'courses_teachers.courses_teachers_id')
            ->join('courses', 'courses_teachers.course_id', '=', 'courses.courses_id')
            ->where('salaries.teacher_id', '=', $id)
            ->select('courses_teachers.unit', 'salaries.salaries_id', 'name', 'value', 'date_of_payment', 'course_id', 'month', 'year', 'status', 'work_hours', 'salaries.type')
            ->get();

        return $teacher;
    }

    public function store(Request $request)
    {
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->lastname = $request->lastname;
        $teacher->gender = $request->gender;
        $teacher->email = $request->email;
        $teacher->telephone = $request->telephone;
        $teacher->avatar = $request->avatar;
        $teacher->dateOfBirth = $request->dateOfBirth;
        $teacher->registered = $request->registered;

        $teacher->save();

        return (new TeacherResource($teacher))
            ->response()
            ->setStatusCode(201);
    }

    public function edit(Request $request)
    {
        $teacher = Teacher::findOrFail($request->id);
        $teacher->name = $request->name;
        $teacher->lastname = $request->lastname;
        $teacher->gender = $request->gender;
        $teacher->email = $request->email;
        $teacher->telephone = $request->telephone;
        $teacher->avatar = $request->avatar;
        $teacher->dateOfBirth = $request->dateOfBirth;
        $teacher->registered = $request->registered;

        $teacher->save();
        return (new TeacherResource($teacher))
            ->response()
            ->setStatusCode(201);
    }

    public function delete($id)
    {
        $player = Teacher::findOrFail($id);
        $player->delete();

        return response()->json(null, 204);
    }


    public function singleHireTeacher(Request $request)
    {
        if (WorkingTeacher::where('teacher_id', $request->teacher_id)->where('course_id', $request->course_id)->where('active', '==', 0)->exists()) {
            return response("esiste già");
        } else {
            $subscription = new WorkingTeacher();
            $subscription->teacher_id = $request->teacher_id;
            $subscription->course_id = $request->course_id;
            $subscription->active = 0;
            $subscription->type = $request->type;
            $subscription->unit = $request->unit;
            $subscription->work_hours = $request->work_hours;
            $subscription->start_date = $request->start_date;

            $subscription->save();
            return response('done');
        }
    }

    public function fireTeacher($id)
    {
        $subscription = WorkingTeacher::findOrFail($id);
        $subscription->active = 1;
        $subscription->end_date = date('Y-m-d');

        $subscription->save();
    }
    public function reHireTeacher(Request $request)
    {
        if (WorkingTeacher::where('teacher_id', $request->teacher_id)->where('course_id', $request->course_id)->where('active', '==', 0)->exists()) {
            return response("esiste già");
        } else {
            $subscription = WorkingTeacher::findOrFail($request->subscription_id);
            $subscription->active = 0;
            $subscription->end_date = null;

            $subscription->save();
            return response('done');
        }
    }
}
