@extends('layouts.app')

@section('title', 'Dettaglio categoria')

@section('content')
  <section>
    <div class="container">
      <a class="btn btn-primary my-4" href="{{ route('admin.categories.index') }}">
        <i class="fa-solid fa-table me-1"></i>
        Torna alla lista
      </a>

      <h1 class="mb-4">{{ $category->label }} </h1>
      <p>{!! $category->getBadge() !!}</p>

      <h3>Related posts</h3>
      <table class="table">
        <thead>
          <th>ID</th>
          <th>Title</th>
          <th></th>
        </thead>
        <tbody>
          @foreach ($related_posts as $post)
            <tr>
              <td>{{ $post->id }}</td>
              <td>{{ $post->title }}</td>
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
          @endforeach
        </tbody>
      </table>

      {{ $related_posts->links('pagination::bootstrap-5') }}
  </section>
@endsection


@section('modal')
  @foreach ($related_posts as $post)
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
