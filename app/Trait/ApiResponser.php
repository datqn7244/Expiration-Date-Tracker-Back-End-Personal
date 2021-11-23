<?php

namespace App\Traits;


trait ApiResponser
{
	protected function successResoponse($data, $message = null, $code = 200)
	{
		return response()->json([
			'status' => 'Success',
			'message' => $message,
			'data' => $data
		], $code);
	}
	protected function errorResoponse($message = null, $code)
	{
		return response()->json([
			'status' => 'Error',
			'message' => $message
		], $code);
	}
}
