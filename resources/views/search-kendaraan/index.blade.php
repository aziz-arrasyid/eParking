<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <title>eParking | search</title>
    <!-- Tambahkan tautan ke Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Tambahkan tautan ke file CSS eksternal -->
    <link rel="stylesheet" href="{{ asset('/assets/css/search_kendaraan.css') }}">
</head>
<body>
    <!-- content -->
    <div class="container text-center mt-2 container-scroll">
        <img src="{{ asset('/assets/img/logo_search.png') }}" alt="Logo" class="logo mb-5">
        <div class="mb-2">
            <input type="text" name="no_plat" class="form-control search-input" placeholder="Cari Kendaraan.. example: BP 2006 B" aria-label="Cari Kendaraan" aria-describedby="button-addon2" id="search_input">
        </div>
        <button class="btn btn-secondary btn-sm" type="button" id="button_kirim"><span style="margin-right: 5px;">Cari Kendaraan</span> <i class="fas fa-search" ></i></button>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <a href="https://www.instagram.com/eparkingtanjungpinang/" class="link" target="_blank">
                <p>&copy; <span id="currentYear"></span> RPL SMKN 4 Tanjungpinang</p>
            </a>
        </div>
    </footer>

    <!-- Include jQuery dan Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- JavaScript untuk menampilkan tahun saat ini -->
    <script>
        $(document).ready(function() {
            document.addEventListener("DOMContentLoaded", function () {
                const currentYearElement = document.getElementById("currentYear");
                const currentYear = new Date().getFullYear();
                currentYearElement.textContent = currentYear;
            });

            @if(Session('error'))
            Swal.fire('Data tidak ditemukan', '{{ session('error') }}', 'error');
            @endif

            $(document).on('click', '#button_kirim', function() {
                let no_plat = $('#search_input').val();
                if(no_plat == ''){
                    Swal.fire('Data tidak ditemukan', 'Input pencarian tidak boleh kosong', 'error');
                }else{
                    window.location.href = `history-parkir/${no_plat}`;
                }
            })
        })
    </script>

</body>
</html>
