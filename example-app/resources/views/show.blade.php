<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Profiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .m-5 { margin: 3rem !important; }
        .p-8 { padding: 4rem !important; }
    </style>
</head>
<body>

    <div class="container m-5 p-8">
        <h2 class="mb-4"> User and Profiles(OneToOne)</h2>


        <table class="table table-success table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    {{-- Users Table Fields --}}
                    <th scope="col">User Name</th>
                    <th scope="col">User Email</th>
                    {{-- Profiles Table Fields --}}
                    <th scope="col">Phone</th>
                    <th scope="col">Country</th>
                    <th scope="col">Address</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($profiles as $profile)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>

                    {{-- User Data (Accessing through $profile->user relationship) --}}
                    @if ($profile->user)
                        <td>{{ $profile->user->name }}</td>
                        <td>{{ $profile->user->email }}</td>
                    @else
                        <td colspan="2" class="text-danger">User Deleted/Not Found</td>
                    @endif

                    {{-- Profile Data (Direct access from $profile object) --}}
                    <td>{{ $profile->phone ?? 'N/A' }}</td>
                    <td>{{ $profile->country ?? 'N/A' }}</td>
                    <td>{{ Str::limit($profile->address, 30) ?? 'N/A' }}</td>
                    <td>
                        {{-- প্রোফাইল ছবি --}}
                        @if($profile->profile_image)
                        <img src="{{ asset('storage/' . $profile->profile_image) }}" width="50" height="50" class="rounded-circle" alt="Profile Image">
                        @else
                        N/A
                        @endif
                    </td>

                    {{-- অ্যাকশন বাটন --}}
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('profile.view', $profile->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('profile.edit', $profile->id) }}" class="btn btn-sm btn-warning">Edit</a>
                           <form action="{{ route('profile.destroy', $profile->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this profile?')"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- প্রোফাইল না থাকলে মেসেজ --}}
        @if($profiles->isEmpty())
            <div class="alert alert-info" role="alert">
                No profiles found. Please create one!
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
