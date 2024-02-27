<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\StoreRequest;
use App\Http\Requests\Team\UpdateRequest;
use App\Models\Team;

class TeamController extends Controller
{
  /**
   * 全てのチームを取得
   * 
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(): \Illuminate\Http\JsonResponse
  {
    // すべてのプロジェクトを取得
    $teams = Team::all();
    return response()->json($teams, 200);
  }

  /**
   * 新しいチームを作成
   * 
   * @param  \App\Http\Requests\Team\StoreRequest  $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
  {
    $team = new Team();
    $team->name = $request->name;
    $team->save();

    return response()->json($team, 201);
  }

  /**
   * 指定したチームの更新
   * 
   * @param  \App\Http\Requests\Team\UpdateRequest  $request
   * @param  string  $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateRequest $request, string $id): \Illuminate\Http\JsonResponse
  {
    $team = Team::find($id);
    $team->name = $request->name;
    $team->save();

    return response()->json($team, 200);
  }

  /**
   * 指定されたチームの削除
   * 
   * @param  string  $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(string $id): \Illuminate\Http\JsonResponse
  {
    $team = Team::find($id);
    $team->delete();

    return response()->json($team, 204);
  }
}
