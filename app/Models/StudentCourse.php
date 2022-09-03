<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;
    protected $primaryKey = 'courses_students_id';
    public $table = 'courses_students';
    public $timestamps = false;

    protected $fillable = ['student_id', 'course_id', 'active', 'start_date', 'end_date'];
    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'payments');
    }
}
