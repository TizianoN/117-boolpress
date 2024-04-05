@extends('layouts.app')

@section('title', 'Lista posts')

@section('content')
  <section>
    <div class="container">
      <a class="btn btn-primary my-4" href="{{ route('admin.posts.create') }}">
        <i class="fa-solid fa-plus me-1"></i>
        Nuovo Post
      </a>

      <h1 class="mb-4">Lista posts</h1>

      <table class="table mb-4">
        <thead>
          <tr>
            <th>ID</th>
            <th>Titolo</th>
            <th>Categoria</th>
            <th>Autore</th>
            <th>Slug</th>
            {{-- <th>Estratto</th> --}}
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($posts as $post)
            <tr>
              <td>{{ $post->id }}</td>
              <td>{{ $post->title }}</td>
              <td>{!! $post->category?->getBadge() !!}</td>
              <td>{{ $post->user->name }}</td>
              <td>{{ $post->slug }}</td>
              {{-- <td>{{ $post->getAbstract(50) }}</td> --}}
              <td>
                <a class="btn btn-primary py-0" href="{{ route('admin.posts.show', $post) }}">
                  <i class="fa-solid fa-eye fa-xs"></i>
                </a>

                <a class="btn btn-primary py-0" href="{{ route('admin.posts.edit', $post) }}">
                  <i class="fa-solid fa-pencil fa-xs"></i>
                </a>

                <a class="btn btn-danger py-0" data-bs-target="#delete-post-{{ $post->id }}-modal"
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

      {{ $posts->links('pagination::bootstrap-5') }}
    </div>
  </section>
@endsection

@section('modal')
  @foreach ($posts as $post)
    <div aria-hidden="true" aria-labelledby="staticBackdropLabel" class="modal fade" data-bs-backdrop="static"
      data-bs-keyboard="false" id="delete-post-{{ $post->id }}-modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Elimina Post</h1>
            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"></button>
          </div>
          <div class="modal-body">
            Stai eliminando il post "{{ $post->title }}". L'operazione non è reversibile.
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Annulla</button>

            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger">Elimina</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection

@section('css')
  <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    referrerpolicy="no-referrer" rel="stylesheet" />
@endsection
