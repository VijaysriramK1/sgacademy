<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceType extends Model
{
    protected $table = 'source_types';
    protected $fillable = ['name', 'description','status','institution_id'];
}
