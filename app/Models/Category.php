<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use HasFactory;

  protected $fillable = ['label', 'color'];

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function getBadge()
  {
    return "<span class='badge' style='background-color: {$this->color}'>{$this->label}</span>";
  }
}
