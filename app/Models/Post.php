<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
  use HasFactory; //, SoftDeletes;

  protected $fillable = ['category_id', 'title', 'content'];

  public static function generateUniqueSlug($text, $ignore_id = null)
  {
    $base_slug = Str::slug($text);

    $slug_already_exists = Post::where('slug', $base_slug)->where('id', '<>', $ignore_id)->count() ? true : false;

    if (!$slug_already_exists)
      return $base_slug;

    $counter = 1;
    do {
      $slug = $base_slug . '-' . $counter;
      $slug_already_exists = Post::where('slug', $slug)->count() ? true : false;

      if (!$slug_already_exists)
        return $slug;

      $counter++;
    } while ($slug_already_exists);
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function getAbstract($n_chars = 30)
  {
    return (strlen($this->content) > $n_chars) ? substr($this->content, 0, $n_chars) . '...' : $this->content;
  }

  public function getTagsToText()
  {
    return implode(', ', $this->tags->pluck('label')->toArray());
  }


}
