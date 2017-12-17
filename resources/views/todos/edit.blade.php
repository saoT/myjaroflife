@extends('layouts.app')

@section('content')

<form action="{{ route('todos.update', [$todo]) }}" class="container" method="post">
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{ csrf_field() }}
  {{ method_field('PUT') }}

  <div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" id="title" name="title" required type="text" value="{{ old('title', $todo->title) }}">
  </div>
  <div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" id="content" name="content" required>{{ old('content', $todo->content) }}</textarea>
  </div>
  <a href="{{ route('todos.show', [$todo]) }}">Cancel</a>
  <button class="btn btn-default" type="submit">Submit</button>
</form>

@endsection
