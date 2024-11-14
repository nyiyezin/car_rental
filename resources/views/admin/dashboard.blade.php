@extends('admin.layout.layout')

@section('content')
    <div class="container-fluid">
        <table class="display" id="myTable">
            <thead>
                <tr>
                    <th>Car Name</th>
                    <th>Car Model</th>
                    <th>Total Capacity</th>
                    <th>Luggage Capacity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                    <tr>
                        <td>{{ $car->model_name }}</td>
                        <td>{{ $car->model_year }}</td>
                        <td>{{ $car->total_kilometers }}</td>
                        <td>${{ $car->luggage_capacity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
