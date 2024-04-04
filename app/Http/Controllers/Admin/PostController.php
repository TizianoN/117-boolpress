<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $posts = Post::orderBy('id', 'DESC')->paginate(12);
    return view('admin.posts.index', compact('posts'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $post = new Post;
    return view('admin.posts.form', compact('post'));
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
    return view('admin.posts.show', compact('post'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Post  $post
   */
  public function edit(Post $post)
  {
    return view('admin.posts.form', compact('post'));
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
    $post->delete();
    return redirect()->route('admin.posts.index');
  }

}
