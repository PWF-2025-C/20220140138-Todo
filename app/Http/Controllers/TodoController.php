<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    public function index(){
        //$todos = Todo::all();
        // $todos =Todo::where('user_id', Auth::id()) ->with('category') ->orderBy('created_at', 'desc')->get();
        // dd($todos);

        $todos = Todo::with('category') 
            -> where('user_id', Auth::id())
            -> orderBy('is_done', 'asc')
            -> orderBy('created_at','desc')
            -> paginate(10);
        
        
        // $todosCompleted = Todo::where('user_id', Auth::user()->id)
        //     ->where('is_done', true)
        //     ->count();
        // return view("todo.index", compact('todos', 'todosCompleted'));

        $todosCompleted = Todo::where('user_id', Auth::id())
            ->where('is_done', true)
            ->count();
        return view("todo.index", compact('todos', 'todosCompleted'));
    }

    public function create(Request $request) {
        $categories = Category::all();
        return view('todo.create', compact('categories'));
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
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);    
        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }


    public function complete(Todo $todo)
    {
        if (Auth::id() == $todo->user_id) {
            $todo->update(['is_done' => true]);
            return redirect()->route('todo.index')
                            ->with('success', 'Todo completed successfully.');
        } else {
            return redirect()->route('todo.index')
                            ->with('error', 'You are not authorized to complete this todo.');
        }
    }

    public function uncomplete(Todo $todo)
    {
        if (Auth::id() == $todo->user_id) {
            $todo->update(['is_done' => false]);
            return redirect()->route('todo.index')
                            ->with('success', 'Todo uncompleted successfully.');
        } else {
            return redirect()->route('todo.index')
                            ->with('error', 'You are not authorized to uncomplete this todo.');
        }
    }


        public function edit(Todo $todo)
        {
            if (Auth::user()->id == $todo->user_id) {
                $categories = Category::all();  // ambil semua kategori dari database
                return view('todo.edit', compact('todo', 'categories'));  // kirim $categories juga ke view
            } else {
                return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
            }
        }

        public function update(Request $request, Todo $todo)
        {
            if ($todo->user_id != Auth::user()->id) {
                return redirect()->route('todo.index')->with('danger', 'You are not authorized to update this todo!');
            }

            $request->validate([
                'title' => 'required|max:255',
                'category_id' => 'nullable|exists:categories,id',
            ]);

            $todo->update([
                'title' => ucfirst($request->title),
                'category_id' => $request->category_id, 
            ]);

            return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
        }

        public function destroy(Todo $todo)
        {
            if (Auth::user()->id == $todo->user_id) {
                $todo->delete();
                return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
            } else {
                return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
            }
        }
    
        public function destroyCompleted()
        {
            $todosCompleted = Todo::where('user_id', Auth::user()->id)
                ->where('is_done', true)
                ->get();
    
            foreach ($todosCompleted as $todo) {
                $todo->delete();
            }
    
            return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
        }
    



    // public function create(){
    
    //     return create("todo.index");
    // }
}


//(Auth::id() == $todo->user_id){}
// php artisan optimize
//php artisan route --> ngecek PATCH complite/uncomplte
