<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class AjaxModalController extends Controller
{
    public function index()
    {
        $users = User::all(); 
        $items = Item::paginate(10);
        return view('modal-index', compact('users', 'items'));
    }

    public function create()
    {
        $users = User::all();
        return view('modal-create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        $item = Item::create($request->all());

        return response()->json(['item' => $item, 'message' => 'Item added successfully!']);
    }

    public function edit(Item $item)
    {
        $users = User::all();
        return view('modal-edit', compact('item', 'users'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        $item->update($request->all());

        return response()->json(['item' => $item, 'message' => 'Item updated successfully!']);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json(['message' => 'Item deleted successfully!']);
    }

    public function search(Request $request)
    {
        $query = Item::with('user');

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $items = $query->paginate(10);
        return view('modal-table', compact('items'))->render();
    }
}
