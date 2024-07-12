<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function create(){
        return view('admin.add');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('admin.index')->with('message', 'Admin created successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Check if the user ID is 1 or the user name is "Admin"
        if ($user->id == 1 || $user->name == 'Admin') {
            return redirect()->route('admin.index')->with('error', 'Deletion unsuccessful: Admin cannot be deleted');
        }

        // Proceed with deletion if the conditions are not met
        $user->delete();

        return redirect()->route('admin.index')->with('message', 'Admin deleted successfully');
    }
}
