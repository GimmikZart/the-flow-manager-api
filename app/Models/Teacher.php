<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $primaryKey = 'teachers_id';

    protected $fillable = ['name', 'lastname', 'gender', 'dateOfBirth', 'registered', 'avatar', 'email',  'fiscalCode', 'telephone'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_teachers', 'teacher_id', 'course_id')
            ->withPivot('active', 'start_date', 'end_date');
    }
}
