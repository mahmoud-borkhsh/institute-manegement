<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentStudent extends Model
{
    use HasFactory;
    protected $guarded = [];

    function student()
    {
        return $this->belongsTo(Student::class);
    }
}
