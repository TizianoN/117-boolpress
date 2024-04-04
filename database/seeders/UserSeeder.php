<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = new User;
    $user->name = 'Tiziano';
    $user->email = 'hello@tizianonicolai.com';
    $user->password = Hash::make('password');
    $user->save();
  }
}
