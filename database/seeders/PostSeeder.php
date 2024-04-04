<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
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
    for ($i = 0; $i < 150; $i++) {
      $post = new Post;
      $post->title = $faker->catchPhrase();
      $post->content = $faker->paragraphs(2, true);
      $post->slug = Str::slug($post->title);
      $post->save();
    }
  }
}
