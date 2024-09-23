<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(Request $request)
    {
        $data['result'] = User::paginate(10);
        if ($request->ajax()) {
            $html = view('pagination', $data)->render();
            $nextPageUrl = $data['result']->nextPageUrl();

            return response()->json([
                'html' => $html,
                'nextPageUrl' => $nextPageUrl
            ]);
        }

        return view('index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:users,email,' . $request->update_key,
        ]);

        try {
            $user = null;
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if (!empty($request->password)) {
                $request->validate([
                    'password' => 'required|min:6|max:12'
                ]);
                $data['password'] = $request->password;
            }    

            if ($request->update_key != '') {
                $user = User::find($request->update_key);
                if ($user) {
                    $user->update($data);
                }
                $message = 'record updated successfully';
            } else {
                $user = User::create($data);
                $message = 'record created successfully';
            }
            $new_data = "
            <tr>
                <td>{$user->name}</td>
                <td>{$user->email}</td>
                <td>
                    <button class='btn btn-primary edit' data-id='{$user->id}' action_url='" . route('ajax.edit', $user->id) . "'>Edit</button>
                    <button class='btn btn-danger delete' data-id='{$user->id}' action_url='" . route('ajax.delete', $user->id) . "'>Delete</button>
                </td>
            </tr>
        ";
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => $new_data
            ], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'record not found.'
                ], 404);
            }
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'record deleted successfully',
            ], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'record not found.'
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function search(Request $request)
    {
        $search = $request->search_string;
        $data['result'] = User::where('name', 'like', "%$search%")
        ->orWhere('email', 'like', "%$search%")
        ->paginate(10);

        if($data['result']->count() >= 1) {
            return view('pagination', $data)->render();
        } else {
            return response()->json(['status' => 'Nothing found']);
        }
    }
}
