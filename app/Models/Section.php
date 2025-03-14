<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $fillable = ['name', 'institution_id'];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
