<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DynamicCrudServices;
use Illuminate\Http\Request;

class DynamicCrudController extends Controller
{
    // if not verified in app service provider
    // protected $dynamicCrudService;

    // public function __construct(DynamicCrudServices $dynamicCrudService) {
    //     $this->dynamicCrudService = $dynamicCrudService;
    // }

    // Create Example
    public function create(Request $request, DynamicCrudServices $service)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $table = 'users'; // Dynamically define your table

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];

        // $this->dynamicCrudService->create($table, $data);
        $service->create($table, $data);

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Record created successfully!'
        // ]);
        return redirect()->back();
    }

    // Read Example
    public function read(Request $request, DynamicCrudServices $service)
    {
        $table = 'users'; // Dynamically define your table
        // $conditions = ['id' => $request->id];

        // $result = $this->dynamicCrudService->read($table, $conditions);
        $data['result'] = $service->read($table);
        return view('welcome', $data);
        // return response()->json($result);
    }

    public function edit($id, DynamicCrudServices $service)
    {
        $data['data'] = User::find($id);
        $table = 'users'; 
        $data['result'] = $service->read($table);
        if (!$data['data']) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }
        return view('welcome', $data);
    }

    // Update Example
    public function update(Request $request, DynamicCrudServices $service)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|',
        ]);
        $table = 'users'; // Dynamically define your table
        if($request->password != "") {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ];
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        $conditions = ['id' => $request->id];

        // $this->dynamicCrudService->update($table, $data, $conditions);
        $service->update($table, $data, $conditions);
        // return response()->json(['message' => 'Record updated successfully!']);
        return redirect('/');
    }

    // Delete Example
    public function delete(Request $request, DynamicCrudServices $service)
    {
        $table = 'users'; // Dynamically define your table
        $conditions = ['id' => $request->id];

        // $this->dynamicCrudService->delete($table, $conditions);
        $service->delete($table, $conditions);
        // return response()->json(['message' => 'Record deleted successfully!']);
        return redirect()->back();
    }
}
