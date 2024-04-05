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
    $user->name = 'Admin';
    $user->email = 'hello@tizianonicolai.com';
    $user->role = 'admin';
    $user->password = Hash::make('password');
    $user->save();

    $user = new User;
    $user->name = 'Collaboratore';
    $user->email = 'collaboratore@email.it';
    $user->password = Hash::make('password');
    $user->save();
  }
}
