@extends('layouts.master')

@section('content')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Jukir</h5>
                        <div class="row justify-content-end">
                            {{-- <div class="col-auto">
                                <button class="btn btn-success m-3" data-toggle="modal" data-target="#addModal">Tambah Jukir</button>
                            </div> --}}
                        </div>
                        <!-- Default Table -->
                        <div class="table-responsive">
                            <table class="table" id="datatables">
                                {{--  --}}
                            </table>
                        </div>
                        <!-- End Default Table -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Edit -->
{{-- <div class="modal fade" id="edit-modal-jukir" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
                        <label for="editName">Nama</label>
                        <input type="text" name="name" class="form-control" id="editName">
                    </div>
                    <div class="form-group">
                        <label for="editUsername">Username</label>
                        <input type="text" name="username" class="form-control" id="editUsername">
                    </div>
                    <div class="form-group">
                        <label for="editAge">Umur</label>
                        <input type="text" name="age" class="form-control" id="editAge">
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Nomor HP</label>
                        <input type="text" name="phoneNumber" class="form-control" id="editPhone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeEdit" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveEdit">Save changes</button>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Jukir</h5>
                <button type="button" id="closeXAdd" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Add User -->
                <form action="{{ route('data-jukir.store') }}" method="POST" id="form-add" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="add_username">Nama</label>
                        <input type="text" name="name" class="form-control" id="add_username">
                    </div>
                    <div class="form-group">
                        <label for="add_age">Umur</label>
                        <input type="number" name="age" class="form-control" id="add_age">
                    </div>
                    <div class="form-group">
                        <label for="add_phone">Nomor HP</label>
                        <input type="number" name="phoneNumber" class="form-control" id="add_phone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeAdd" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="saveAdd">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
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

        const modalAdd = $('#addModal');
        const batalButton = modalAdd.find('#closeAdd');
        const XButton = modalAdd.find('#closeXAdd');


        // document.getElementById('form-add').addEventListener('submit', function(event) {
        //     localStorage.setItem('name', $('#add_username').val());
        //     localStorage.setItem('age', $('#add_age').val());
        //     localStorage.setItem('phoneNumber', $('#add_phone').val());
        // })

        @if($errors->any())
        modalAdd.modal('hide');
        const errorMessages = [];
        @foreach($errors->all() as $error)
        errorMessages.push('{{ $error }}');
        @endforeach
        const errorMessage = errorMessages.join('<br>');
        Swal.fire('Data gagal ditambah', errorMessage, 'error').then(() => {
            $('#add_username').val(localStorage.getItem('name'));
            $('#add_age').val(localStorage.getItem('age'));
            $('#add_phone').val(localStorage.getItem('phoneNumber'));
            modalAdd.modal('show');
        });

        @endif
        modalAdd.on('click', function(e) {
            if ($(e.target).hasClass('modal')) {
               modalAdd.modal('hide');
               $('#add_username').val(null);
               $('#add_age').val(null);
               $('#add_phone').val(null);
            }
        });
        batalButton.on('click', function() {
            modalAdd.modal('hide');
            $('#add_username').val(null);
            $('#add_age').val(null);
            $('#add_phone').val(null);
        });
        XButton.on('click', function() {
            modalAdd.modal('hide');
            $('#add_username').val(null);
            $('#add_age').val(null);
            $('#add_phone').val(null);
        });

        //table serverside
        let table = $('#datatables').DataTable({
            ajax: '{{ route('server.upah') }}',
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
                title: 'Nama',
                data: 'jukir.name'
            },
            {
                title: 'Bulan',
                data: 'bulan'
            },
            {
                title: 'Status upah',
                data: 'statusUpah'
            },
            {
                title: 'Uang upah',
                data: 'cashUpah'
            },
            {
                title: 'Status pajak',
                data: 'statusPajak'
            },
            {
                title: 'Uang pajak',
                data: 'cashPajak'
            },
            {
                title: 'Parkir|cash',
                data: 'totalCash'
            },
            {
                title: 'Parkir|qris',
                data: 'totalQris'
            },
            {
                title: 'Action',
                data: null,
                render: function(data, type, row){

                    return '<div class="d-flex flex-row">' +
                        '<button class="btn btn-primary btn-sm bayar-pajak" data-id="' + data.id + '" data-status="' + data.statusPajak + '">Bayar pajak</button>' +
                        '<button class="btn btn-danger btn-sm ml-2 bayar-upah" data-id="' + data.id + '" data-status="' + data.statusUpah + '">Bayar upah</button>' +
                        '</div>';
                    },
                    searhable: false,
                    orderable: false,

                },
                ],
                initComplete: function(){
                    //variable global
                    let data_gaji_bulanan = null;
                    let status = null;

                    // //fungsi tampil status bayar pajak
                    $(document).on('click', '.bayar-pajak', function() {
                        data_gaji_bulanan = $(this).data('id');
                        status = $(this).data('status');
                        console.log(data_gaji_bulanan);
                        console.log(status);
                        if(status == 'Belum memberi pajak'){
                            Swal.fire({
                                title: 'Apakah jukir ini sudah memberi pajak?',
                                text: "",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Iya, sudah memberi pajak'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    axios.put(`/dashboard-admin/data-gaji-bulanan/${data_gaji_bulanan}`, {
                                        statusPajak: 'Sudah memberi pajak'
                                    }).then(response => {
                                        Swal.fire(
                                        'Jukir sudah memberi pajak',
                                        '',
                                        'success'
                                        ).then(() => {
                                            window.location.reload();
                                        })
                                    }).catch(error => {
                                        swal.fire('Data gagal di update', '', 'error');
                                    })
                                }
                            })
                        }else{
                            Swal.fire({
                                title: 'Apakah jukir ini tidak jadi memberi pajak?',
                                text: "",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Iya, tidak jadi memberi pajak'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    axios.put(`/dashboard-admin/data-gaji-bulanan/${data_gaji_bulanan}`, {
                                        statusPajak: 'Belum memberi pajak'
                                    }).then(response => {
                                        Swal.fire(
                                        'Jukir tidak jadi memberi pajak',
                                        '',
                                        'success'
                                        ).then(() => {
                                            window.location.reload();
                                        })
                                    }).catch(error => {
                                        swal.fire('Data gagal di update', '', 'error');
                                    })
                                }
                            })
                        }
                    })

                    // //fungsi tampil status bayar upah
                    $(document).on('click', '.bayar-upah', function() {
                        data_gaji_bulanan = $(this).data('id');
                        status = $(this).data('status');
                        console.log(status);
                        if(status == 'Belum menerima upah'){
                            Swal.fire({
                                title: 'Apakah jukir ini sudah menerima upah?',
                                text: "",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Iya, sudah menerima upah'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    axios.put(`/dashboard-admin/data-gaji-bulanan/${data_gaji_bulanan}`, {
                                        statusUpah: 'Sudah menerima upah'
                                    }).then(response => {
                                        swal.fire('Jukir sudah menerima upah', '', 'success').then(() => {
                                            window.location.reload();
                                        })
                                    }).catch(error => {
                                        swal.fire('Data gagal di update', '', 'error');
                                    })
                                }
                            })
                        }else{
                            Swal.fire({
                                title: 'Apakah jukir ini tidak jadi menerima upah?',
                                text: "",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Iya, tidak jadi menerima upah'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    axios.put(`/dashboard-admin/data-gaji-bulanan/${data_gaji_bulanan}`, {
                                        statusUpah: 'Belum menerima upah'
                                    }).then(response => {
                                        swal.fire('Jukir tidak jadi menerima upah', '', 'success').then(() => {
                                            window.location.reload();
                                        })
                                    }).catch(error => {
                                        swal.fire('Data gagal di update', '', 'error');
                                    })
                                }
                            })
                        }
                    })

                }
            });
        })
    </script>
    @endpush
