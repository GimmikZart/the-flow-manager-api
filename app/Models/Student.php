<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey = 'students_id';
    protected $fillable = ['name', 'lastname', 'gender', 'dateOfBirth', 'registered', 'avatar', 'email', 'fiscalCode', 'telephone'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_students', 'student_id', 'course_id')
            ->withPivot('active', 'start_date', 'end_date');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
