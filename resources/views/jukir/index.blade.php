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
                                {{--  --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Edit -->
<div class="modal fade" id="edit_modal_parkir" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Ubah Data</h5>
                <button type="button" id="closeXEdit" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Data -->
                <form id="form-edit" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_kendaraan">Jenis Kendaraan</label>
                        <select class="form-control" name="transport_id" id="edit_kendaraan">
                            @foreach ($Kendaraan as $kendaraan)
                            <option value="{{ $kendaraan->id }}">{{ $kendaraan->jenisKendaraan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_nomor_plat">No. Plat</label>
                        <input type="text" class="form-control" name="no_plat" id="edit_nomor_plat">
                        <input type="text" class="form-control" readonly value="{{ $DataDiri->id }}" name="jukir_id" id="edit_jukir">
                    </div>
                    <div class="form-group">
                        <label for="edit_kendaraan">Bayar Parkir</label>
                        <select class="form-control" name="status" id="edit_bayar_parkir">
                            <option value="paid">paid</option>
                            <option value="unpaid" id="unpaid">unpaid</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeEdit" data-dismiss="modal">Close</button>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Parkir</h5>
                <button type="button" class="close" id="closeXAdd" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-add" enctype="multipart/form-data" method="POST" action="{{ route('data-parkir.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="add_kendaraan">Jenis Kendaraan</label>
                        <select class="form-control" name="transport_id" id="add_kendaraan">
                            <option value="default" selected disabled>Silahkan dipilih</option>
                            @foreach ($Kendaraan as $kendaraan)
                            <option value="{{ $kendaraan->id }}">{{ $kendaraan->jenisKendaraan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add_nomor_plat">No. Plat</label>
                        <input type="text" class="form-control" name="no_plat" id="add_nomor_plat">
                        <input type="text" class="form-control" readonly value="{{ $DataDiri->id }}" name="jukir_id" id="add_jukir">
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

        axios.get(`/api/midtrans/notif-hook-get`).then(response => {
            if(response.data.status == 'success'){
                Swal.fire('Berhasil dibayar', '', 'success').then(() => {
                    window.location.reload();
                });
            }
        })

        @if(Session('success'))
        toastr.success('{{ session('success') }}');
        @endif

        const modalAdd = $('#addModal');
        const batalButton = modalAdd.find('#closeAdd');
        const XButton = modalAdd.find('#closeXAdd');


        document.getElementById('form-add').addEventListener('submit', function(event) {
            localStorage.setItem('kendaraan', $('#add_kendaraan').val());
            localStorage.setItem('nomor_plat', $('#add_nomor_plat').val());
        })

        @if($errors->any())
        modalAdd.modal('hide');
        const errorMessages = [];
        @foreach($errors->all() as $error)
        errorMessages.push('{{ $error }}');
        @endforeach
        const errorMessage = errorMessages.join('<br>');
        Swal.fire('Data gagal ditambah', errorMessage, 'error').then(() => {
            $('#add_kendaraan').val(localStorage.getItem('kendaraan'));
            $('#add_nomor_plat').val(localStorage.getItem('nomor_plat'));
            modalAdd.modal('show');
        });

        @endif
        modalAdd.on('click', function(e) {
            if ($(e.target).hasClass('modal')) {
                modalAdd.modal('hide');
                $('#add_kendaraan').val('default');
                $('#add_nomor_plat').val(null);
            }
        });
        batalButton.on('click', function() {
            modalAdd.modal('hide');
            $('#add_kendaraan').val('default');
            $('#add_nomor_plat').val(null);
        });
        XButton.on('click', function() {
            modalAdd.modal('hide');
            $('#add_kendaraan').val('default');
            $('#add_nomor_plat').val(null);
        });

        //table serverside
        let table = $('#datatables').DataTable({
            ajax: '{{ route('server.parkir') }}',
            processing: true,
            serverSide: true,
            deferRender: true,
            columns: [
            {
                title: 'No',
                data: null,
                render: function(data, type, row, meta){
                    return meta.settings._iDisplayStart + meta.row + 1;
                },
                searchable: false,
                orderable: false,
            },
            {
                title: 'No. Plat',
                data: 'no_plat'
            },
            {
                title: 'Jenis Kendaraan',
                data: 'transport.jenisKendaraan'
            },
            {
                title: 'Harga Parkir',
                data: 'transport.hargaParkir',
                render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp. ' )
            },
            {
                title: 'Status',
                data: 'status'
            },
            {
                title: 'Action',
                data: null,
                render: function(data, type, row){

                    return '<div class="d-flex flex-row">' +
                        '<button class="btn btn-primary btn-sm edit_modal" data-id="' + data.id + '" data-toggle="modal">Edit</button>' +
                        '<button class="btn btn-info ml-2 btn-sm bayarQRIS ' + (data.status == 'paid' ? 'disabled' : '') + '" data-id="' + data.id + '" id="bayarQRIS">Bayar QRIS</button>' +
                        '<button class="btn btn-danger btn-sm ml-2 delete-modal" data-toggle="modal" data-id="' + data.id + '" data-target="#deleteModal">Delete</button>' +
                        '</div>';
                    },
                    searhable: false,
                    orderable: false,
                },
                ],
                initComplete: function(){
                    //variable global
                    const modalEdit = $('#edit_modal_parkir');
                    let data_parkir = null;

                    //fungsi tampil data edit
                    $(document).on('click', '.edit_modal', function() {
                        // const modalEdit = $('#editModal');
                        modalEdit.modal('show');
                        const batalButtonEdit = modalEdit.find('#closeEdit');
                        const XButtonEdit = modalEdit.find('#closeXEdit');
                        data_parkir = $(this).data('id');

                        axios.get(`/dashboard-jukir/data-parkir/${data_parkir}/edit`).then(response => {
                            $('#edit_kendaraan').val(response.data.transport.id);
                            $('#edit_nomor_plat').val(response.data.no_plat);
                            $('#edit_bayar_parkir').val(response.data.status);
                            if(response.data.payment_type == 'qris')
                            {
                                $('#unpaid').css('display', 'none');
                            }
                        })

                        batalButtonEdit.on('click', function() {
                            modalEdit.modal('hide')
                            window.location.reload();
                        });
                        XButtonEdit.on('click', function() {
                            modalEdit.modal('hide');
                            window.location.reload();
                        });

                        modalEdit.on('click', function(e) {
                            if ($(e.target).hasClass('modal')) {
                                // Klik diluar modal, maka reload halaman
                                window.location.reload();
                            }
                        });

                    })

                    //fungsi update/edit data
                    document.getElementById('form-edit').addEventListener('submit', function(event) {
                        event.preventDefault();

                        let transport_id = $('#edit_kendaraan').val();
                        let no_plat = $('#edit_nomor_plat').val();
                        let jukir_id = $('#edit_jukir').val();
                        let status = $('#edit_bayar_parkir').val();
                        axios.put(`/dashboard-jukir/data-parkir/${data_parkir}`, {
                            transport_id: transport_id,
                            no_plat: no_plat,
                            jukir_id: jukir_id,
                            status: status,
                        }).then(response => {
                            modalEdit.modal('hide');
                            console.log(modalEdit);
                            swal.fire('Data berhasil di edit', '', 'success').then(() => {
                                window.location.reload();
                            })
                        })
                        .catch(error => {
                            modalEdit.modal('hide');
                            console.log(error.response.data);
                            if(error.response && error.response.status === 422){
                                const errorData = error.response.data;
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
                                if (errorData.error) {
                                    errorMessage += ', ' + errorData.error;
                                }
                                Swal.fire('Data gagal di edit', errorMessage, 'error').then(() => {
                                    modalEdit.modal('show');
                                });
                            }else{
                                Swal.fire('Data gagal di edit', 'Terjadi kesalahan pada sisi server, hubungi kami segera', 'error');
                            }
                        })
                    })

                    //fungsi delete data
                    $(document).on('click', '.delete-modal', function() {
                        let data_parkir = $(this).data('id');
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
                                axios.delete(`/dashboard-jukir/data-parkir/${data_parkir}`).then(response => {
                                    swal.fire('Data berhasil dihapus', '', 'success').then(() => {
                                        window.location.reload();
                                    })
                                }).catch(error => {
                                    swal.fire('Data gagal di hapus', '', 'error');
                                })
                            }
                        })
                    })

                    //fungsi bayar qris
                    $(document).on('click', '#bayarQRIS', function() {
                        let data_parkir = $(this).data('id');
                        console.log(data_parkir);
                        axios.post(`/dashboard-jukir/payment`, {id: data_parkir}).then(response => {
                                console.log(response.data.snapToken);
                                window.snap.pay(response.data.snapToken, {
                                onSuccess: function(result){
                                    /* You may add your own implementation here */
                                    window.location.reload();
                                },
                                onPending: function(result){
                                    /* You may add your own implementation here */
                                    // alert("wating your payment!"); console.log(result);
                                    console.log(result);
                                },
                                onError: function(result){
                                    /* You may add your own implementation here */
                                    // alert("payment failed!"); console.log(result);
                                    // json_callback(result);
                                    console.log('error');
                                    // swal.fire('payment failed!', '', 'error').then(() => {
                                    // })
                                },
                                onClose: function(){
                                    /* You may add your own implementation here */
                                    // alert('you closed the popup without finishing the payment');
                                    swal.fire('you closed the popup without finishing the payment', '', 'info').then(() => {
                                        window.location.reload();
                                    })
                                }
                            })
                        }).catch(error => {
                            console.log(error);
                        })


                    })

                }
            });
        })
    </script>
    @endpush
