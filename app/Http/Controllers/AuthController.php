<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|unique:users|max:255',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6|regex:/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{6,100}+\z/i|confirmed'      
    ],
    // エラーメッセージのカスタマイズ
    [
      'name.required' => '名前を入力してください',
      'name.string' => '名前は文字列で入力してください',
      'name.max' => '名前は255文字以内で入力してください',
      'name.unique' => 'この名前は既に使用されています',
      'email.unique' => 'このメールアドレスは既に使用されています',
      'email.required' => 'メールアドレスを入力してください',
      'email.email' => 'メールアドレスの形式で入力してください',
      'password.required' => 'パスワードを入力してください',
      'password.min' => 'パスワードは6文字以上の英数字で入力してください',
      'password.confirmed' => 'パスワードが一致しません', 
    ]
  );


    if ($validator->fails()) {
      return response()->json($validator->errors(), 400);
    }

    $user = User::create(array_merge(
      $validator->validated(),
      ['password' => bcrypt($request->password)]
    ));

    return response()->json([
      'message' => 'ユーザー登録が完了しました。',
      'user' => $user,
      'access_token' => auth()->attempt($request->only('email', 'password'))
    ], 201);
  }

  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login()
  {
    $credentials = request(['email', 'password']);

    if (!$token = auth()->attempt($credentials)) {
      return response()->json(['error' => '認証に失敗しました'], 401);
    }

    return $this->respondWithToken($token);
  }

  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
    return response()->json(auth()->user());
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    auth()->logout();

    return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    return $this->respondWithToken(auth()->refresh());
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }
}
