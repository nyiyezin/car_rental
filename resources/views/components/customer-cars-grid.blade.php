<section class="section featured-car" id="featured-car">
    <div class="container">
        <div class="title-wrapper">
            <h2 class="h2 section-title">Featured cars</h2>
        </div>
        <div class="featured-car-list">
            @foreach ($cars as $car)
                <li>
                    <div class="featured-car-card">
                        <figure class="card-banner">
                            <div style="background: rgb(43, 42, 42)">
                                <div class="carousel slide" id="carouselExample-{{ $car->id }}">
                                    <div class="carousel-inner">
                                        @if ($car->images->isNotEmpty())
                                            @foreach ($car->images as $index => $image)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <img class="d-block w-100"
                                                        src="{{ Storage::url($image->file_path) }}"
                                                        alt="Image of {{ $car->model_name }}"
                                                        style="height: 300px; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="carousel-item active">
                                                <img class="d-block w-100" src="https://placehold.co/400"
                                                    alt="Placeholder image" style="height: 300px; object-fit: cover;">
                                            </div>
                                        @endif
                                    </div>

                                    <button class="carousel-control-prev"
                                        data-bs-target="#carouselExample-{{ $car->id }}" data-bs-slide="prev"
                                        type="button">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next"
                                        data-bs-target="#carouselExample-{{ $car->id }}" data-bs-slide="next"
                                        type="button">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>

                        </figure>

                        <div class="card-content">

                            <div class="card-title-wrapper">
                                <h3 class="h3 card-title">
                                    <a href="#">{{ $car->model_name }}</a>
                                </h3>

                                <data class="year" value="2021">{{ $car->model_year }}</data>
                            </div>

                            <ul class="card-list">

                                <li class="card-list-item">
                                    <ion-icon name="people-outline"></ion-icon>

                                    <span class="card-item-text">{{ $car->passenger_capacity }}</span>
                                </li>
                            </ul>

                            <div class="card-price-wrapper">
                                <span class="card-price">
                                    <strong>${{ $car->daily_rate }}</strong> / day
                                </span>
                                <form action="{{ route('startBooking') }}" method="POST">
                                    @csrf
                                    <input name="car_id" type="hidden" value="{{ $car->id }}">
                                    <button class="btn">Rent now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $cars->appends(request()->query())->links() }}
    </div>
</section>
