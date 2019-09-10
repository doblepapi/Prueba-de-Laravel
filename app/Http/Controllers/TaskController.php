<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;
use phpDocumentor\Reflection\DocBlock\Description;

class TaskController extends Controller
{
    public function id()
    {
        $user = Auth::id();
        return view('welcome',compact('user'));
    }

    public function add()
    {
        return view(('add'));
    }

    public function create(Request $request)
    {
        $task = new Task();
        $task->Description = $request->description;
        $task->user_id = Auth::id();
        $task->save();
        return redirect('/');
    }

    public function edit(Task $task)
    {
        if (Auth::check() && Auth::user()->id == $task->user_id) {
            return view('edit', \compact('task'));
        }
        return redirect('/');   
    }

    public function update(Request $request, Task $task)
    {
        if (isset($_POST['delete'])) {
            $task->delete();
            return redirect('/');
        }

        $task->description = $request->description;
        $task->save();
        return redirect('/');
    }
}
