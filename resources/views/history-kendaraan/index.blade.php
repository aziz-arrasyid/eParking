<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link rel="stylesheet" href="{{ asset('/assets/css/history.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Hubungkan Font Awesome -->
    <title>eParking | history</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('/assets/img/logo_search.png') }}" alt="Logo Anda" class="logo img-fluid">
            </div>
            <div class="col-md-8">
                <div class="search-bar">
                    <input type="text" id="filter" class="search-input form-control" type="text" placeholder="Cari No Plat...">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card dengan data kendaraan -->
    <div class="container">
        {{-- {{ dd($parkir) }} --}}
        <div class="row" id="content">
            @foreach ($Parkir as $parkir)
            <div class="col-md-4">
                <div class="card mt-5 custom-card">
                    <div class="card-body">
                        <h5 class="card-title">PLAT NOMOR :</h5>
                        <div class="col">
                            <div class="card custom-small-card text-center">
                                <div class="card-body">
                                    <p class="card-text text-center">{{ $parkir->no_plat }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">Harga Parkir: Rp. {{ number_format($parkir->transport->hargaParkir, 0, ',', '.') }}</p>
                        <p class="card-text">Jenis Kendaraan: {{ $parkir->transport->jenisKendaraan }}</p>
                        <p class="card-text">Tipe pembayaran: {{ $parkir->payment_type }}</p>
                        <p class="card-text">Status pembayaran: {{ $parkir->status == 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}</p>
                        <p class="card-text">tanggal: {{ \Carbon\Carbon::parse($parkir->created_at)->isoFormat('dddd, D MMMM Y, [jam] HH:mm') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#filter').on('keyup', function() {
                var keyword = $(this).val().toLowerCase();
                $('#content > *').each(function() {
                    var content = $(this).text().toLowerCase();
                    if (content.includes(keyword)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
