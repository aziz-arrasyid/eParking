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
                                        <th scope="col">nomor plat</th>
                                        <th scope="col">Harga Parkir</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Motor</td>
                                        <td>bp 90 er</td>
                                        <td>Rp. 2000</td>
                                        <td>10 september 2023</td>
                                        <td>
                                            <div class="d-flex flex-row">
                                                <button class="btn btn-danger btn-sm ml-2">Bayar</button>
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
@endsection
