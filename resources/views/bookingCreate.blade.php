@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 border-end">
                <h2>{{ $car->model_name }} : {{ $car->registration_number }}</h2>
                <div class="d-flex align-items-center mt-4">
                    <h3 class="text-muted" id="car_daily_rate">Daily Rate: ${{ $car->daily_rate }}</h3>
                </div>
                <hr class="my-4">
                <form id="reservation_form" action="{{ route('storeBooking') }}" method="POST">
                    @csrf
                    <input name="car_id" type="hidden" value={{ $car->id }} />
                    <input id="total_amount" name="total_amount" type="hidden" />
                    <input id="tax_amount" name="tax_amount" type="hidden" />

                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.input name="identification_num" type="text" label="Identification Number" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input name="name" type="text" label="Name" />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.input name="phone_number" type="text" label="Phone Number" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input name="email" type="email" label="Email" />
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.select name="pickup_location_id" label="Pickup Location">
                                <option value="">Select a pickup location</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                            {{ old('pickup_location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->address }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>
                        <div class="col-md-6">
                            <x-form.select name="dropoff_location_id" label="Dropoff Location" required>
                                <option value="">Select a dropoff location</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                            {{ old('dropoff_location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->address }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                    <div class="row g-3 mt-0">
                        <div class="col-md-6">
                            <x-form.checkbox name="is_driver_included" value="1" label="Want to include the driver?" />
                        </div>
                        <div class="col-md-6">
                            <x-form.select name="driver_id" label="Select a driver" disabled>
                                <option value="">Choose Your Driver</option>
                                @foreach ($availableDrivers as $driver)
                                    <option value="{{ $driver->id }}"
                                            {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }} - ${{ number_format($driver->daily_rate, 0) }} per day
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                    <div class="row g-3 mt-0">
                        <div class="col-12">
                            <x-form.input name="rental_period" label="Choose Your Rental Period" />
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 d-none d-md-block mt-4" type="submit">Order Now</button>
                </form>
            </div>
            <div class="col-md-4">
                <div class="mb-2">
                    <img class="img-fluid rounded shadow-sm" src="https://via.placeholder.com/300x200" alt="Car Image">
                    <span class="badge bg-primary position-absolute start-0 top-0 m-2">20% OFF</span>
                </div>
                <div class="p-1">
                    <p class="fw-semibold">Toyota Corolla 2021 1.8L</p>
                </div>
                <div class="p-1">
                    <div class="d-flex align-items-center">
                        <p>Estimated Duration:</p>
                        <p class="ms-2 rounded" id="duration">-- days</p>
                    </div>
                </div>
                <div class="p-1">
                    <div class="d-flex align-items-center mt-2">
                        <p>Estimated Price:</p>
                        <p class="ms-2 rounded" id="estimated_price">-- $</p>
                    </div>
                </div>

                <div class="p-1">
                    <div class="d-flex align-items-center mt-2">
                        <p>Estimated Tax:</p>
                        <p class="ms-2 rounded" id="estimated_tax">-- $</p>
                    </div>
                </div>
                <div class="p-1">
                    <div class="d-flex align-items-center">
                        <p>Estimated Total Price:</p>
                        <p class="ms-2 rounded" id="estimated_total_amount">-- days</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rentalPeriodEle = document.querySelector('input[name="rental_period"]');
            const estimatedDurationEle = document.getElementById('duration');
            const estimatedPriceEle = document.getElementById('estimated_price');
            const estimatedTaxEle = document.getElementById('estimated_tax');
            const estimatedTotalPriceEle = document.getElementById('estimated_total_amount');
            const dailyRate = parseFloat('{{ $car->daily_rate }}');

            const driverIncludedCheckbox = document.querySelector('input[name="is_driver_included"]');
            const availableDriversSelect = document.querySelector('select[name="driver_id"]');

            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);

            function updateEstimates() {
                const selectedDates = rentalPeriodEle._flatpickr.selectedDates;
                if (selectedDates.length === 2) {
                    const [startDate, endDate] = selectedDates;
                    const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                    let estimatedPrice = duration * dailyRate;

                    if (driverIncludedCheckbox.checked && availableDriversSelect.value) {
                        const driverRateText = availableDriversSelect.options[availableDriversSelect.selectedIndex]
                            .textContent;
                        const driverRateMatch = driverRateText.match(/- \$(\d+)(?:\.\d+)? per day/);

                        if (driverRateMatch) {
                            const driverRate = parseFloat(driverRateMatch[1]);
                            estimatedPrice += duration * driverRate;
                        }
                    }

                    const estimatedTax = estimatedPrice * 0.055;
                    const estimatedTotalPrice = estimatedPrice + estimatedTax;

                    estimatedDurationEle.textContent = `${duration} days`;
                    estimatedPriceEle.textContent = `${estimatedPrice}$`;
                    estimatedTaxEle.textContent = `${estimatedTax.toFixed(0)}$`;
                    estimatedTotalPriceEle.textContent = `${estimatedTotalPrice.toFixed(0)}$`;
                }
            }

            rentalPeriodEle.flatpickr({
                mode: 'range',
                dateFormat: 'Y-m-d',
                defaultDate: [today, tomorrow],
                onChange: updateEstimates
            });

            updateEstimates();

            driverIncludedCheckbox.addEventListener('change', () => {
                availableDriversSelect.disabled = !driverIncludedCheckbox.checked;
                if (!driverIncludedCheckbox.checked) availableDriversSelect.selectedIndex = 0;
                updateEstimates();
            });

            availableDriversSelect.addEventListener('change', updateEstimates);
        });
    </script>
@endpush
