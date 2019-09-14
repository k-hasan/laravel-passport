<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function saveTask(Request $request)
    {

        $userId = $request->user_id;
        $parentId = $request->parent_id;

        $data = $request->all();
        $validator = Validator::make($data, [
            'parent_id' => ['nullable', Rule::exists('tasks','id')
                ->where(function ($query) use ($parentId) {
                    $query->where('id', $parentId);
                })],

            'user_id' => ['required', Rule::exists('users', 'id')
                ->where(function ($query) use ($userId) {
                    $query->where('id', $userId);
                })],

            'title' => 'required',
            'point' => 'required|integer|min:1|max:12',
            'is_done' => ['required', Rule::in([0, 1])],
            'email' => ''
        ]);

        if ($validator->fails()) {
            return response(['message'=>'Invalid Data', 'error'=>$validator->errors()],400);
        }

        $task = Task::create($data);

        if(isset($task)){
            return response(['user' => $task], 201);
        }else{
            return response(['message'=>'Server Internal Error'], 500);
        }
    }


    public function updateTask(Request $request, $id)
    {
        $data = $request->all();
        $userId = $request->user_id;
        $parentId = $request->parent_id;

        $validator = Validator::make($data, [
            'parent_id' => ['nullable', Rule::exists('tasks','id')
                ->where(function ($query) use ($parentId) {
                    $query->where('id', $parentId);
                })],

            'user_id' => ['required', Rule::exists('users', 'id')
                ->where(function ($query) use ($userId) {
                    $query->where('id', $userId);
                })],

            'title' => 'required',
            'point' => 'required|integer|min:1|max:12',
            'is_done' => ['required', Rule::in([0, 1])],
            'email' => ''
        ]);

        if ($validator->fails()) {
            return response(['message'=>'Invalid Data', 'error'=>$validator->errors()],400);
        }

        $task = Task::where('id', '=', $id)->first();

        $updateStatus = $task->update($data);

        if(isset($updateStatus)){
            return response(['user' => $data], 201);
        }else{
            return response(['message'=>'Server Internal Error'], 500);
        }

    }

    public function showTaskList()
    {
        $users = User::has('tasks')->get()->pluck('name','id');

        $data = Task::all()->groupBy('user_id');

        return view('dash', compact(['data', 'users']));
    }




}
