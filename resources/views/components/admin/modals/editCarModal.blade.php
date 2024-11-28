<div class="modal fade" id="editCarModal-{{ $car->id }}" tabindex="-1"
    aria-labelledby="editCarLabel-{{ $car->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCarLabel-{{ $car->id }}">Edit Car</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('adminCarUpdate', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.input name="registration_number" label="Registration Number" :value="$car->registration_number" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input name="model_name" label="Model Name" :value="$car->model_name" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input name="total_kilometers" label="Total Kilometers" :value="$car->total_kilometers" />
                        </div>
                        <div class="col-md-6">
                            <x-form.select name="model_year" label="Model Year">
                                @for ($year = 1995; $year <= 2023; $year++)
                                    <option value="{{ $year }}"
                                        {{ $car->model_year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </x-form.select>
                        </div>
                        <div class="col-md-6">
                            <x-form.select name="luggage_capacity" label="Luggage Capacity">
                                @for ($luggage_capacity = 1; $luggage_capacity <= 6; $luggage_capacity++)
                                    <option value="{{ $luggage_capacity }}"
                                        {{ $car->luggage_capacity == $luggage_capacity ? 'selected' : '' }}>
                                        {{ $luggage_capacity }}</option>
                                @endfor
                            </x-form.select>
                        </div>
                        <div class="col-md-6">
                            <x-form.select name="passenger_capacity" label="Passenger Capacity">
                                @for ($passenger_capacity = 1; $passenger_capacity <= 6; $passenger_capacity++)
                                    <option value="{{ $passenger_capacity }}"
                                        {{ $car->passenger_capacity == $passenger_capacity ? 'selected' : '' }}>
                                        {{ $passenger_capacity }}</option>
                                @endfor
                            </x-form.select>
                        </div>
                        <div class="col-md-6">
                            <x-form.input name="daily_rate" label="Car Daily Rate" :value="$car->daily_rate" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input name="late_fee_per_hour" label="Late Fee Per Hour" :value="$car->late_fee_per_hour" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input name="rate_per_kilometer" label="Rate Per Kilometer" :value="$car->rate_per_kilometer" />
                        </div>
                        <div class="col-md-6">
                            <x-form.checkbox name="is_available" label="Is Car Available For Now?" :checked="$car->is_available === 1" />
                        </div>
                        <div class="upload" id="carImageEdit-{{ $car->id }}">
                            <div class="upload__button-wrapper mb-3">
                                <label class="upload__button btn btn-secondary">
                                    <span class="upload__button-text">Upload images</span>
                                    <input class="upload__input d-none" name="images[]" data-max-length="20"
                                        type="file" multiple>
                                </label>
                            </div>
                            <div class="upload__preview d-flex flex-wrap gap-2">
                                @if ($car->images)
                                    @foreach ($car->images as $image)
                                        <div class="upload__preview-item" data-id="{{ $image->id }}"
                                            style="background-image: url('{{ asset('storage/' . $image->file_path) }}')">
                                            <button type="button" class="upload__remove-button"
                                                data-file="{{ $image->file_path }}" data-existing="true">&times;
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <input type="hidden" name="removed_image_ids" id="removed_image_ids" value="[]">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
