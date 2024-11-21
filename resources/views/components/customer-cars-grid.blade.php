<div class="car-listing">
    @foreach ($cars as $car)
        <div class="car-item">
            <div style="background: rgb(43, 42, 42)">
                <div class="carousel slide" id="carouselExample-{{ $car->id }}">
                    <div class="carousel-inner">
                        @if ($car->images->isNotEmpty())
                            @foreach ($car->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{ Storage::url($image->file_path) }}"
                                         alt="Image of {{ $car->model_name }}" style="height: 300px; object-fit: cover;">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="https://placehold.co/400" alt="Placeholder image"
                                     style="height: 300px; object-fit: cover;">
                            </div>
                        @endif
                    </div>

                    <button class="carousel-control-prev" data-bs-target="#carouselExample-{{ $car->id }}"
                            data-bs-slide="prev" type="button">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" data-bs-target="#carouselExample-{{ $car->id }}"
                            data-bs-slide="next" type="button">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <h3 class="car-item__title">{{ $car->model_name }}</h3>
            <p class="car-item__is-available">{{ $car->model_year }}</p>
            <div class="car-item__features">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-person"></i>
                    <span class="gap-8">{{ $car->passenger_capacity }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-briefcase"></i>
                    <span class="gap-8">{{ $car->luggage_capacity }}</span>
                </div>
            </div>
            <div class="car-item__priceAndBooking">
                <div>
                    <p>starts from</p>
                    <h6>{{ $car->daily_rate }}/ Hour</h6>
                </div>
                <form action="{{ route('startBooking') }}" method="POST">
                    @csrf
                    <input name="car_id" type="hidden" value="{{ $car->id }}">
                    <button class="car-item__booking-btn" type="submit">Rent</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $cars->appends(request()->query())->links() }}
</div>
