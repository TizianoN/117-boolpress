<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Faker\Generator as Faker;

class TagSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run(Faker $faker)
  {
    $tag_data = [
      'Git',
      'HTML5',
      'CSS3',
      'Bootstrap',
      'JavaScript ES6',
      'VueJS 3',
      'Axios',
      'RESTful API',
      'SQL',
      'PHP',
      'Json',
      'Laravel',
      'Blade',
      'Eloquent',
      'Faker'
    ];

    foreach ($tag_data as $_tag) {
      $tag = new Tag;
      $tag->label = $_tag;
      $tag->color = $faker->hexColor();
      $tag->save();
    }
  }
}
