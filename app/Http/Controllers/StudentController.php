<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use App\Http\Resources\Student as StudentResource;
use App\Http\Resources\StudentCollection;

use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        //return new StudentCollection(Student::all());
        $students = DB::table('students')
            /* ->join('courses_students', 'students.id', '=', 'courses_students.student_id') */
            ->get();

        foreach ($students as $key => $student) {
            $student->courseNumber = DB::table('courses_students')
                ->where('student_id', '=', $student->students_id)
                ->count();

            $student->activeCourseNumber = DB::table('courses_students')
                ->where('student_id', '=', $student->students_id)
                ->where('active', '=', 0)
                ->count();

            $student->payment = DB::table('payments')
                ->where('student_id', '=', $student->students_id)
                ->where('status', '=', null)
                ->count();
        }
        return $students;
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        /* $student['courses'] = $student->courses;
        $student['payments'] = $student->payments; */

        $student['courses'] = DB::table('courses_students')
            ->join('courses', 'courses.courses_id', '=', 'courses_students.course_id')
            ->where('courses_students.student_id', '=', $id)
            ->select('courses_students.courses_students_id', 'name', 'start_date', 'end_date', 'course_id', 'active')
            ->get();

        $student['payments'] = DB::table('payments')

            ->join('courses_students', 'payments.course_instance_id', '=', 'courses_students.courses_students_id')
            ->join('courses', 'courses_students.course_id', '=', 'courses.courses_id')
            ->where('payments.student_id', '=', $id)
            ->select('payments.payments_id', 'name', 'value', 'date_of_payment', 'course_id', 'month', 'year', 'status')
            ->get();

        return  $student;
    }

    public function store(Request $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->lastname = $request->lastname;
        $student->gender = $request->gender;
        $student->email = $request->email;
        $student->telephone = $request->telephone;
        $student->avatar = $request->avatar;
        $student->dateOfBirth = $request->dateOfBirth;
        $student->registered = $request->registered;

        $student->save();

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(201);
    }

    public function edit(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->name = $request->name;
        $student->lastname = $request->lastname;
        $student->gender = $request->gender;
        $student->email = $request->email;
        $student->telephone = $request->telephone;
        $student->avatar = $request->avatar;
        $student->dateOfBirth = $request->dateOfBirth;
        $student->registered = $request->registered;

        $student->save();
        return (new StudentResource($student))
            ->response()
            ->setStatusCode(201);
    }

    public function delete($id)
    {
        $player = Student::findOrFail($id);
        $player->delete();

        return response()->json(null, 204);
    }
}
