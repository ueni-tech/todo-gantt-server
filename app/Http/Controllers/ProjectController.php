<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * すべてのプロジェクトを取得
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        // すべてのプロジェクトを取得
        $projects = Project::all();
        return response()->json($projects);
    }

    /**
     * 新しいプロジェクトを作成
     * 
     * @param  \App\Http\Requests\Project\StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $project = new Project();
        $project->name = $request->name;
        $project->team_id = 1;
        $project->save();

        return response()->json($project, 201);
    }

    /**
     * プロジェクトの編集
     * 
     * @param  \App\Http\Requests\Project\UpdateRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $project = Project::find($id);
        $project->name = $request->name;
        $project->save();

        return response()->json($project);
    }

    /**
     * プロジェクトの削除
     * 
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): \Illuminate\Http\JsonResponse
    {
        $project = Project::find($id);
        $project->delete();

        return response()->json(null, 204);
    }
}
