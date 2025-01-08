<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', $validated['email'])->first();

        // check user exist
        if (!$user) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        // check password
        if (!Hash::check($validated['password'], $user->password)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 200);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'Logged Out'], 200);
    }

    // update image profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'face_embedding' => 'required',
        ]);

        $user = $request->user();
        $image = $request->file('image');
        $face_embedding = $request->face_embedding;

        // save image
        $image->storeAs('images', $image->hashName(), 'public');
        $user->image_url = $image->hashName();
        $user->face_embedding = $face_embedding;
        $user->save();

        return response(['message' => 'Profile updated', 'user' => $user], 200);
    }
}
