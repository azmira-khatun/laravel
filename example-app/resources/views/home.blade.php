@extends('master')
@section('content')



    <div class="d-flex justify-content-center gap-4 flex-wrap">

        <!-- Card 1 -->
        <div class="card shadow-sm" style="width: 18rem;">
            <!-- Placeholder image for visual clarity -->
            <img src="https://placehold.co/286x180/4F46E5/FFFFFF?text=Card+One+Image" class="card-img-top"
                alt="Placeholder image for Card 1">
            <div class="card-body">
                <h5 class="card-title text-primary">Service Title A</h5>
                <p class="card-text text-secondary">
                    This is the content for the first card. It contains quick example text to introduce the service or
                    product.
                </p>
                <a href="#" class="btn btn-primary w-100 mt-2">View Details</a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card shadow-sm" style="width: 18rem;">
            <!-- Placeholder image for visual clarity -->
            <img src="https://placehold.co/286x180/10B981/FFFFFF?text=Card+Two+Image" class="card-img-top"
                alt="Placeholder image for Card 2">
            <div class="card-body">
                <h5 class="card-title text-success">Service Title B</h5>
                <p class="card-text text-secondary">
                    This is the content for the second card. It explains how this service can benefit the user.
                </p>
                <a href="#" class="btn btn-success w-100 mt-2">Get Started</a>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="card shadow-sm" style="width: 18rem;">
            <!-- Placeholder image for visual clarity -->
            <img src="https://placehold.co/286x180/10B981/FFFFFF?text=Card+Two+Image" class="card-img-top"
                alt="Placeholder image for Card 2">
            <div class="card-body">
                <h5 class="card-title text-success">Service Title B</h5>
                <p class="card-text text-secondary">
                    This is the content for the second card. It explains how this service can benefit the user.
                </p>
                <a href="#" class="btn btn-success w-100 mt-2">Get Started</a>
            </div>
        </div>

    </div>

@endsection