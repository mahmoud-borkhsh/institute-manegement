<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    function sections()
    {
        return $this->hasMany(Section::class);
    }

    function courses()
    {
        return $this->belongsToMany(Course::class,'grades_courses');
    }
}
