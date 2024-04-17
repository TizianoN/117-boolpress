<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;



class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $post_id = 1;

    // Recupero le info dal database
    $posts = Post::select(['id', 'user_id', 'category_id', 'title', 'content', 'image', 'slug'])
      ->where('published', true)

      // ->whereHas('tags', function (Builder $query) use ($post_id) {
      //   $query->where('tags.id', $post_id);
      // })

      ->with(['category:id,label,color', 'tags:id,label,color', 'user:id,name'])
      ->orderBy('id', 'DESC')
      ->paginate(12);

    // Raffino le info recuperate (opzionale)
    foreach ($posts as $post) {
      $post->image = !empty($post->image) ? asset('/storage/' . $post->image) : null;
      $post->content = $post->getAbstract(45);
    }

    // Stampo le info come json
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
    // Verifico che la risorsa esista
    $category = Category::find($category_id);

    // Se non trovo la risorsa blocco la logica e do subito la risposta in JSON
    if (empty($category)) {
      return response()->json([
        'message' => 'Category not found',
        'success' => false,
      ]);
    }

    // Recupero le info dal database
    $posts = Post::select(['id', 'user_id', 'category_id', 'title', 'content', 'image', 'slug'])
      ->with(['category:id,label,color', 'tags:id,label,color', 'user:id,name'])
      ->where('category_id', $category_id)
      ->where('published', true)
      ->orderBy('id', 'DESC')
      ->paginate(12);

    // Raffino le info recuperate (opzionale)
    foreach ($posts as $post) {
      $post->image = !empty($post->image) ? asset('/storage/' . $post->image) : null;
      $post->content = $post->getAbstract(45);
    }

    // Stampo le info come json
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
    // Recupero le info dal database
    $post = Post::select(['id', 'user_id', 'category_id', 'title', 'content', 'image', 'slug'])
      ->where('slug', $slug)
      ->where('published', true)
      ->with(['category:id,label,color', 'tags:id,label,color'])
      ->first();

    // Se non trovo la risorsa blocco la logica e do subito la risposta in JSON
    if (empty($post)) {
      return response()->json([
        'message' => 'Post not found',
        'success' => false,
      ]);
    }

    // Raffino le info recuperate (opzionale)
    $post->image = !empty($post->image) ? asset('/storage/' . $post->image) : null;

    // Stampo le info come json
    return response()->json([
      'result' => $post,
      'success' => true,
    ]);
  }

  /**
   * Display the specified resource applicando filtri avanzati.
   *
   * @param  int  $slug
   * @return \Illuminate\Http\Response
   */
  public function advancedFilters(Request $request)
  {
    $filters = $request->all();

    $posts = Post::select(['id', 'user_id', 'category_id', 'title', 'content', 'image', 'slug']);

    if (Arr::exists($filters, 'categories')) {
      foreach ($filters['categories'] as $category) {
        // # filtro in or
        // $posts->orWhere('category_id', $category);

        // #filtro in and
        $posts->where('category_id', $category);
      }
    }

    if (Arr::exists($filters, 'tags')) {
      foreach ($filters['tags'] as $tag_id) {
        $posts->whereHas('tags', function (Builder $query) use ($tag_id) {
          $query->where('tags.id', $tag_id);
        });
      }
    }

    if (Arr::exists($filters, 'searchedText') && !empty($filters['searchedText'])) {
      $posts->where('title', 'LIKE', "%" . $filters['searchedText'] . "%");
    }

    $posts = $posts->with(['category:id,label,color', 'tags:id,label,color'])
      ->orderBy('id', 'DESC')
      ->get();

    foreach ($posts as $post) {
      $post->image = !empty($post->image) ? asset('/storage/' . $post->image) : null;
      $post->content = $post->getAbstract(45);
    }

    return response()->json([
      'result' => $posts,
      'success' => true,
    ]);
  }
}
