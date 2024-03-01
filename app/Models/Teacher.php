<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function sections()
    {
        return $this->hasMany(Section::class, 'teacher_works');
    }

    function gradeCourses()
    {
        return $this->belongsToMany(GradeCourse::class, 'teacher_works');
    }

    function courses()
    {
        return $this->hasManyThrough(Course::class,
            GradeCourse::class,
            '',
            ''
        );
    }

    function students()
    {
        return $this->hasManyThrough(Student::class, Section::class);
    }
}
