@extends('layouts.app')
@section('content')
    <div class="container mb-5 p-4 bg-light shadow rounded">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="fs-3 d-print-none">Invoice # {{ $booking->booking_token }}</p>
            <p class="fs-5 d-none d-print-block">Invoice # {{ $booking->booking_token }}</p>
            <div class="d-flex flex-column d-print-none" style="gap: 0.5rem">
                <button class="btn btn-outline-primary me-2" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
                <a class="btn btn-primary" href="{{ route('downloadInvoice', $booking->booking_token) }}">
                    Download
                </a>
            </div>
        </div>
        <p class="text-center fst-italic text-secondary">
            You can go to any of our stores near you and present your
            reservation invoice (digital or printed), then pay and get your car.
        </p>

        <div class="row mt-4">
            <div class="col-md-6">
                <h3>Staff</h3>
                <address class="text-muted">
                    Nyi Ye Zin<br>
                    <a class="text-dark" href="tel:+950926070">950926070</a> |
                    <a class="text-dark" href="mailto:nyiyezin11@gmail.com">nyiyezin11@gmail.com</a>

                </address>
            </div>
            <div class="col-md-6 text-md-end">
                <h3>Client</h3>
                <p class="text-muted">
                    {{ $booking->customer->name }}<br>
                    {{ $booking->customer->email }}
                </p>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered border-secondary">
                <thead class="table-dark">
                    <tr>
                        <th>Car</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $booking->car->model_name }}</strong><br>
                            <span class="text-muted">Reg #: {{ $booking->car->registration_number }}</span><br>
                            <span class="text-muted">Late Fee/Hour: {{ $booking->car->late_fee_per_hour }} $</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($booking->rental_start_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->rental_end_date)->format('d/m/Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row mt-5">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <table class="table table-borderless">
                    <tr>
                        <th>Subtotal</th>
                        <td class="text-end">{{ $booking->payment->total_amount }} $</td>
                    </tr>
                    <tr>
                        <th>Tax (5%)</th>
                        <td class="text-end">{{ $booking->payment->tax_amount }} $</td>
                    </tr>
                    <tr class="fw-bold text-primary">
                        <th>Total to Pay</th>
                        <td class="text-end">{{ $booking->payment->total_amount + $booking->payment->tax_amount }} $</td>
                    </tr>
                </table>
            </div>
        </div>

        <p class="text-center mt-5 fs-5 d-print-none">Thank you for choosing and trusting our car company ❤️</p>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            if (window.location.search.includes('print=true')) {
                window.print();
            }
        });
    </script>
@endpush
