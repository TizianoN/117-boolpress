@extends('layouts.app')

@section('title', empty($post->id) ? 'Creazione Post' : 'Modifica Post')

@section('content')
  <section>
    <div class="container">

      <a class="btn btn-primary my-4" href="{{ route('admin.posts.index') }}">
        <i class="fa-solid fa-table me-1"></i>
        Torna alla lista
      </a>

      <h1 class="mb-4">{{ empty($post->id) ? 'Creazione Post' : 'Modifica Post' }}</h1>

      {{-- 
        @if ($errors->any())
        <div class="alert alert-danger mb-4">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif 
      --}}

      <form action="{{ empty($post->id) ? route('admin.posts.store') : route('admin.posts.update', $post) }}"
        class="row g-3" method="POST">
        @if (!empty($post->id))
          @method('PATCH')
        @endif

        @csrf

        <div class="col-12">
          <label class="form-label" for="title">Titolo</label>
          <input @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name="title" type="text"
            value="{{ old('title', $post['title']) }}" />
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12">
          <label class="form-label" for="content">Contenuto</label>
          <textarea @class(['form-control', 'is-invalid' => $errors->has('content')]) id="content" name="content" rows="5" type="text">{{ old('content', $post['content']) }}</textarea>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12">
          <button class="btn btn-success">
            <i class="fa-solid fa-floppy-disk me-1"></i>
            {{ empty($post->id) ? 'Salva' : 'Modifica' }}
          </button>
        </div>
      </form>
    </div>
  </section>
@endsection

@section('css')
  <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    referrerpolicy="no-referrer" rel="stylesheet" />
@endsection
