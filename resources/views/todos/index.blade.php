@extends('layouts.app')

@section('content')

<main class="container">
  <ul class="nav navbar-nav navbar-right">
      <li><a href="{{ route('todos.create') }}">Add</a></li>
  </ul>
  <ul>
    @forelse ($todos as $todo)
      <li>
        <a href="{{ route('todos.show', ['todo' => $todo->id]) }}">
          {{ $todo->title }}
        </a>
      </li>
    @empty
      <li>Nothing to do</li>
    @endforelse
  </ul>
</main>

@endsection
