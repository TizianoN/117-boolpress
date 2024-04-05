<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $categories_id = Category::all()->pluck('id');
    $users_id = User::all()->pluck('id');

    for ($i = 0; $i < 150; $i++) {
      $post = new Post;
      $post->user_id = $faker->randomElement($users_id);
      $post->category_id = $faker->randomElement($categories_id);
      $post->title = $faker->catchPhrase();
      $post->content = $faker->paragraphs(2, true);
      $post->slug = Str::slug($post->title);
      $post->save();
    }
  }
}
