<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];

    function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    function students()
    {
        return $this->hasMany(Student::class);
    }

    function sections()
    {
        return $this->belongsToMany(GradeCourse::class,
            'courses_sections',
            'section_id',
            'course_id'
        );
    }
}
