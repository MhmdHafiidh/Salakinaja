<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="shortcut icon" href="/assets/logo2.png">
    <link rel="apple-touch-icon" href="/assets/logo2.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/logo2.png"">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/logo2.png">
    <title>Halaman Pendaftaran</title>
</head>

<body class="bg-gray-200">
    <div class="flex flex-col items-center justify-center min-h-screen py-10 px-5">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden w-full max-w-lg">
            <div class="flex justify-center py-4">
                <img src="/assets/logo2.png" width="80" height="80" alt="Logo">
            </div>
            <div class="px-8 py-6">
                <h2 class="text-2xl font-bold text-gray-700 text-center">Halaman Pendaftaran</h2>
                <p class="text-gray-600 text-center mb-4">Isi semua kolon untuk membuat akun!</p>

                @if (Session::has('errors'))
                    <ul class="text-red-600">
                        @foreach (Session::get('errors') as $error)
                            <li>{{ $error[0] }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="/register_customer" method="POST" class="mt-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="nama_customer">Nama Customer</label>
                        <input type="text" name="nama_customer" id="nama_customer" required
                            placeholder="Nama Customer"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="no_hp">No Hp</label>
                        <input type="text" name="no_hp" id="no_hp" required placeholder="No Hp"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="email">E-mail</label>
                        <input type="email" name="email" id="email" required placeholder="yourmail@example.com"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" required placeholder="Kata Sandi"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2" for="konfirmasi_password">Konfirmasi
                            Kata Sandi</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" required
                            placeholder="Konfirmasi Kata Sandi"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="w-full py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">Daftar</button>
                    </div>
                </form>
                <p class="mt-6 text-center">Sudah punya akun? <a href="/login_customer"
                        class="text-blue-400 hover:text-blue-600">Masuk disini.</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</body>

</html>
