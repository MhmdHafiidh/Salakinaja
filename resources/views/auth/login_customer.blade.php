<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
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
    <title>Login Page</title>
</head>

<body>
    <div class="flex py-10 md:py-20 px-5 md:px-32 min-h-screen justify-center items-center bg-gray-200">
        <div class="flex shadow-lg rounded-lg overflow-hidden w-full max-w-4xl">
            <div class="w-full lg:w-1/2 bg-white p-10 px-5 md:px-20">
                <div class="text-center mb-6">
                    <img src="/assets/logo2.png" alt="Logo" class="mx-auto mb-4" width="80" height="80">
                    <h1 class="font-bold text-2xl text-gray-700">Halaman Login</h1>
                    <p class="text-gray-600">Silahkan login disini!</p>
                </div>

                @if (Session::has('errors'))
                    <ul class="mb-4">
                        @foreach (Session::get('errors') as $error)
                            <li class="text-red-500">{{ $error[0] }}</li>
                        @endforeach
                    </ul>
                @endif

                @if (Session::has('success'))
                    <p class="text-green-500 mb-4">{{ Session::get('success') }}</p>
                @endif

                @if (Session::has('failed'))
                    <p class="text-red-500 mb-4">{{ Session::get('failed') }}</p>
                @endif

                <form action="/login_customer" method="POST" class="mt-10">
                    @csrf
                    <div class="my-3">
                        <label class="font-semibold" for="email">E-mail</label>
                        <input type="email" placeholder="emailkamu@contoh.com" name="email" id="email"
                            class="block border border-gray-300 rounded-full mt-2 py-2 px-5 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="password">Kata Sandi</label>
                        <input type="password" placeholder="kata sandi" name="password" id="password"
                            class="block border border-gray-300 rounded-full mt-2 py-2 px-5 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            required>
                    </div>
                    <div class="flex justify-between items-center mb-5">
                        <div>
                            <input type="checkbox" name="remember_me" id="remember_me" class="mr-1">
                            <label for="remember_me" class="text-gray-600">Ingat saya</label>
                        </div>
                    </div>
                    <div class="my-5">
                        <button type="submit"
                            class="w-full rounded-full bg-blue-400 hover:bg-blue-600 text-white py-2 transition duration-300">Masuk</button>
                    </div>
                </form>
                <div class="text-center">
                    <span>Belum punya akun? <a href="/register_customer" class="text-blue-400 hover:text-blue-600">Buat
                            disini.</a></span>
                </div>
            </div>
            <div class="w-full lg:w-1/2 bg-blue-400 flex justify-center items-center">
                <img src="/assets/login.jpg" alt="Login Image" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- Include the Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
