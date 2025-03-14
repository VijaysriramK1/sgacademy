<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Institution
 * 
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Institution extends Model
{
	protected $table = 'institutions';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'name',
		'type',
		'user_id'
	];

	public function User()
	{
		return $this->belongsTo(User::class);
	}
}
