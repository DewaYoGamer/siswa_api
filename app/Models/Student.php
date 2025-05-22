<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['nisn', 'grade', 'parent_name', 'parent_phone', 'user_id'];
    protected $with = ['user', 'schedules'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'student_schedules');
    }
}
