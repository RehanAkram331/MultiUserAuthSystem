<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'fee', 'hours'
    ];

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }
}
