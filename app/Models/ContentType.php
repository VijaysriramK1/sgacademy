<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $table = 'content_types';

    protected $fillable = [
        'name', 
        'description', 
        'created_by', 
        'updated_by', 
        'institution_id',
    ];
}
