<div class="row g-4">
    @foreach ($cars as $car)
        <div class="col-md-4">
            <div class="card shadow-sm">
                <svg class="bd-placeholder-img card-img-top" role="img" aria-label="Car Image" width="100%"
                    height="150" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice"
                    focusable="false">
                    <title>Car Image</title>
                    <rect width="100%" height="100%" fill="#55595c"></rect>
                </svg>

                <div class="card-body">
                    <h5 class="card-title mb-4">Registration: {{ $car->registration_number }}</h5>
                    <p class="card-text"><strong>Model:</strong> {{ $car->model_name }} ({{ $car->model_year }})</p>
                    <p class="card-text"><strong>Total Kilometers:</strong> {{ $car->total_kilometers }} km</p>
                    <p class="card-text"><strong>Luggage Capacity:</strong> {{ $car->luggage_capacity }} L</p>
                    <p class="card-text"><strong>Passenger Capacity:</strong> {{ $car->passenger_capacity }}
                        passengers
                    </p>
                    <p class="card-text"><strong>Daily Rate:</strong> ${{ $car->daily_rate }}</p>
                    @if ($car->rate_per_kilometer)
                        <p class="card-text"><strong>Rate per Kilometer:</strong> ${{ $car->rate_per_kilometer }}
                        </p>
                    @endif
                    <p class="card-text"><strong>Late Fee:</strong> ${{ $car->late_fee_per_hour }}/hr</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('startBooking') }}" method="POST">
                            @csrf
                            <input name="car_id" type="hidden" value="{{ $car->id }}">
                            <button class="btn btn-outline-secondary" type="submit">Rent</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center mt-3">
    {{ $cars->appends(request()->query())->links() }}
</div>
