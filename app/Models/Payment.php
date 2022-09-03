<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'payments_id';
    public $timestamps = false;
    protected $fillable = ['value', 'month', 'year', 'date_of_payment', 'course_instance_id', 'student_id', 'status'];
}
