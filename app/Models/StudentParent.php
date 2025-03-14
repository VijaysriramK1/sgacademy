<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'parents';
    protected $fillable = ['first_name', 'last_name', 'email', 'mobile', 'occupation', 'photo', 'address', 'user_id', 'institution_id'];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($data) {
            $user = User::create([
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'password' => Hash::make('123456'),
                'mobile' => $data->mobile,
                'user_type' => 'parent',
            ]);

            DB::table('parents')->where('email', $data->email)->update(['user_id' => $user->id]);
        });
    }

    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'student_parents',
            'parent_id',
            'student_id'
        )->withPivot('relation', 'status');
    }
}
