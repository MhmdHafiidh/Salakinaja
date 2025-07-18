@extends('layout.app')

@section('title')

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">
                Laporan Pesanan
            </h4>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <form>
                        <div class="form-group">
                            <label for="">Dari</label>
                            <input type="date" name="dari" id="dari" class="form-control"
                                value="{{ request()->input('dari') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Sampai</label>
                            <input type="date" name="sampai" id="sampai" class="form-control"
                                value="{{ request()->input('sampai') }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            @if (request()->input('dari'))
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah Dibeli</th>
                                <th>Total Qty</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection


@push('js')
    <script>
        $(function() {
            const dari = '{{ request()->input('dari') }}';
            const sampai = '{{ request()->input('sampai') }}';

            function rupiah(angka) {
                const format = angka.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                return 'Rp ' + convert.join('.').split('').reverse().join('');
            }

            const token = localStorage.getItem('token');

            $.ajax({
                url: `/api/reports?dari=${dari}&sampai=${sampai}`,
                headers: {
                    "Authorization": 'Bearer ' + token
                },
                success: function(response) {
                    if (response.data.length > 0) {
                        let rows = '';
                        response.data.forEach(function(item, index) {
                            rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.nama_produk}</td>
                                <td>${rupiah(item.harga)}</td>
                                <td>${item.jumlah_dibeli}</td>
                                <td>${item.total_qty}</td>
                                <td>${rupiah(item.pendapatan)}</td>
                            </tr>
                        `;
                        });
                        $('tbody').html(
                            rows
                            ); // Menggunakan html() untuk mengganti konten tbody dengan baris yang dihasilkan
                    } else {
                        $('tbody').html(
                            '<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                    $('tbody').html(
                        '<tr><td colspan="6" class="text-center">Terjadi kesalahan saat mengambil data</td></tr>'
                    );
                }
            });
        });
    </script>
@endpush
