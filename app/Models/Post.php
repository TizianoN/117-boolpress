<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['title', 'content'];

  public function getAbstract($n_chars = 30)
  {
    return (strlen($this->content) > $n_chars) ? substr($this->content, 0, $n_chars) . '...' : $this->content;
  }
}
