<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeCourse extends Model
{
    use HasFactory;
    protected $guarded = [];


    function sections()
    {
        return $this->belongsToMany(Section::class,
            'courses_sections',
            'course_id',
            'section_id'
        );
    }
}
