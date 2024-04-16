<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class PostTagSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $posts = Post::all();
    $tags = Tag::all()->pluck('id');

    foreach ($posts as $post) {
      $random_tags = $faker->randomElements($tags, rand(1, 3));
      $post->tags()->sync($random_tags);
    }
  }
}
