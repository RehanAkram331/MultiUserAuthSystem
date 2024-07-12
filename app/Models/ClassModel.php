<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name', 'teacher_id', 'course_id', 'description', 'start_time', 'end_time'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'classe_id');
    }
    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_enrolls', 'classe_id', 'student_id')
                    ->withPivot('fee', 'status')
                    ->wherePivot('status', 1)
                    ->withTimestamps();
    }
}
