<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];


    function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    function gradeCourse()
    {
        return $this->belongsTo(GradeCourse::class);
    }
}
