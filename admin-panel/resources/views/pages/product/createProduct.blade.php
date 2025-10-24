@extends('master')

@section('content')
  <div class="card mt-4">
    <div class="card-header">
      <h3>Add New Product</h3>
    </div>
    <div class="card-body">
      @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
      @endif

      <form method="POST" action="{{ route('productStore') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
          <label for="product_name">Product Name</label>
          <input type="text" name="product_name" id="product_name"
            class="form-control @error('product_name') is-invalid @enderror" value="{{ old('product_name') }}">
          @error('product_name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- <div class="form-group mb-3">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id"
                    class="form-control @error('category_id') is-invalid @enderror">
              <option value="">Select Category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}"
                  {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->category_name }}
                </option>
              @endforeach
            </select>
            @error('category_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div> -->

        <div class="form-group mb-3">
          <label for="price">Price</label>
          <input type="number" name="price" id="price" step="0.01"
            class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
          @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group mb-3">
          <label for="description">Description</label>
          <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
            rows="3">{{ old('description') }}</textarea>
          @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group mb-3">
          <label for="image">Image</label>
          <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
          @error('image')
            <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
@endsection