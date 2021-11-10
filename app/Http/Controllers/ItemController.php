<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$page = $request->query('page') ? intval($request->query('page')) : 0;
		$name = $request->query('name') ? $request->query('name') : '';
		$barcode = $request->query('barcode') ? $request->query('barcode') : null;
		$sort = $request->query('sort') ? $request->query('sort') : 'exp-asc';
		if ($barcode) {
			return Item::where('barcode', $barcode)->get();
		}
		$query = Item::where('name', 'like', "%{$name}%");
		switch ($sort) {
			case 'name-asc':
				$query = $query->orderBy('name', 'asc');
				break;
			case 'name-desc':
				$query = $query->orderBy('name', 'desc');
				break;
			case 'exp-asc':
				$query = $query->latest('expire_date');
				break;
			case 'exp-desc':
				$query = $query->latest('expire_date');
				break;
			case 'price-asc':
				$query = $query->orderBy('price', 'asc');
				break;
			case 'price-desc':
				$query = $query->orderBy('price', 'desc');
				break;
		}
		return $query->skip($page * 10)->take(10)->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'product_id' => 'required',
		]);
		$request->merge([
			'expire_date' => today()
		]);
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
		return Item::find($id);
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
