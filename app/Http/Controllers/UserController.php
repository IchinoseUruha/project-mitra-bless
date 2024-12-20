<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    
    public function detailAccount()
    {
        $user = Auth::user();
        return view('user.detailAccount', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'mobile' => 'required|string|max:20',
        ];

        // Add password validation rules if password is being updated
        if ($request->filled('current_password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Check current password if trying to update password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['The current password is incorrect.'],
                ]);
            }
        }

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->mobile = $validated['mobile'];

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}