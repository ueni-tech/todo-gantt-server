<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
  // テスト後にデータベースをリセットする
  use RefreshDatabase;

  // メソッド名は「test〇〇」であること
  public function testHello()
  {
    // レコードが0件かチェック
    $this->assertDatabaseCount('users', 0);

    // テストユーザーを生成
    $user = User::factory()->create();

    // レコードが1件かチェック
    $this->assertDatabaseCount('users', 1);
  }
}
