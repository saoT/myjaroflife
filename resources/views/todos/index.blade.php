@extends('layouts.app')

@section('content')

<main class="container">
  @can('create', App\Todo::class)
    <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ route('todos.create') }}">Add</a></li>
    </ul>
  @endcan
  <ul>
    @forelse ($todos as $todo)
      <li>
        <a href="{{ route('todos.show', [$todo]) }}">
          {{ $todo->title }}
        </a>
      </li>
    @empty
      <li>Nothing to do</li>
    @endforelse
  </ul>
</main>

@endsection
