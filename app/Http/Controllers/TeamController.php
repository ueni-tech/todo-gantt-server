<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

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
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
