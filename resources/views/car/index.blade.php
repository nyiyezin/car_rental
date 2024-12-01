@extends('layouts.app')

@section('content')
    <section>
        <div class="d-flex flex-column container" style="gap: 2rem">
            <div class="d-flex flex-column" style="gap: 1.5rem">
                <x-filter-cars-form :filterOptions="$filterOptions" />
            </div>
            <x-customer-cars-grid :cars="$cars" />
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function syncSliderWithOutput(sliderId, outputId) {
                const $slider = $('#' + sliderId);
                const $output = $('#' + outputId);
                $output.text($slider.val());
                $slider.on('input', function() {
                    $output.text($(this).val());
                });
            }

            syncSliderWithOutput('dailyRate', 'dailyRateOutput');
            syncSliderWithOutput('lateFee', 'lateFeeOutput');
            syncSliderWithOutput('ratePerKilometer', 'ratePerKilometerOutput');

            $('#carFilterForm').on('submit', function(event) {
                $(this).find(':input').each(function() {
                    if (($(this).attr('type') === 'checkbox' && !$(this).prop('checked')) ||
                        ($(this).attr('type') !== 'checkbox' && ($(this).val() === '' || $(this)
                            .val() == '0'))) {
                        $(this).attr('name', '');
                    }
                });
            });

            $('#carFilterForm').on('reset', function() {
                $('#dailyRateOutput').text(0);
                $('#lateFeeOutput').text(0);
                $('#ratePerKilometerOutput').text(0);
            });
        });
    </script>
@endpush
