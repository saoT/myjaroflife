@extends('layouts.app')

@section('content')

<main class="container">
  @can('update', $todo)
    <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ route('todos.edit', [$todo]) }}">Edit</a></li>
    </ul>
  @endcan
  <h1>{{ $todo->title }}</h1>
  <aside>for {{ $todo->user->name }}</aside>
  <p>{{ $todo->content }}</p>
</main>

@endsection
