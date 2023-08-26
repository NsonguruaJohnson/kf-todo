<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index(){
        // fetch all todos from db
        // display them on the todos.index page

        $todos = Todo::all();
        // dd($todos);
        // return view('todos.index')->with('todos', $todos); # Works as below
        return view('todos.index', [
            'todos' => $todos
        ]);
    }

    public function show(Todo $todo) {
        // dd($todoId);
        // $todo = Todo::find($todoId);

        return view('todos.show', [
            'todo' => $todo
        ]);
    }

        # Prefer the code below to the one above
    // public function show(Todo $todo){
    //     // dd($todo);

    //     return view('todos.show', [
    //         'todo' => $todo
    //     ]);
    // }

    public function create() {
        return view('todos.create');
    }

    // public function store() {

    //     // dd($request->all());
    //     // dd(request()->all());

    //     $data = request()->all();
    //     $todo = new Todo;
    //     $todo->name = $data['name'];
    //     $todo->description = $data['description'];
    //     $todo->completed = false;

    //     $todo->save();

    //     return redirect('/todos');
    // }

            # Prefer the code below to the one above
    public function store(Request $request) {

        // dd($request->only('name', '_token'));
        $this->validate($request, [
            'name' => ['required', 'min:6', 'max:12'],
            'description' => ['required'],
        ]);

        $todo = new Todo();
        $todo->name = $request->name;
        $todo->description = $request->description;
        $todo->completed = false;

        $todo->save();

        // session()->flash('success', 'Todo created successfully');

        return redirect('/todos')->with('success', 'Todo created successfully');

    }

    public function edit(Todo $todo) {
        // $todo = Todo::find($todoId);
        return view('todos.edit', [
            'todo' => $todo
        ]);
    }

    public function update(Todo $todo, Request $request) {
        $this->validate($request, [
            'name' => ['required', 'min:6', 'max:12'],
            'description' => ['required'],
        ]);

        $data = $request->all();

        // $todo = Todo::find($todoId);
        $todo->name = $data['name'];
        $todo->description = $data['description'];

        $todo->save();

        return redirect('/todos');

    }

    public function destroy(Todo $todo) {
        // $todo = Todo::find($todoId);
        $todo->delete();

        return redirect('/todos');
    }

    public function complete(Todo $todo) {
        $todo->completed = true;
        $todo->save();

        // session()->flash('success', 'Todo completed successfully');
        // return redirect('/todos');

        return back()->with('success', 'Todo completed successfully');
    }

}
