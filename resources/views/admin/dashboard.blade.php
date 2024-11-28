@extends('admin.layout.layout')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-md-4 me-auto">
                <a class="btn btn-primary" href="{{ route('adminCarCreate') }}">Create New Car</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Car Name</th>
                        <th>Car Model</th>
                        <th>Total Capacity</th>
                        <th>Luggage Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                        <tr>
                            <td>{{ $car->model_name }}</td>
                            <td>{{ $car->model_year }}</td>
                            <td>{{ $car->total_kilometers }}</td>
                            <td>{{ $car->luggage_capacity }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-id="{{ $car->id }}"
                                    id="editCarBtn-{{ $car->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteCarModal-{{ $car->id }}">Delete</button>
                            </td>
                        </tr>
                        <x-admin.modals.deleteCarModal :car="$car" />
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[id^="editCarBtn-"]').on('click', function() {
                const carId = $(this).data('id');
                $.ajax({
                    url: `/admin/edit-car/${carId}`,
                    success: function(data) {
                        $('body').append(data.modalHtml);
                        var myModal = new bootstrap.Modal(document.getElementById(
                            'editCarModal-' + carId));
                        myModal.show();
                        initializeImageUpload($("#carImageEdit-" + carId))
                    }
                });
            });
        });
    </script>
@endpush
