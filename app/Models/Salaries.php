<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salaries extends Model
{
    use HasFactory;
    protected $primaryKey = 'salaries_id';
    public $timestamps = false;
    protected $fillable = ['value', 'month', 'year', 'date_of_payment', 'course_instance_id', 'techer_id', 'status', 'type'];
}
