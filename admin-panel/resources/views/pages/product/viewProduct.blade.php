@extends('master')

@section('content')
  <div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3>Products List</h3>
      <a href="{{ route('productCreate') }}" class="btn btn-info">Add Product</a>
    </div>
    <div class="card-body">
      @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
      @endif

      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $product->product_name }}</td>
              <td>{{ $product->category->category_name ?? '-' }}</td>
              <td>{{ $product->price }}</td>
              <td>{{ Str::limit($product->description, 50) }}</td>
              <td>
                @if($product->image_path)
                  <img src="{{ asset('storage/' . $product->image_path) }}"
                       alt="Image"
                       style="width: 60px; height: auto;">
                @else
                  No Image
                @endif
              </td>
              <td>
                <a href="{{ route('productEdit', $product->id) }}" class="btn btn-sm btn-success me-1">
                  Edit
                </a>
                <form action="{{ route('productDelete', $product->id) }}" method="POST"
                      style="display: inline-block;"
                      onsubmit="return confirm('Are you sure you want to delete?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
