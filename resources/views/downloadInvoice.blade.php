<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $booking->booking_token }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        h3 {
            color: #333;
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        p,
        address {
            margin: 0;
            font-size: 0.95rem;
            color: #555;
        }

        .text-muted {
            color: #666;
        }

        .text-end {
            text-align: right;
        }

        .text-primary {
            color: #007bff;
        }

        .fst-italic {
            font-style: italic;
        }

        .header,
        .client-info,
        .staff-info {
            margin-bottom: 20px;
        }

        .header p {
            font-size: 1.1rem;
            color: #333;
        }

        /* Table styling */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 0.95rem;
            text-align: left;
        }

        .table thead {
            background-color: #333;
            color: #fff;
        }

        .table .text-muted {
            font-size: 0.85rem;
            color: #777;
        }

        .totals-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .totals-table th,
        .totals-table td {
            padding: 8px;
            font-size: 1rem;
        }

        .totals-table th {
            text-align: left;
        }

        .totals-table .text-end {
            text-align: right;
        }

        .totals-table .fw-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <p>Invoice # {{ $booking->booking_token }}</p>
        </div>
        <p class="text-center fst-italic text-secondary">
            You can go to any of our stores near you and present your reservation invoice (digital or printed), then pay
            and get your car.
        </p>

        <div class="row mt-4">
            <div class="staff-info">
                <h3>Staff</h3>
                <address class="text-muted">
                    Nyi Ye Zin<br>
                    <a class="text-dark" href="tel:+950926070">950926070</a> |
                    <a class="text-dark" href="mailto:nyiyezin11@gmail.com">nyiyezin11@gmail.com</a>
                </address>
            </div>
            <div class="client-info text-end">
                <h3>Client</h3>
                <p class="text-muted">
                    {{ $booking->customer->name }}<br>
                    {{ $booking->customer->email }}
                </p>
            </div>
        </div>

        <table class="table">
            <thead>
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

        <table class="totals-table">
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
</body>

</html>
