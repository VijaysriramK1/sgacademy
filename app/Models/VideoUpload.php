<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoUpload extends Model
{
    protected $table='video_uploads';
    protected $fillable = [
        'title',
        'description',
        'youtube_link',
        'program_id',
        'section_id',
        'created_by',
        'institution_id',
    ];

    
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
