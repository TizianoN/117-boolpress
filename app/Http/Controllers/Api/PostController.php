<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;



class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $posts = Post::select(['id', 'user_id', 'category_id', 'title', 'content', 'image', 'slug'])
      ->where('published', true)
      ->with(['category:id,label,color', 'tags:id,label,color', 'user:id,name'])
      ->orderBy('id', 'DESC')
      ->paginate(12);

    foreach ($posts as $post) {
      $post->image = !empty($post->image) ? asset('/storage/' . $post->image) : null;
      $post->content = $post->getAbstract(45);
    }

    return response()->json([
      'result' => $posts,
      'success' => true,
    ]);
  }

  /**
   * Display a listing of the resource filtered by category_id.
   *
   * @return \Illuminate\Http\Response
   */
  public function postsByCategory($category_id)
  {
    $category = Category::find($category_id);

    if (empty($category)) {
      return response()->json([
        'message' => 'Category not found',
        'success' => false,
      ]);
    }

    $posts = Post::select(['id', 'user_id', 'category_id', 'title', 'content', 'image', 'slug'])
      ->with(['category:id,label,color', 'tags:id,label,color', 'user:id,name'])
      ->where('category_id', $category_id)
      ->where('published', true)
      ->orderBy('id', 'DESC')
      ->paginate(12);

    foreach ($posts as $post) {
      $post->image = !empty($post->image) ? asset('/storage/' . $post->image) : null;
      $post->content = $post->getAbstract(45);
    }

    return response()->json([
      'category' => $category,
      'result' => $posts,
      'success' => true,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $slug
   * @return \Illuminate\Http\Response
   */
  public function show($slug)
  {
    $post = Post::select(['id', 'user_id', 'category_id', 'title', 'content', 'image', 'slug'])
      ->where('slug', $slug)
      ->where('published', true)
      ->with(['category:id,label,color', 'tags:id,label,color'])
      ->first();

    if (empty($post)) {
      return response()->json([
        'message' => 'Post not found',
        'success' => false,
      ]);
    }

    $post->image = !empty($post->image) ? asset('/storage/' . $post->image) : null;

    return response()->json([
      'result' => $post,
      'success' => true,
    ]);
  }
}
