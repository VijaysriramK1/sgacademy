<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'contents';
    protected $fillable = [
        'file_name',
        'file_size',
        'content_type_id',
        'youtube_link',
        'upload_file',
        'uploaded_by',
        'institution_id',
    ];

    public function contentType()
    {
        return $this->belongsTo(ContentType::class, 'content_type_id');
    }

}
