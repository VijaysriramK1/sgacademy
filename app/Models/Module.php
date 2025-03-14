<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $fillable = ['title', 'content', 'status', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}
