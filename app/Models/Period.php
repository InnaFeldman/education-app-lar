<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'teacher_id'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_periods');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'teacher_id')->withTrashed();
    }
}
