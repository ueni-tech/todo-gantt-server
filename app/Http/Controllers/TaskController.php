<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * すべてのタスクを取得
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() : \Illuminate\Http\JsonResponse
    {
        // すべてのタスクを取得
        $tasks = Task::all();
        return response()->json($tasks);
    }

  /**
   * 新しいタスクを作成
   * 
   * @param \App\Http\Requests\Task\StoreRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
  {
    $task = new Task();
    $task->name = $request->name;
    $task->project_id = $request->project_id;
    $task->note = $request->note;
    $task->start_date = $request->start_date;
    $task->end_date = $request->end_date;
    $task->is_completed = $request->is_completed;
    $task->save();

    return response()->json($task, 201);
  }

    /**
     * 指定されたタスクの更新
     */
    public function update(UpdateRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $task = Task::find($id);
        $task->name = $request->name;
        $task->project_id = $request->project_id;
        $task->note = $request->note;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->is_completed = $request->is_completed;
        $task->save();

        return response()->json($task, 200);
    }

    /**
     * 指定されたタスクの削除
     * 
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $task = Task::find($id);
        $task->delete();

        return response()->json($task, 204);
    }
}
