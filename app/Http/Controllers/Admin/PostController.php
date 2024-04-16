<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Mail\CreatedPostMail;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

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
    $tags = Tag::all();
    return view('admin.posts.form', compact('post', 'categories', 'tags'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   */
  public function store(StorePostRequest $request)
  {
    // Valido la richiesta
    $request->validated();

    // recupero i dati della richiesta
    $data = $request->all();

    // istanzio un nuovo post 
    $post = new Post;

    // fillo il post con i dati del form 
    $post->fill($data);

    // lo lego all'utente loggato (è l'autore)
    $post->user_id = Auth::id();

    // genero lo slug
    $post->slug = Post::generateUniqueSlug($post->title);
    ;

    // gestisco l'immagine e ne recupero il path
    // se è arrivata una nuova immagine
    if (Arr::exists($data, "image")) {
      $img_path = Storage::put('uploads/posts', $data["image"]);
      $post->image = $img_path;
    }

    // salvo il post in db
    $post->save();

    // relaziono il post ai tags associati
    if (Arr::exists($data, 'tags')) {
      $post->tags()->attach($data["tags"]);
    }

    // Invio una mail di conferma creazione
    Mail::to('utente@mail.it')->send(new CreatedPostMail($post, Auth::user()));

    return redirect()->route('admin.posts.show', $post);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Post  $post
   */
  public function show(Post $post)
  {
    if (Auth::id() != $post->user_id && Auth::user()->role != 'admin')
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
    if (Auth::id() != $post->user_id && Auth::user()->role != 'admin')
      abort(403);

    // tutte le categorie esistenti
    $categories = Category::all();

    // tutti i tags esistenti 
    $tags = Tag::all();

    // array di tutti gli id dei tags associati con questo post
    $post_tags_id = $post->tags->pluck('id')->toArray();

    return view('admin.posts.form', compact('post', 'categories', 'tags', 'post_tags_id'));
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
    if (Auth::id() != $post->user_id && Auth::user()->role != 'admin')
      abort(403);

    $request->validated();

    $data = $request->all();

    $old_title = $post->title;
    $new_title = $data["title"];

    $post->fill($data);

    if ($old_title != $new_title)
      $post->slug = Post::generateUniqueSlug($post->title, $post->id);

    // se è arrivata una nuova immagine
    if (Arr::exists($data, "image")) {
      // se ce n'era una prima
      if (!empty($post->image)) {
        // la elimino
        Storage::delete($post->image);
      }

      // salva la nuova img
      $img_path = Storage::put('uploads/posts', $data["image"]);
      $post->image = $img_path;
    }
    $post->save();

    if (Arr::exists($data, 'tags')) {
      $post->tags()->sync($data["tags"]);
    } else {
      $post->tags()->detach();
    }

    return redirect()->route('admin.posts.show', $post);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Post  $post
   */
  public function destroy(Post $post)
  {
    if (Auth::id() != $post->user_id && Auth::user()->role != 'admin')
      abort(403);

    $post->tags()->detach();

    if (!empty($post->image)) {
      Storage::delete($post->image);
    }

    $post->delete();

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Post  $post
   */
  public function destroyImg(Post $post)
  {
    Storage::delete($post->image);
    $post->image = null;
    $post->save();
    return redirect()->back();
  }

  /**
   * update the specified resource published status.
   *
   * @param  \App\Models\Post  $post
   */
  public function updatePublish(Request $request, Post $post)
  {
    $data = $request->all();
    $post->published = Arr::exists($data, 'published') ? true : false;
    $post->save();
    return redirect()->back();
  }
}

