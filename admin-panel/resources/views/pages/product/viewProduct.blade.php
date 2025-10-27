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

      <table class="table table-striped table-bordered">
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
          @forelse($products as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $product->product_name }}</td>
              <td>{{ $product->category->name ?? '-' }}</td>
              <td>{{ number_format($product->price, 2) }}</td>
              <td>{{ Str::limit($product->description, 50) }}</td>
              <td>
                @if($product->image)
                  <img src="{{ asset('storage/' . $product->image) }}" alt="Image" style="width: 60px; height: auto;">
                @else
                  No Image
                @endif
              </td>
              <td>
                <a href="{{ route('productEdit', $product->id) }}" class="btn btn-sm btn-success me-1">
                  Edit
                </a>
                <form action="{{ route('productDelete', $product->id) }}" method="POST" style="display: inline-block;"
                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center">No products found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection