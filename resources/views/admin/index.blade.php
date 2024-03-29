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
                            <div class="col-auto">
                                <button class="btn btn-success m-3" data-toggle="modal" data-target="#addModal">Tambah Jukir</button>
                            </div>
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
<div class="modal fade" id="edit-modal-jukir" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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

        @if(Session('success'))
        toastr.success('{{ session('success') }}');
        @endif

        const modalAdd = $('#addModal');
        const batalButton = modalAdd.find('#closeAdd');
        const XButton = modalAdd.find('#closeXAdd');


        document.getElementById('form-add').addEventListener('submit', function(event) {
            localStorage.setItem('name', $('#add_username').val());
            localStorage.setItem('age', $('#add_age').val());
            localStorage.setItem('phoneNumber', $('#add_phone').val());
        })

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
            ajax: '{{ route('server.jukir') }}',
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
                data: 'name'
            },
            {
                title: 'Username',
                data: 'user.username'
            },
            {
                title: 'Umur',
                data: 'age'
            },
            {
                title: 'Nomor HP',
                data: 'phoneNumber'
            },
            {
                title: 'Action',
                data: null,
                render: function(data, type, row){

                    return '<div class="d-flex flex-row">' +
                        '<button class="btn btn-primary btn-sm edit-modal" data-id="' + data.id + '" data-toggle="modal">Edit</button>' +
                        '<button class="btn btn-danger btn-sm ml-2 delete-modal" data-toggle="modal" data-id="' + data.id + '" data-target="#deleteModal">Delete</button>' +
                        '</div>';
                    },
                    searhable: false,
                    orderable: false,

                },
                ],
                initComplete: function(){
                    //variable global
                    const modalEdit = $('#edit-modal-jukir');
                    let data_jukir = null;

                    //fungsi tampil data edit
                    $(document).on('click', '.edit-modal', function() {
                        // const modalEdit = $('#editModal');
                        modalEdit.modal('show');
                        const batalButtonEdit = modalEdit.find('#closeEdit');
                        const XButtonEdit = modalEdit.find('#closeXEdit');
                        data_jukir = $(this).data('id');

                        axios.get(`/dashboard-admin/data-jukir/${data_jukir}/edit`).then(response => {
                            $('#editName').val(response.data.name);
                            $('#editUsername').val(response.data.user.username);
                            $('#editAge').val(response.data.age);
                            $('#editPhone').val(response.data.phoneNumber);
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

                        let name = $('#editName').val();
                        let age = $('#editAge').val();
                        let phoneNumber = $('#editPhone').val();
                        let username = $('#editUsername').val();
                        axios.put(`/dashboard-admin/data-jukir/${data_jukir}`, {
                            name: name,
                            age: age,
                            phoneNumber: phoneNumber,
                            username: username,
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
                        let data_jukir = $(this).data('id');
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
                                axios.delete(`/dashboard-admin/data-jukir/${data_jukir}`).then(response => {
                                    swal.fire('Data berhasil dihapus', '', 'success').then(() => {
                                        window.location.reload();
                                    })
                                }).catch(error => {
                                    swal.fire('Data gagal di hapus', '', 'error');
                                })
                            }
                        })
                    })

                }
            });
        })
    </script>
    @endpush
