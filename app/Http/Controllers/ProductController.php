<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\ApiController;

class ProductController extends ApiController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$name = $request->query('name') ? $request->query('name') : '';
		$barcode = $request->query('barcode') ? $request->query('barcode') : null;
		if ($barcode) {
			return Product::where('barcode', $barcode)->get();
		}
		$query = Product::where('name', 'like', "%{$name}%");

		return Product::where('name', 'like', "%{$name}%")->get();
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
			'name' => 'required|unique:products',
			'barcode' => 'unique:products',
			'category_id' => 'required'
		]);
		return Product::create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		// $product = Product::find($id);
		// if($product){
		// 	return $product;
		// }
		return Product::find($id);
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
		$product = Product::find($id);

		$product->update($request->all());
		return $product;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		return Product::destroy($id);
	}
	/**
	 * Find the specified resource from storage based on name.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function findByName(Request $request)
	{
		return Product::where('name', 'like', "%{$request->query('name')}%")->get();
	}
	/**
	 * Find the specified resource from storage based on barcode.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function findByBarcode(Request $request)
	{
		return Product::where('barcode', $request->query('barcode'))->get();
	}
}
