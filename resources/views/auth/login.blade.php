<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="shortcut icon" href="/assets/logo2.png">
    <link rel="apple-touch-icon" href="/assets/logo2.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/logo2.png"">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/logo2.png">


    <style>
        body {
            background: gray 200;
            font-family: 'Nunito', sans-serif;
        }

        .card {
            border: none;
            border-radius: 1rem;
        }

        .card .card-body {
            padding: 2rem;
        }

        .btn-primary {
            background-color: #4b6cb7;
            border: none;
        }

        .btn-primary:hover {
            background-color: #182848;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .form-group .text-danger {
            margin-top: 0.25rem;
            font-size: 0.875rem;
        }

        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: #4b6cb7;
        }

        .custom-checkbox .custom-control-input:focus~.custom-control-label::before {
            box-shadow: none;
        }

        .alert {
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center min-vh-100 bg-gray-200">
        <div class="row w-100 justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <img src="/assets/logo2.png" alt="Logo" class="mx-auto mb-4" width="80"
                                            height="80">
                                        <h1 class="h4 text-gray-900">Selamat Datang</h1>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <strong>Gagal</strong>
                                            <p>{{ $errors->first() }}</p>
                                        </div>
                                    @endif
                                    <form class="form-login user" method="POST" action="/login">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <input type="email" class="form-control form-control-user email"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan Alamat Email" name="email">
                                            @error('email')
                                                <small class="text-danger">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" class="form-control form-control-user password"
                                                id="exampleInputPassword" placeholder="Kata Sandi" name="password">
                                            @error('password')
                                                <small class="text-danger">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Masuk
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <class="small">Salakinaja</class>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function() {
            $('.form-login').submit(function(e) {
                e.preventDefault();

                const email = $('.email').val();
                const password = $('.password').val();
                const csrf_token = $('meta[name="csrf-token"]').attr('content')

                $.ajax({
                    url: '/login',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        _token: csrf_token
                    },
                    success: function(data) {
                        if (!data.success) {
                            alert(data.message)
                        }

                        localStorage.setItem('token', data.token)
                        window.location.href = '/dashboard';
                    }
                });
            });
        });
    </script>
</body>

</html>
