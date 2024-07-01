<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $todos = Todo::where("user_id", Auth::user()->id)->get();
        return response()->json([
            "todos" => $todos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            "title" => "string|max:80|required",
            "description" => "string|max:255",
        ]);

        $user = Auth::user();
        $todo = new Todo([
            "title" => $validated["title"],
            "description" => $validated["description"],
            "user_id" => $user->id,
        ]);
        $todo->save();

        return response()->json([
            "todo" => $todo,
            "message" => "creado"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'done' => 'required|boolean'
        ]);

        $todo->update([
            'done' => $validated['done']
        ]);

        return response()->json([
            'todo' => $todo,
            'message' => 'Todo updated successfully'
        ]);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json([
            'message' => 'Todo deleted successfully'
        ]);
    }
}
