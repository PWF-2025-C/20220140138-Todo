<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function view(){
        //$todos = Todo::all();
        $todos =Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        // dd($todos);
        return view("todo.view", compact('todos'));
    }

    public function create(Request $request) {
        return view('todo.create');
    }

    // public function edit(Request $request) {
    //     return view('todo.');
    // }



    public function store(Request $request)
    {
        $request->validate([
        'title' => 'required|string|max:255',
        ]);   
        $todo = Todo::create([
            'title' => ucfirst($request->title),
            'user_id' => Auth::id(),
        ]);    
        return redirect()->route('todo.view')->with('success', 'Todo created successfully.');
    }


    // public function create(){
    
    //     return create("todo.index");
    // }
}
