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
  @can('delete', $todo)
    <form action="{{ route('todos.destroy', [$todo]) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button class="btn btn-default" type="submit">Delete</button>
    </form>
  @endcan
</main>

@endsection
