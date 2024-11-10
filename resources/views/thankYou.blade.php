@extends('layouts.app')
@section('content')
    <div class="d-flex align-items-center justify-content-center">
        <div class="bg-white shadow-lg rounded-4 p-4" style="max-width: 600px;">
            <div class="text-center">
                <h1 class="fw-bold text-dark display-4">Thank You ❤️</h1>
                <p>Thank you for choosing and trusting our car company</p>
            </div>
            <div class="bg-light mt-4 p-4 rounded-3 position-relative">
                <h2 class="text-center fw-medium fs-4 mt-2">What to do next!</h2>
                <p class="text-center text-muted">
                    You can go to any of our stores near you and present your reservation
                    invoice (digital or printed) and then pay and get your car.
                </p>
                <div class="d-flex justify-content-center mt-4">
                    <a class="btn btn-primary d-flex align-items-center justify-content-center gap-2 me-2"
                        href="{{ route('getInvoice', $bookingToken) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 576 512" fill="white">
                            <path
                                d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384v38.6C310.1
                                            219.5 256 287.4 256 368c0 59.1 29.1 111.3 73.7 143.3c-3.2 .5-6.4 .7-9.7
                                            .7H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM288 368a144 144
                                            0 1 1 288 0 144 144 0 1 1 -288 0zm211.3-43.3c-6.2-6.2-16.4-6.2-22.6
                                            0L416 385.4l-28.7-28.7c-6.2-6.2-16.4-6.2-22.6 0s-6.2 16.4 0 22.6l40
                                            40c6.2 6.2 16.4 6.2 22.6 0l72-72c6.2-6.2 6.2-16.4 0-22.6z" />
                        </svg>
                        <span>Print your invoice</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
