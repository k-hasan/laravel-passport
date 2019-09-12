<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;

class TaskController extends Controller
{

    public function saveTask(Request $request)
    {

        $validatedData = $request->validate([
            'parent_id' => 'nullable',
            'user_id' => 'required',
            'title' => 'required',
            'point' => 'required|min:1|max:10',
            'is_done' => 'required|integer|min:0|max:1'
        ]);
        $validatedData['email'] = $request->email;

        $task = Task::create($validatedData);

        return response(['user'=>$task], 201);
    }


    public function updateTask(Request $request)
    {
        $updatedData = $request->validate([
            'parent_id' => 'nullable',
            'user_id' => 'required',
            'title' => 'required',
            'point' => 'required|min:1|max:10',
            'is_done' => 'required|integer|min:0|max:1',
            'email' => ''
        ]);

        $task = Task::where('id', '=', $request->route('task_id'))->first();

        $task->update($request->all());

        return response(['user'=>$updatedData], 201);

    }
}
