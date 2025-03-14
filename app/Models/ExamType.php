<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    protected $table = 'exam_types';

    protected $fillable = [
		'title','is_average','percentage','average_mark','percantage','status'
	];

}

