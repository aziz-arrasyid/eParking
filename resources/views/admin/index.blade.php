@extends('layouts.master')

@section('content')
<main id="main" class="main">
    <div class="container">
        <h1 class="mt-3">Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">REGISTER JUKIR</h5>
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <button class="btn btn-success m-3" data-toggle="modal" data-target="#addModal">Add Jukir</button>
                                </div>
                            </div>
                            <!-- Default Table -->
                            <div class="table-responsive">
                                <table class="table" id="datatables">
                                    {{-- <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>wahyu andika kurniawan</td>
                                            <td>17</td>
                                            <td>08994879433</td>
                                            <td>
                                                <div class="d-flex flex-row">
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" data-username="Brandon Jacob" data-age="28" data-phone="123-456-7890">Edit</button>
                                                    <button class="btn btn-danger btn-sm ml-2" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Data lainnya ... -->
                                    </tbody> --}}
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
                    <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                    <button type="button" id="closeXEdit" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Edit Data -->
                    <form id="form-edit" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="editName">nama</label>
                            <input type="text" name="name" class="form-control" id="editName">
                        </div>
                        <div class="form-group">
                            <label for="editUsername">Username</label>
                            <input type="text" name="username" class="form-control" id="editUsername">
                        </div>
                        <div class="form-group">
                            <label for="editAge">Age</label>
                            <input type="text" name="age" class="form-control" id="editAge">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone Number</label>
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
                    <h5 class="modal-title" id="addModalLabel">Add Jukir</h5>
                    <button type="button" id="closeXAdd" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Add User -->
                    <form action="{{ route('data-jukir.store') }}" method="POST" id="form-add" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="addUsername">name</label>
                            <input type="text" name="name" class="form-control" id="addUsername">
                        </div>
                        <div class="form-group">
                            <label for="addAge">Age</label>
                            <input type="number" name="age" class="form-control" id="addAge">
                        </div>
                        <div class="form-group">
                            <label for="addPhone">Phone Number</label>
                            <input type="number" name="phoneNumber" class="form-control" id="addPhone">
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
</main>
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
            localStorage.setItem('name', $('#addUsername').val());
            localStorage.setItem('age', $('#addAge').val());
            localStorage.setItem('phoneNumber', $('#addPhone').val());
        })

        @if($errors->any())
        modalAdd.modal('hide');
        const errorMessages = [];
        @foreach($errors->all() as $error)
        errorMessages.push('{{ $error }}');
        @endforeach
        const errorMessage = errorMessages.join('<br>');
        Swal.fire('Data gagal di edit', errorMessage, 'error').then(() => {
            $('#addUsername').val(localStorage.getItem('name'));
            $('#addAge').val(localStorage.getItem('age'));
            $('#addPhone').val(localStorage.getItem('phoneNumber'));
            modalAdd.modal('show');
        });

        batalButton.on('click', function() {
            modalAdd.modal('hide');
        });
        XButton.on('click', function() {
            modalAdd.modal('hide');
        });
        @endif

        //table serverside
        let table = $('#datatables').DataTable({
            ajax: '{{ route('server.side') }}',
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
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
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
