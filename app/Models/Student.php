<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'grade',
        'user_id'
    ];


    public function periods()
    {
        return $this->belongsToMany(Period::class, 'student_periods');
    }

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }


}
