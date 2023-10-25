@extends('layouts.master')

@section('content')
<section class="section dashboard">
    <div class="row">
        @foreach ($GajiBulanan as $gajiBulanan)
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Upah/Pajak <span>| {{ $gajiBulanan->bulan }}</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Uang Upah</h6>
                                <span class="text-success small pt-1 fw-bold">Rp. {{ number_format($gajiBulanan->cashUpah, 0, ',', '.') }}</span> <span class="text-muted small pt-2 ps-1">{{ $gajiBulanan->statusUpah }}</span>
                            </div>
                            <div class="ps-3">
                                <h6>Uang Pajak</h6>
                                <span class="text-success small pt-1 fw-bold">Rp. {{ number_format($gajiBulanan->cashPajak, 0, ',', '.') }}</span> <span class="text-muted small pt-2 ps-1">{{ $gajiBulanan->statusPajak }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        @if(Session('login'))
        toastr.success('{{ session('login') }}');
        @endif

        @if(Session('success'))
        toastr.success('{{ session('success') }}');
        @endif
    })
</script>
@endpush
