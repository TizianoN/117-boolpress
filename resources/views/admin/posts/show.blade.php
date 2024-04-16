@extends('layouts.app')

@section('title', 'Dettaglio posts')

@section('content')
  <section>
    <div class="container">
      <a class="btn btn-primary my-4" href="{{ route('admin.posts.index') }}">
        <i class="fa-solid fa-table me-1"></i>
        Torna alla lista
      </a>

      <h1 class="mb-4">{{ $post->title }}</h1>
      <p><strong>Categoria:</strong> {!! $post->category->getbadge() !!}</p>
      <p>{{ $post->content }}</p>
      <p>
        {{ $post->getTagsToText() }}
      </p>

      @if (!empty($post->image))
        <img src="{{ asset('storage/' . $post->image) }}" />
      @endif
    </div>
  </section>
@endsection

@section('css')
  <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    referrerpolicy="no-referrer" rel="stylesheet" />
@endsection
