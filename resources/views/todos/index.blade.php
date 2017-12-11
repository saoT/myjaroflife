@extends('layouts.app')

@section('content')

<main class="container">
  <ul>
    @forelse ($todos as $todo)
      <li>{{ $todo->title }}</li>
    @empty
      <li>Nothing to do</li>
    @endforelse
  </ul>
</main>

@endsection
