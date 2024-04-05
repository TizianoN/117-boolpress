@extends('layouts.app')

@section('title', empty($category->id) ? 'Creazione Categoria' : 'Modifica Categoria')

@section('content')
  <section>
    <div class="container">
      <a class="btn btn-primary my-4" href="{{ route('admin.categories.index') }}">
        <i class="fa-solid fa-table me-1"></i>
        Torna alla lista
      </a>

      <h1 class="mb-4">{{ empty($category->id) ? 'Creazione Categoria' : 'Modifica Categoria' }}</h1>

      {{-- @if ($errors->any())
        <div class="alert alert-danger mb-4">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif --}}

      <form
        action="{{ empty($category->id) ? route('admin.categories.store') : route('admin.categories.update', $category) }}"
        class="row g-3" method="POST">

        @if (!empty($category->id))
          @method('PATCH')
        @endif

        @csrf

        <div class="col-1">
          <label for="color">Colore</label>
          <input class="form-control" id="color" name="color" type="color"
            value="{{ old('title', $category->color) }}">
        </div>

        <div class="col-11">
          <label for="label">Etichetta</label>
          <input class="form-control" id="label" name="label" type="text"
            value="{{ old('title', $category->label) }}">
        </div>


        <div class="col-12">
          <button class="btn btn-success">
            <i class="fa-solid fa-floppy-disk me-1"></i>
            {{ empty($category->id) ? 'Salva' : 'Modifica' }}
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
