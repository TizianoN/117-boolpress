<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   * 
   * @return \Illuminate\Contracts\View\View
   */
  public function index()
  {
    if (Auth::user()->role != 'admin')
      abort(403);

    $categories = Category::orderBy('id', 'DESC')->paginate(12);
    return view('admin.categories.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   * 
   * @return \Illuminate\Contracts\View\View
   */
  public function create()
  {
    if (Auth::user()->role != 'admin')
      abort(403);

    $category = new Category;
    return view('admin.categories.form', compact('category'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Contracts\View\View
   */
  public function store(Request $request)
  {
    if (Auth::user()->role != 'admin')
      abort(403);

    $data = $request->all();

    $category = new Category;
    $category->fill($data);
    $category->save();

    return redirect()->route('admin.categories.show', $category);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Contracts\View\View
   */
  public function show(Category $category)
  {
    if (Auth::user()->role != 'admin')
      abort(403);

    $related_posts = $category->posts()->paginate(12);
    return view('admin.categories.show', compact('category', 'related_posts'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Contracts\View\View
   */
  public function edit(Category $category)
  {
    if (Auth::user()->role != 'admin')
      abort(403);

    return view('admin.categories.form', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Contracts\View\View
   */
  public function update(Request $request, Category $category)
  {
    if (Auth::user()->role != 'admin')
      abort(403);

    $data = $request->all();
    $category->update($data);
    return redirect()->route('admin.categories.show', $category);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Contracts\View\View
   */
  public function destroy(Request $request, Category $category)
  {
    if (Auth::user()->role != 'admin')
      abort(403);

    $action = $request->input("delete-action");

    if ($action === 'delete-posts') {
      foreach ($category->posts as $post) {
        $post->delete();
      }
    } else {
      foreach ($category->posts as $post) {
        $post->category_id = $action;
        $post->save();
      }
    }

    $category->delete();

    return redirect()->back();
  }
}
