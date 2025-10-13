@extends('master')
@section('page')
    <div class="card">
        <div class="header pb-5 pt-5 pt-lg-8 d-flex align-items-center"
            style="min-height: 50px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-default opacity-8"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-10 text-center">
                        <h1 class="display-2 text-white text-center"> Categories List</h1>
                        <a href="{{ route('create') }}" class="btn btn-info">Add Categories</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>

        <table class="table table-praimary table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cats as $cat)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->price }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('edit', $cat->id) }}">
                                    <button class="btn btn-md btn-success me-1 p-1"><i class="bi bi-pencil-square"></i></button>
                                </a>

                                <form action="{{route('delete')}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type="text" name="catagory_id" value="{{ $cat->id }}" hidden>
                                    <button class="btn btn-md btn-danger  p-1"><i class="bi bi-trash3-fill"></i></button>
                                </form>


                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    </div>
@endsection