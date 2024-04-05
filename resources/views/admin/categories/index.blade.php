@extends('layouts.app')

@section('title', 'Lista categorie')

@section('content')
  <section>
    <div class="container">
      <a class="btn btn-primary my-4" href="{{ route('admin.categories.create') }}">
        <i class="fa-solid fa-plus me-1"></i>
        Nuovo Categoria
      </a>

      <h1 class="mb-4">Lista categorie</h1>

      <table class="table mb-4">
        <thead>
          <tr>
            <th>ID</th>
            <th>Etichetta</th>
            <th>Colore</th>
            <th>Badge</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td>{{ $category->label }}</td>
              <td>{{ $category->color }}</td>
              <td>{!! $category->getBadge() !!}</td>
              <td>
                <a class="btn btn-primary py-0" href="{{ route('admin.categories.show', $category) }}">
                  <i class="fa-solid fa-eye fa-xs"></i>
                </a>

                <a class="btn btn-primary py-0" href="{{ route('admin.categories.edit', $category) }}">
                  <i class="fa-solid fa-pencil fa-xs"></i>
                </a>

                <a class="btn btn-danger py-0" data-bs-target="#delete-category-{{ $category->id }}-modal"
                  data-bs-toggle="modal">
                  <i class="fa-solid fa-trash fa-xs"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="100%">
                <i>Nessun risultato trovato</i>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
@endsection

@section('modal')
  @foreach ($categories as $category)
    <div aria-hidden="true" aria-labelledby="staticBackdropLabel" class="modal fade" data-bs-backdrop="static"
      data-bs-keyboard="false" id="delete-category-{{ $category->id }}-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.categories.destroy', $category) }}" class="modal-content" method="POST">
          @csrf
          @method('DELETE')

          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Elimina Category</h1>
            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
          </div>
          <div class="modal-body">
            <p>
              Stai eliminando la categoria "{{ $category->label }}". L'operazione non è reversibile.
              <br /><br />

              <strong>Scegliere l'azione da eseguire con i post associati
                alla categoria "{{ $category->label }}"</strong>

              <select class="form-select mt-2" id="" name="delete-action">
                <option value="delete-posts">Cancella posts</option>

                @foreach ($categories as $category_options)
                  @if ($category_options->id != $category->id)
                    <option value="{{ $category_options->id }}">Associa a "{{ $category_options->label }}"</option>
                  @endif
                @endforeach
              </select>
            </p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Annulla</button>
            <button class="btn btn-danger">Elimina</button>
          </div>
        </form>
      </div>
    </div>
  @endforeach
@endsection

@section('css')
  <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    referrerpolicy="no-referrer" rel="stylesheet" />
@endsection
