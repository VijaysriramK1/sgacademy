<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
        protected $table = 'lessons';
    protected $fillable = ['module_id', 'title', 'content'];

    public function module()
    {
        return $this->belongsTo(Modules::class,'module_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function SubTopic()
    {
        return $this->hasMany(subtopic::class);
    }
}
