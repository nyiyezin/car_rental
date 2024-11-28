@extends('admin.layout.layout')

@section('content')
    <div class="container">
        <h1 class="mb-3">Create New Car</h1>

        <form class="row g-3" action="{{ route('adminCarStore') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="col-md-6">
                <x-form.input name="registration_number" label="Registration Number" :value="old('registration_number')" />
            </div>
            <div class="col-md-6">
                <x-form.input name="model_name" label="Model Name" :value="old('model_name')" />
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input name="total_kilometers" type="number" label="Total Kilometers" :value="old('total_kilometers')" />
                </div>

            </div>
            <div class="col-md-6">
                <x-form.select name="model_year" label="Model Year">
                    <option value="">Select Model Year</option>
                    @for ($year = 1995; $year <= 2023; $year++)
                        <option value="{{ $year }}" {{ old('model_year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </x-form.select>
            </div>

            <div class="col-md-6">
                <x-form.select name="luggage_capacity" label="Luggage Capacity">
                    <option value="">Select Luggage Capacity</option>
                    @for ($luggage_capacity = 1; $luggage_capacity <= 6; $luggage_capacity++)
                        <option value="{{ $luggage_capacity }}"
                            {{ old('luggage_capacity') == $luggage_capacity ? 'selected' : '' }}>
                            {{ $luggage_capacity }}
                        </option>
                    @endfor
                </x-form.select>
            </div>
            <div class="col-md-6">
                <x-form.select name="passenger_capacity" label="Passenger Capacity">
                    <option value="">Select Luggage Capacity</option>
                    @for ($passenger_capacity = 1; $passenger_capacity <= 6; $passenger_capacity++)
                        <option value="{{ $passenger_capacity }}"
                            {{ old('passenger_capacity') == $passenger_capacity ? 'selected' : '' }}>
                            {{ $passenger_capacity }}
                        </option>
                    @endfor
                </x-form.select>
            </div>

            <div class="col-md-6">
                <x-form.input name="daily_rate" type="number" label="Car Daily Rate" :value="old('daily_rate')" />
            </div>
            <div class="col-md-6">
                <x-form.input name="late_fee_per_hour" type="number" label="Late Fee Per Hour" :value="old('late_fee_per_hour')" />
            </div>

            <div class="col-md-6">
                <x-form.input name="rate_per_kilometer" type="number" label="Rate Per Kilometer" :value="old('rate_per_kilometer')" />
            </div>
            <div class="col-md-6">
                <x-form.checkbox name="is_available" label="Is Car Available For Now?" :checked="old('is_available') === 1" />
            </div>

            <div class="upload" id="carImageUpload">
                <div class="upload__button-wrapper mb-3">
                    <label class="upload__button btn btn-secondary">
                        <span class="upload__button-text">Upload images</span>
                        <input class="upload__input d-none" name="images[]" data-max-length="20" type="file" multiple>
                    </label>
                </div>
                <div class="upload__preview d-flex flex-wrap gap-2">
                    @if ($errors->has('images'))
                        <span class="text-danger">{{ $errors->first('images') }}</span>
                    @endif
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Create Car</button>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        const $carImageUploadContainer = $("#carImageUpload");
        if ($carImageUploadContainer.length) {
            initializeImageUpload($carImageUploadContainer);
        }
    </script>
@endpush
