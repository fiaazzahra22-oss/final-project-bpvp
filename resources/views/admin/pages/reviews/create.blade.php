@extends('admin.master')

@section('content')
      <h1>Create Review</h1>
      <form action="{{ route('admin.reviews.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Reviewer</label>
        <input type="text" name="reviewer" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label>Rating</label>
        <input type="number" name="rating" min="1" max="5" class="form-control" required>
    </div>

    <button class="btn btn-primary">Create Review</button>
</form>
@endsection