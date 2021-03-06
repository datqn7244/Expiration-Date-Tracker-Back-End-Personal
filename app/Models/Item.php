<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	use HasFactory;
	protected $fillable = [
		'product_id',
		'tag_id',
		'expire_date',
		'quantity',
		'quantity_unit'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}
}
