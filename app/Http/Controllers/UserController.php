<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * 
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param UpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, string $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->save();

        return response()->json($user, 200);
    }

  /**
   * 指定されたチームの削除
   * 
   * @param  string  $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(string $id): \Illuminate\Http\JsonResponse
  {
    $user = User::find($id);
    $user->delete();

    return response()->json($user, 204);
  }
}
