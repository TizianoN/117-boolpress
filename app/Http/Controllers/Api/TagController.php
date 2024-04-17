<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tag;

class TagController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $tags = Tag::select('id', 'label', 'color')->get();

    return response()->json([
      'success' => true,
      'result' => $tags,
    ]);
  }
}
