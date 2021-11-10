<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'expire_warning_limit',
		'first_default_notification',
		'second_default_notification',
		'third_default_notification',
		'position',
		'color',
	];
	public function product()
	{
		return $this->hasMany(Product::class);
	}
}
