<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $posts = Post::orderBy('id', 'DESC');

    if (Auth::user()->role != 'admin') {
      $posts->where('user_id', Auth::id());
    }

    $posts = $posts->paginate(12);

    return view('admin.posts.index', compact('posts'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $post = new Post;
    $categories = Category::all();
    return view('admin.posts.form', compact('post', 'categories'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(StorePostRequest $request)
  {
    $request->validated();

    $data = $request->all();

    $post = new Post;
    $post->fill($data);
    $post->user_id = Auth::id();
    $post->slug = Str::slug($post->title);
    $post->save();

    return redirect()->route('admin.posts.show', $post);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Post  $post
   */
  public function show(Post $post)
  {
    if (Auth::id() != $post->user_id)
      abort(403);

    return view('admin.posts.show', compact('post'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Post  $post
   */
  public function edit(Post $post)
  {
    if (Auth::id() != $post->user_id)
      abort(403);

    $categories = Category::all();
    return view('admin.posts.form', compact('post', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(UpdatePostRequest $request, Post $post)
  {
    if (Auth::id() != $post->user_id)
      abort(403);

    $request->validated();

    $data = $request->all();

    $post->fill($data);
    $post->slug = Str::slug($post->title);
    $post->save();

    return redirect()->route('admin.posts.show', $post);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Post  $post
   */
  public function destroy(Post $post)
  {
    if (Auth::id() != $post->user_id)
      abort(403);

    $post->delete();
    return redirect()->back();
  }
}
