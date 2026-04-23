@extends('admin.master')

@section('content')
<h1>Attractions</h1>

<a href="{{ route('admin.attractions.create') }}" class="btn btn-primary">
    Create Attraction
</a>

<hr>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Zone ID</th>
            <th>Name</th>
            <th>Price Range</th>
            <th>Image</th>
            <th width="180">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($attractions as $attraction)
            <tr>
                <td>{{ $attraction->id }}</td>

                {{-- kalau kamu punya relasi zone nanti bisa: $attraction->zone->name --}}
                <td>{{ $attraction->zone_id }}</td>

                <td>{{ $attraction->name }}</td>

                <td>{{ $attraction->price_range }}</td>

                <td>
                    <img src="{{ asset('storage/images/' . $attraction->image) }}"
                         alt="{{ $attraction->name }}"
                         width="100">
                </td>

                <td>
                    <a href="{{ route('admin.attractions.show', $attraction->id) }}"
                       class="btn btn-info btn-sm">
                        View
                    </a>

                    <a href="{{ route('admin.attractions.edit', $attraction->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('admin.attractions.destroy', $attraction->id) }}"
                          method="POST"
                          style="display:inline-block;">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">
                    No attractions found.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection