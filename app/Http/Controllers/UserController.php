<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
			'password' => bcrypt($field['password']),
		]);

		$token = $user->createToken('myapptoken')->plainTextToken;

		$response = [
			'user' => $user,
			'token' => $token
		];

		return response($response, 201);
	}


	public function login(Request $request)
	{
		$field = $request->validate([
			'email' => 'required|string',
			'password' => 'required|string'
		]);

		// Check email
		$user = User::where('email', $field['email'])->first();

		// Check password
		if (!$user || !Hash::check($field['password'], $user->password)) {
			return response([
				'message' => 'Wrong email or password!'
			]);
		}

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
			'password' => bcrypt($field['password']),
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
	{
		$user->tokens()->delete();

		return [
			'message' => 'Logged out'
		];
	}
}
