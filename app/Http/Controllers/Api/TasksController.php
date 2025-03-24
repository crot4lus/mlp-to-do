<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\StoreApiTaskRequest;
use App\Http\Requests\UpdateApiTaskRequest;

class TasksController extends Controller
{
    public function index(){
        return Task::orderBy('completed', 'asc')->get(); 
    }

    public function store(StoreApiTaskRequest $request) {
        $task = Task::create([
            'title' => $request->validated()['title'],
        ]);

        if(!$task){
            return response()->json([
                'message' => 'There was an error.',
                'task' => $task,
            ], 400);
        }

        return response()->json([
            'message' => 'Task created successfully.',
            'task' => $task,
        ], 201);
    }

    public function show(Task $task) { 
        return $user;
    }

    public function update(UpdateApiTaskRequest $request, Task $task) {
        $update = $task->update($request->validated());
        
        if(!$update){
            return response()->json([
                'message' => 'There was an error.',
                'data' => $task,
            ], 400);
        }

        return response()->json([
            'message' => 'Task updated successfully.',
            'data' => $task,
        ], 201);
    }

    public function destroy(Task $task) {
        $delete = $task->delete();

        if(!$delete){
            return response()->json([
                'message' => 'There was an error.'
            ], 400);
        }
        
        return response()->json([
            'message' => 'Task deleted successfully.'
        ], 201);
    }
}
