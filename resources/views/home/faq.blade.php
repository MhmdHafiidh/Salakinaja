@extends('layout.home')

@section('title', 'FAQ')

@section('content')
    <!-- FAQ -->
    <section class="section-wrap faq">
        <div class="container">
            <div class="row">

                <div class="col-sm-9">
                    <h2 class="mb-20"><small>pertanyaan pengiriman</small></h2>

                    <div class="panel-group accordion mb-50" id="accordion-1">
                        <div class="panel">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-1"
                                    class="minus">bagaimana caranya
                                    melacak pengiriman saya?<span>&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapse-1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    Pelanggan dapat masuk ke akun mereka di situs web penjualan keripik salak. Pada bagian
                                    seperti "Pesanan Saya" di mana anda dapat melihat status pengiriman.
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-2" class="plus">
                                    dimanakah saya mendapakatkan nomor pengiriman?<span>&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapse-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Pada bagian profil akun, kita dapat melihat pada "Pesanan Saya" untuk dapat melihat
                                    proses pengiriman.
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-1" href="#collapse-3" class="plus">Apa
                                    metode pengiriman dapat saya gunakan?<span>&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapse-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Pada saat proses pembayaran, kita bisa memilih menggunakan metode pengiriman yang kita
                                    inginkan.
                                </div>
                            </div>
                        </div>
                    </div> <!-- end accordion -->


                    <h2 class="mb-20 mt-80"><small>Pertanyaan Pembayaran</small></h2>

                    <div class="panel-group accordion mb-50" id="accordion-2">
                        <div class="panel">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-4" class="minus">Apa
                                    metode pembayaran yang Anda terima?<span>&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapse-4" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    Pembayaran dapat dilakukan dengan beberapa cara. Seperti, pembayaran melalui Kredit
                                    Bank, Gopay, ShopeePay, Indomaret dan Alfamart.
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-5"
                                    class="plus">Bagaimana
                                    membayar melalui kartu kredit?<span>&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapse-5" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Pilih Metode Pembayaran, saat diminta untuk memilih metode pembayaran, pilih opsi kartu
                                    kredit. Kemudian pelanggan akan diarahkan ke halaman pembayaran yang aman (secure
                                    payment page) kemudian akan muncul kode pembayaran yang harus dibayarkan oleh pelanggan.
                                    Setelah verifikasi berhasil, sistem akan memproses pembayaran. Jika pembayaran berhasil,
                                    pelanggan akan menerima konfirmasi pembayaran melalui email. Setelah pembayaran
                                    dikonfirmasi, pesanan akan diproses oleh penjual. Pelanggan akan menerima notifikasi
                                    terkait status pesanan dan detail pengiriman.
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-6" class="plus">Apa
                                    kartu kredit yang Anda terima?<span>&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapse-6" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Kami menerima semua jenis pembayaran melalui berbagai kartu kredit bank.
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <a data-toggle="collapse" data-parent="#accordion-2" href="#collapse-7"
                                    class="plus">Bagaimana
                                    membayar melalui PayPal?<span>&nbsp;</span>
                                </a>
                            </div>
                            <div id="collapse-7" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Pilih Metode Pembayaran, saat memilih metode pembayaran, pelanggan memilih opsi
                                    "PayPal". Setelah memilih PayPal, pelanggan akan diarahkan ke halaman login PayPal yang
                                    aman. Pelanggan harus memasukkan email dan kata sandi PayPal mereka untuk login ke akun
                                    PayPal. Setelah login, pelanggan akan melihat detail transaksi, termasuk jumlah yang
                                    harus dibayar dan detail penerima pembayaran. Pelanggan perlu mengonfirmasi pembayaran.
                                    Setelah mengonfirmasi pembayaran, PayPal akan memproses transaksi dan mengirimkan
                                    notifikasi kepada pelanggan dan penjual mengenai status pembayaran. Setelah pembayaran
                                    dikonfirmasi, pesanan akan diproses oleh penjual. Pelanggan akan menerima notifikasi
                                    terkait status pesanan dan detail pengiriman.
                                </div>
                            </div>
                        </div>

                    </div> <!-- end accordion -->

                </div> <!-- end col -->

                <aside class="sidebar col-sm-3">
                    <div class="contact-item">
                        <h6>Categories</h6>
                        <ul class="list-dividers">
                            <li>
                                <a href="#">Kategori</a>
                            </li>
                            <li>
                                <a href="#">Pembayaran</a>
                            </li>
                            <li>
                                <a href="#">Pendukung</a>
                            </li>
                            <li>
                                <a href="#">Pertanyaan Umum</a>
                            </li>
                        </ul>
                    </div>

                    <div class="contact-item">
                        <h6>Informasi</h6>
                        <ul>
                            <li>
                                <i class="fa fa-envelope"></i><a
                                    href="mailto:theme@support.com">keripiksalakinaja@gmail.com</a>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i><span>+62 853 351 16 908</span>
                            </li>
                            <li>
                                <i class="fa fa-skype"></i><span>salakinaja</span>
                            </li>
                        </ul>
                    </div>

                </aside> <!-- end col -->

            </div>
        </div>
    </section> <!-- end faq -->

@endsection
