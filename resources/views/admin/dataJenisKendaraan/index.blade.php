@extends('layouts.master')

@section('content')

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Jenis Kendaraan</h5>
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button class="btn btn-success m-3" data-toggle="modal" data-target="#addModal">Tambah Data</button>
                                </div>
                            </div>
                            <!-- Default Table -->
                            <div class="table-responsive">
                                <table class="table" id="datatables">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Jenis Kendaraan</th>
                                            <th scope="col">Harga Parkir</th>
                                            <th scope="col">Harga Pajak</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Transport as $transport)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $transport->jenisKendaraan }}</td>
                                            <td>Rp. {{ number_format($transport->hargaParkir, 0, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($transport->pajak, 0, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex flex-row">
                                                    <button class="btn btn-primary btn-sm edit_kendaraan" data-id="{{ $transport->id }}" data-toggle="modal">Edit</button>
                                                    <button class="btn btn-danger btn-sm ml-2 delete_kendaraan" data-id="{{ $transport->id }}">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Edit -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Edit Data -->
                    <form id="form_edit_kendaraan" enctype="multipart/form-data">
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" name="jenisKendaraan" class="form-control" id="edit_jenis_kendaraan">
                        </div>
                        <div class="form-group">
                            <label for="edit_harga_parkir">Harga Parkir</label>
                            <input type="number" name="hargaParkir" class="form-control" id="edit_harga_parkir">
                        </div>
                        <div class="form-group">
                            <label for="edit_harga_pajak">Harga pajak</label>
                            <input type="number" name="pajak" class="form-control" id="edit_harga_pajak">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveEdit">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Add User  -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Kendaraan</h5>
                    <button type="button" id="closeXAdd" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('data-kendaraan.store') }}" method="POST" id="form-add-kendaraan" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="add_jenis_kendaraan">Jenis Kendaraan</label>
                            <input type="text" name="jenisKendaraan" class="form-control" id="add_jenis_kendaraan">
                        </div>
                        <div class="form-group">
                            <label for="add_harga_parkir">Harga Parkir</label>
                            <input type="number" name="hargaParkir" class="form-control" id="add_harga_parkir">
                        </div>
                        <div class="form-group">
                            <label for="add_harga_pajak">Harga pajak</label>
                            <input type="number" name="pajak" class="form-control" id="add_harga_pajak">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeAdd" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="saveAdd">Buat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        //variable global
        let data_kendaraan;
        const modalEdit = $('#edit_modal');
        let table = new DataTable('#datatables');

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
        };

        const modalAdd = $('#addModal');
        const batalButton = modalAdd.find('#closeAdd');
        const XButton = modalAdd.find('#closeXAdd');

        document.getElementById('form-add-kendaraan').addEventListener('submit', function(event) {
            localStorage.setItem('jenisKendaraan', $('#add_jenis_kendaraan').val());
            localStorage.setItem('hargaParkir', $('#add_harga_parkir').val());
            localStorage.setItem('pajak', $('#add_harga_pajak').val());
        });

        @if(Session('success'))
        toastr.success('{{ session('success') }}');
        @endif

        @if($errors->any())
        console.log(localStorage);
        modalAdd.modal('hide');
        const errorMessages = [];
        @foreach($errors->all() as $error)
        errorMessages.push('{{ $error }}');
        @endforeach
        const errorMessage = errorMessages.join('<br>');
        Swal.fire('Data gagal ditambah', errorMessage, 'error').then(() => {
            $('#add_jenis_kendaraan').val(localStorage.getItem('jenisKendaraan'));
            $('#add_harga_parkir').val(localStorage.getItem('hargaParkir'));
            $('#add_harga_pajak').val(localStorage.getItem('pajak'));
            modalAdd.modal('show');
        });

        @endif
        modalAdd.on('click', function(e) {
            if ($(e.target).hasClass('modal')) {
               modalAdd.modal('hide');
               $('#add_jenis_kendaraan').val(null);
               $('#add_harga_parkir').val(null);
               $('#add_harga_pajak').val(null);
            }
        });
        batalButton.on('click', function() {
            modalAdd.modal('hide');
            $('#add_jenis_kendaraan').val(null);
            $('#add_harga_parkir').val(null);
            $('#add_harga_pajak').val(null);
        });
        XButton.on('click', function() {
            modalAdd.modal('hide');
            $('#add_jenis_kendaraan').val(null);
            $('#add_harga_parkir').val(null);
            $('#add_harga_pajak').val(null);
        });

        //fungsi tampilkan data edit jenis kendaraan
        $(document).on('click', '.edit_kendaraan', function() {
            modalEdit.modal('show');
            data_kendaraan = $(this).data('id');
            axios.get(`/dashboard-admin/data-kendaraan/${data_kendaraan}/edit`)
            .then(response => {
                $('#edit_jenis_kendaraan').val(response.data.jenisKendaraan);
                $('#edit_harga_parkir').val(response.data.hargaParkir);
                $('#edit_harga_pajak').val(response.data.pajak);
            })
            .catch(error => {
                console.error('error fetching data: ', error)
            })
        })

        //fungsi update/edit jenis kendaraan
        document.getElementById('form_edit_kendaraan').addEventListener('submit', function(event) {
            event.preventDefault();

            let jenisKendaraan = $('#edit_jenis_kendaraan').val();
            let hargaParkir = $('#edit_harga_parkir').val();
            let pajak = $('#edit_harga_pajak').val();

            axios.put(`/dashboard-admin/data-kendaraan/${data_kendaraan}`, {
                jenisKendaraan: jenisKendaraan,
                hargaParkir: hargaParkir,
                pajak: pajak
            })
            .then(response => {
                modalEdit.modal('hide');
                swal.fire('Data berhasil di edit', '', 'success').then(() => {
                    window.location.href = '{{ route('data-kendaraan.index') }}';
                })
            })
            .catch(error => {
                console.error('Error updating data: ', error);
                modalEdit.modal('hide');
                if(error.response && error.response.status === 422){
                    const errorMessages = error.response.data.errors;
                    let errorMessage = '';

                    let isFirstError = true; // Flag to track the first error
                    for (const field in errorMessages) {
                        if (!isFirstError) {
                            errorMessage += ', '; // Add a comma before the error message
                        } else {
                            isFirstError = false;
                        }
                        errorMessage += errorMessages[field][0];
                    }
                    Swal.fire('Data gagal di edit', errorMessage, 'error').then(() => {
                        modalEdit.modal('show');
                    });
                }else{
                    Swal.fire('Data gagal di edit', 'Terjadi kesalahan pada sisi server, hubungi kami segera', 'error');
                }
                console.error(error);
            });
        })

        //fungsi delete data kendaraan
        $(document).on('click', '.delete_kendaraan', function(event) {
            const data_kendaraan = $(this).data('id');
            event.preventDefault();
            Swal.fire({
                title: 'Apa kamu ingin hapus data?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, saya mau hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/dashboard-admin/data-kendaraan/${data_kendaraan}`)
                    .then(() => {
                        Swal.fire(
                        'Terhapus!',
                        'Data nya berhasil dihapus!',
                        'success'
                        ).then(() => {
                            window.location.href = '{{ route('data-kendaraan.index') }}';
                        })
                    })
                    .catch(() => {
                        Swal.fire('Gagal dihapus', 'Terjadi kesalahan pada sisi server, hubungi developer kami', 'error');
                    })
                }
            })
        });
    })
</script>
@endpush
