<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentIdCard
 * 
 * @property int $id
 * @property string|null $role_id
 * @property int|null $student_id
 * @property int|null $staff_id
 * @property string|null $layout
 * @property string|null $profile_layout
 * @property string|null $logo
 * @property string|null $background_image
 * @property string|null $pageLayoutWidth
 * @property string|null $pageLayoutHeight
 * @property string $admission_no
 * @property string $student_name
 * @property string $program
 * @property string $father_name
 * @property string $mother_name
 * @property string $student_address
 * @property string $phone_number
 * @property string $dob
 * @property string $blood
 * @property string|null $signature
 * @property int $institution_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Institution $institution
 * @property Staff|null $staff
 * @property Student|null $student
 *
 * @package App\Models
 */
class StudentIdCard extends Model
{
	protected $table = 'student_id_cards';

	protected $casts = [
		'student_id' => 'int',
		'staff_id' => 'int',
		'institution_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'student_id',
		'staff_id',
		'layout',
		'profile_layout',
		'logo',
		'background_image',
		'pageLayoutWidth',
		'pageLayoutHeight',
		'admission_no',
		'student_name',
		'program',
		'father_name',
		'mother_name',
		'student_address',
		'phone_number',
		'dob',
		'blood',
		'signature',
		'institution_id'
	];

	public function institution()
	{
		return $this->belongsTo(Institution::class);
	}

	public function staff()
	{
		return $this->belongsTo(Staff::class);
	}

	public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
