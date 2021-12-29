<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Product;

class ItemController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		// $page = $request->query('page') ? intval($request->query('page')) : 0;
		$sort = $request->query('sort') ? $request->query('sort') : 'exp-asc';
		$query = Item::select('items.*')->join('products', 'products.id', '=', 'items.product_id');
		foreach (explode(",", $sort) as $sortBy) {
			$query = match ($sortBy) {
				'name-asc' => $query->orderBy('products.name', 'asc'),
				'name-desc' => $query->orderBy('products.name', 'desc'),
				'exp-asc' => $query->oldest('expire_date'),
				'exp-desc' => $query->latest('expire_date'),
				// 'price-asc' => $query->orderBy('price', 'asc'),
				// 'price-desc' => $query->orderBy('price', 'desc'),
			};
		}

		$items = $query->paginate(10);
		// skip($page * 10)->take(10)->get();
		foreach ($items as $item) {
			$item->product->category;
			$item->tag;
		}
		return $this->successResponse($items);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if ($request->input('product_id')) {
			$request->validate([
				'product_id' => 'required',
			]);
		} else {
			$request->validate([
				'name' => 'required|unique:products',
				'barcode' => 'unique:products',
				'category_id' => 'required'
			]);

			$product = Product::create($request->all());
			$request->merge(['product_id' => $product->id]);
		}
		if (!$request->input('expire_date')) {
			$request->merge([
				'expire_date' => today()
			]);
		}
		return Item::create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$item =  Item::find($id);
		if ($item) {
			$item->product->category;
			$item->tag;
			return $item;
		}
		return [
			'status' => 'error',
			'message' => 'Item not found'
		];
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'product_id' => 'required',
			'expire_date' => 'required',
		]);
		$item = Item::find($id);

		$item->update($request->all());
		return $item;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		return Item::destroy($id);
	}
}
