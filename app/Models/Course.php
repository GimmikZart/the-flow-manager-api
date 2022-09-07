<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = 'courses_id';
    public $timestamps = false;

    protected $fillable = ['name', 'price'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'student_id', 'course_id')
            ->withPivot('active', 'start_date', 'end_date');
    }
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teacher', 'teacher_id', 'course_id')
            ->withPivot('active', 'start_date', 'end_date');
    }
}
