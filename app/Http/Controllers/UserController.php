<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function register(Request $request)
	{
		$field = $request->validate([
			'name' => 'required|string',
			'email' => 'required|string|unique:users,email',
			'password' => 'required|string|confirmed'
		]);

		$user = User::create([
			'name' => $field['name'],
			'email' => $field['email'],
			'password' => Hash::make($field['password']),
		]);

		$token = $user->createToken('myapptoken')->plainTextToken;

		$response = [
			'user' => $user,
			'token' => $token
		];

		return response($response, 201);
		// $request->session()->regenerate();

		// return response()->json([], 204);

	}


	public function login(Request $request)
	{
		$field = $request->validate([
			'email' => 'required|string',
			'password' => 'required|string'
		]);
		// Token base
		if (Auth::guard()->attempt($request->only('email', 'password'))) {
			$user = User::where('email', $field['email'])->first();
			$token = $user->createToken('myapptoken')->plainTextToken;

			$response = [
				'user' => [
					'name' => $user->name,
					'email' => $user->email
				],
				'token' => $token
			];

			return response($response, 201);
		}

		// Check email

		// // Check password
		// if (!$user || !Hash::check($field['password'], $user->password)) {
		// 	return response([
		// 		'message' => 'Wrong email or password!'
		// 	]);
		// }

		// $token = $user->createToken('myapptoken')->plainTextToken;

		// $response = [
		// 	'user' => [
		// 		'name' => $user->name,
		// 		'email' => $user->email
		// 	],
		// 	'token' => $token
		// ];

		// return response($response, 201);

		// if (Auth::guard()->attempt($request->only('email', 'password'))) {
		// 	$request->session()->regenerate();

		// 	return response()->json([], 204);
		// }

		return response()->json(['error' => 'Invalid credentials']);
	}

	public function changePassword(Request $request, User $user)
	{
		$field = $request->validate([
			'old_password' => 'required|string',
			'password' => 'required|string|confirmed'
		]);

		// $user = User::where('email', $field['email'])->first();
		$user = auth()->user();
		// Check password
		if (!$user || !Hash::check($field['old_password'], $user->password)) {
			return response([
				'message' => 'Wrong email or password!'
			]);
		}
		$user->update([
			'password' => Hash::make($field['password']),
		]);
		$user->tokens()->delete();

		$token = $user->createToken('myapptoken')->plainTextToken;

		$response = [
			'user' => [
				'name' => $user->name,
				'email' => $user->email
			],
			'token' => $token
		];

		return response($response, 201);
	}

	public function logout(User $user)
	// public function logout(Request $request)
	{
		// Token base
		$user->tokens()->delete();

		return [
			'message' => 'Logged out'
		];

		// Auth::guard('web')->logout();

		// $request->session()->invalidate();

		// $request->session()->regenerateToken();

		// return response()->json([], 204);
	}
}