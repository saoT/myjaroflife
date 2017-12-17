@extends('layouts.app')

@section('content')

<form action="{{ route('todos.store') }}" class="container" method="post">
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

  <div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" id="title" name="title" required type="text" value="{{ old('title') }}">
  </div>
  <div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" id="content" name="content" required>{{ old('content') }}</textarea>
  </div>
  <button class="btn btn-default" type="submit">Submit</button>
</form>

@endsection
