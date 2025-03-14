<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'student_certificates';
    protected $fillable = [
        'name',
        'header_left_text',
        'date',
        'body',
        'body_two',
        'certificate_no',
        'type',
        'footer_left_text',
        'footer_center_text',
        'footer_right_text',
        'student_photo',
        'file',
        'layout',
        'body_font_family',
        'body_font_size',
        'height',
        'width',
        'default_for',
        'active_status',
        'institution_id',
    ];
}
