<x-mail::message>
  # Ciao {{ $user->name }}

  Il tuo post "{{ $post->title }}" è stato creato correttamente

  <x-mail::button :url="route('admin.posts.show', $post)">
    Vedi post
  </x-mail::button>

  Grazie, <br>
  il team di {{ config('app.name') }}
</x-mail::message>
