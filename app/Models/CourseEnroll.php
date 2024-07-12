<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'classe_id', 'student_id', 'fee', 'status'
    ];

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'classe_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function getStatusAttribute($value)
    {
        return $value == self::STATUS_ACTIVE ? 'Active' : 'Inactive';
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value == 'Active' ? self::STATUS_ACTIVE : self::STATUS_INACTIVE;
    }
}
