<form class="row g-3 hero-form" id="carFilterForm" action="{{ route('cars.index') }}" method="GET">
    <div class="col-md-6">
        <x-form.input name="carModelName" type="text" label="Search with Model Name"
            placeholder="Search with car model name" :value="old('carModelName', request()->carModelName)" />
    </div>

    <div class="col-md-6">
        <x-form.select name="carModelYear" label="Model Year">
            <option value="">Select Model Year</option>
            @foreach ($filterOptions['model_years'] as $year)
                <option value="{{ $year }}" {{ old('carModelYear') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </x-form.select>

    </div>

    <div class="col-md-6">
        <x-form.select name="luggageCapacity" label="Luggage Capacity">
            <option value="">Select Luggage Capacity</option>
            @foreach ($filterOptions['luggage_capacities'] as $capacity)
                <option value="{{ $capacity }}" {{ old('luggageCapacity') == $capacity ? 'selected' : '' }}>
                    {{ $capacity }}
                </option>
            @endforeach
        </x-form.select>

    </div>

    <div class="col-md-6">
        <x-form.select name="passengerCapacity" label="Passenger Capacity">
            <option value="">Select Passenger Capacity</option>
            @foreach ($filterOptions['passenger_capacities'] as $capacity)
                <option value="{{ $capacity }}" {{ old('passengerCapacity') == $capacity ? 'selected' : '' }}>
                    {{ $capacity }}
                </option>
            @endforeach
        </x-form.select>

    </div>

    <div class="col-md-6 col-lg-4">
        <label class="form-label" for="dailyRate">Daily Rate</label>
        <input class="form-range" id="dailyRate" name="dailyRate" type="range"
            value="{{ request()->dailyRate ?? 0 }}" min="0" max="1000" step="50">
        <output id="dailyRateOutput">{{ request()->dailyRate ?? 0 }}</output>
    </div>

    <div class="col-md-6 col-lg-4">
        <label class="form-label" for="lateFee">Late Fee per Hour</label>
        <input class="form-range" id="lateFee" name="lateFee" type="range" value="{{ request()->lateFee ?? 0 }}"
            min="0" max="100" step="5">
        <output id="lateFeeOutput">{{ request()->lateFee ?? 0 }}</output>
    </div>

    <div class="col-md-6 col-lg-4">
        <label class="form-label" for="ratePerKilometer">Rate per Kilometer</label>
        <input class="form-range" id="ratePerKilometer" name="ratePerKilometer" type="range"
            value="{{ request()->ratePerKilometer ?? 0 }}" min="0" max="5" step="0.1">
        <output id="ratePerKilometerOutput">{{ request()->ratePerKilometer ?? 0 }}</output>
    </div>

    <div class="col-12 d-flex mb-3 justify-content-end" style="gap: 1rem;">
        <button class="btn" type="reset" onclick="window.location='{{ route('cars.index') }}'">Reset
            Filters</button>
        <button class="btn" type="submit">Filter Cars</button>
    </div>
</form>
