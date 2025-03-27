<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function view(){
        //$todos = Todo::all();
        $todos =Todo::where('user_id', Auth::id())->get();
        dd($todos);
        return view("todo.view");
    }

    // public function create(){
    
    //     return create("todo.index");
    // }
}
