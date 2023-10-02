<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/assets/css/payment.css') }}">

    <!-- link fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;1,500&family=Poppins&display=swap" rel="stylesheet">

    <title>Pilih Mode Pembayaran</title>
</head>
<body>
    <main>
        <h1>PINDAI KODE QR</h1>
        <div class="container">
            <div class="row">
                <img src="qr.png" alt="kodeqr">
                <h3 class="custom-font">Bagaimana cara scan QR ?</h3>
                <ol class="tutorial">
                    <li>Buka aplikasi pemindai</li>
                    <li>Arahkan kamera ke qris</li>
                    <li>Lalu lanjutkan pembayaran qris</li>
                </ol>
            </div>
            <a href="{{ route('data-parkir.index') }}" class="back-button">Kembali</a>
        </div>
    </main>
</body>
</html>
