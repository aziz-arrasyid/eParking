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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Jenis Kendaraan</th>
                                        <th scope="col">Harga Parkir</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Motor</td>
                                        <td>Rp. 2000</td>
                                        <td>
                                            <div class="d-flex flex-row">
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" data-username="Brandon Jacob" data-age="28" data-phone="123-456-7890">Edit</button>
                                                <button class="btn btn-danger btn-sm ml-2" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
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
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Data -->
                <form>
                    <div class="form-group">
                        <label for="edit_kendaraan">Jenis Kendaraan</label>
                        <select class="form-control" id="edit_kendaraan">
                            <option value="motor">Motor</option>
                            <option value="mobil">Mobil</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_nomor_plat">Nomor Plat</label>
                        <input type="text" class="form-control" id="edit_nomor_plat">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEdit">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add User  -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Kendaraan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="add_kendaraan">Jenis Kendaraan</label>
                        <select class="form-control" id="add_kendaraan">
                            <option value="motor">Motor</option>
                            <option value="mobil">Mobil</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="add_nomor_plat">Nomor Plat</label>
                        <input type="text" class="form-control" id="add_nomor_plat">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveAdd">Buat</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{--  --}}
@endpush
