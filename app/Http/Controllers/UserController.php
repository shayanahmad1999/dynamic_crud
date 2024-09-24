<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->paginate(5);

        if ($request->ajax()) {
            return view('users.table', compact('users'))->render();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create')->render();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$request->update_key
        ]);

        $validatedData['password'] = "password12";

        if($request->update_key != "") {
            $users = User::findOrFail($request->update_key);
            $users->update($validatedData);
            $message = 'User Update successfully.';
            $status = "update";
        } else {
            User::create($validatedData);
            $message = 'User Created successfully.';
        }


        return response()->json([
            'status' => $status ?? 'success',
            'message'=> $message,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.create', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message'=> 'User deleted successfully.'
        ]);
    }
}
