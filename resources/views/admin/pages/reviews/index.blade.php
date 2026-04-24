@extends('admin.master')

@section('content')
      <h1>Reviews</h1>
      <hr>

      <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Reviewer</th>
            <th>Description</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        @forelse ($reviews as $review)
        <tr>
            <td>{{ $review->id }}</td>
            <td>{{ $review->reviewer }}</td>
            <td>{{ $review->description }}</td>
            <td>{{ $review->rating }}</td>

        <td>
            <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-info">View</a>
            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-warning">Edit</a>

            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;">
             @csrf
             @method('DELETE')
                <button class="btn btn-danger">Delete</button>
            </form>
        </td>
        </tr>
        @empty
<tr>
    <td colspan="5" class="text-center">No reviews found</td>
</tr>
@endforelse
</tbody>
      </table>
@endsection