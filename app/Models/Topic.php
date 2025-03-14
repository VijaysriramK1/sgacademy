<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';
    protected $fillable = ['lesson_id', 'title','content','parent_id'];

    public function lesson()
    {
        return $this->belongsTo(lesson::class,'lesson_id');
    }

    public function parent()
    {
        return $this->belongsTo(Topic::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Topic::class, 'parent_id');
    }

    public function Subtopic()
    {
        return $this->hasMany(subtopic::class);
    }
}
