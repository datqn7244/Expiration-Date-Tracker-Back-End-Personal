<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;
	protected $fillable = [
		'name',
		'category_id',
		'description',
		'barcode',
		'img_url',
		'price'
	];

	protected $attributes = [
		'price' => 1
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function item()
	{
		return $this->hasMany(Item::class);
	}
}
