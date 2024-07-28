@extends('layout.home')

@section('title', 'Kontak')

@section('content')
    <!-- Contact -->
    <section class="section-wrap contact pb-40">
        <div class="container">
            <div class="row">

                <div class="col-md-8 mb-40">
                    <form id="contact-form" action="#">

                        <div class="contact-name">
                            <input name="name" id="name" type="text" placeholder="Nama*">
                        </div>
                        <div class="contact-email">
                            <input name="mail" id="mail" type="email" placeholder="E-mail*">
                        </div>
                        <div class="contact-subject">
                            <input name="subject" id="subject" type="text" placeholder="Subjek">
                        </div>

                        <textarea name="comment" id="comment" placeholder="Pesan" rows="9"></textarea>
                        <input type="submit" class="btn btn-lg btn-dark btn-submit" value="Kirim Pesan"
                            id="submit-message">
                        <div id="msg" class="message"></div>
                    </form>
                </div> <!-- end col -->

                <div class="col-md-3 col-md-offset-1 col-sm-5 mb-40">
                    <div class="contact-item">
                        <h6>Alamat Toko</h6>
                        <address>{{ $about->judul_website }}<br>
                            {{ $about->alamat }}</address>
                    </div> <!-- end address -->

                    <div class="contact-item">
                        <h6>Informasi</h6>
                        <ul>
                            <li>
                                <i class="fa fa-envelope"></i><a href="mailto:{{ $about->email }}">{{ $about->email }}</a>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i><span>{{ $about->telepon }}</span>
                            </li>
                        </ul>
                    </div> <!-- end information -->
                </div>

            </div>
        </div>
    </section> <!-- end contact -->

    <!-- Google Map -->
    <div id="google-map" class="gmap" data-address="V Tytana St, Manila, Philippines"></div>
@endsection
