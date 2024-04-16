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


      {{-- @if ($errors->any())
        <div class="alert alert-danger mb-4">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif --}}


      <form action="{{ empty($post->id) ? route('admin.posts.store') : route('admin.posts.update', $post) }}"
        class="row g-3" enctype="multipart/form-data" method="POST">
        @if (!empty($post->id))
          @method('PATCH')
        @endif

        @csrf

        <div class="col-6">
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label" for="title">Titolo</label>
                <input @class(['form-control', 'is-invalid' => $errors->has('title')]) id="title" name="title" type="text"
                  value="{{ old('title', $post->title) }}" />
                @error('title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label" for="category_id">Categoria</label>
                <select @class(['form-select', 'is-invalid' => $errors->has('category_id')]) id="category_id" name="category_id">
                  <option class="d-none" value="">Seleziona una categoria</option>

                  @foreach ($categories as $category)
                    <option {{ $category->id == old('category_id', $post->category_id) ? 'selected' : '' }}
                      value="{{ $category->id }}">
                      {{ $category->label }}</option>
                  @endforeach
                </select>

                @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>


            <div class="col-12">
              <div class="mb-3">
                <label class="form-label" for="image">Immagine post</label>
                <input @class(['form-control', 'is-invalid' => $errors->has('image')]) id="image" name="image" type="file">
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if (!empty($post->image) && !empty($post->id))
                  <div class="preview-image-container">
                    <div class="delete-image-button">X</div>
                    <img alt="" class="img-fluid mt-3" src="{{ asset('storage/' . $post->image) }}">
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div @class(['is-invalid' => $errors->has('tags')])>
            @foreach ($tags as $tag)
              <div>
                <input {{ in_array($tag->id, old('tags', $post_tags_id ?? [])) ? 'checked' : '' }}
                  @class(['form-check-input', 'is-invalid' => $errors->has('tags')]) id="tags-{{ $tag->id }}" name="tags[]" type="checkbox"
                  value="{{ $tag->id }}">
                <label class="form-check-label" for="tags-{{ $tag->id }}">{{ $tag->label }}</label>
              </div>
            @endforeach
          </div>
          @error('tags')
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

      @if (!empty($post->image) && !empty($post->id))
        <form action="{{ route('admin.posts.destroy-img', $post) }}" class="d-none" id="delete-image-form"
          method="POST">
          @method('DELETE')
          @csrf
        </form>
      @endif
    </div>
  </section>
@endsection

@section('css')
  <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    referrerpolicy="no-referrer" rel="stylesheet" />
@endsection

@section('js')
  @if (!empty($post->image) && !empty($post->id))
    <script>
      const deleteImageButton = document.querySelector('.delete-image-button');
      const deleteImageForm = document.querySelector('#delete-image-form');

      deleteImageButton.addEventListener('click', () => {
        deleteImageForm.submit();
      })
    </script>
  @endif
@endsection
