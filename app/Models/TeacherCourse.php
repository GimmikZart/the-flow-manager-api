<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    use HasFactory;
    protected $primaryKey = 'courses_teachers_id';
    public $table = 'courses_teachers';
    public $timestamps = false;

    protected $fillable = ['teacher_id', 'course_id', 'active', 'start_date', 'end_date', 'type', 'work_hours', 'unit'];
}
