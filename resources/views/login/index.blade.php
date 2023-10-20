@extends('login.layouts.master')

@section('content')
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="#" class="logo d-flex align-items-center w-auto">
                                <img src="{{ asset('assets/img/logo_blue.png') }}" alt="">
                                <span class="d-none d-lg-block">eParking</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Login to Your eParking</h5>
                                    <p class="text-center small">Enter your username & password to login</p>
                                </div>

                                <form action="{{ route('authenticate') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12 mb-3">
                                        <label for="yourUsername" class="form-label">Username</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">
                                                <i class="bi bi-person-fill"></i>
                                            </span>
                                            <input type="text" name="username" class="form-control" id="yourUsername">
                                            {{-- <div class="invalid-feedback">Please enter your username.</div> --}}
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">
                                                <i class="ri-lock-2-fill"></i>
                                            </span>
                                            <input type="password" name="password" class="form-control" id="yourPassword">
                                            {{-- <div class="invalid-feedback">Please enter your username.</div> --}}
                                        </div>
                                        {{-- <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword"> --}}
                                        {{-- <div class="invalid-feedback">Please enter your password!</div> --}}
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="credits">
                            created by <a href="https://smkn4-tanjungpinang.sch.id/" target="_blank">SMKN4 TanjungPinang</a>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

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

        @if(Session('error-salah'))
        toastr.error('{{ session('error-salah') }}');
        @endif

        //toastr gagal start
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error('{{ $error }}');
        @endforeach
        @endif
        // toastr gagal end
    })
</script>
@endpush
