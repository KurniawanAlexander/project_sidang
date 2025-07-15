<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/bg-loginnn.jpg');
            /* Ganti sesuai lokasi gambarmu */
            background-size: 1900px;
            /* Mengisi seluruh layar tanpa mengubah proporsi */
            background-position: center;
            /* Posisi tengah */
            background-repeat: no-repeat;
            /* Jangan diulang gambarnya */
            background-attachment: fixed;
            /* Supaya background tidak ikut scroll */

            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
        }



        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 2rem;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: #000;
            /* Warna hitam */
            text-align: center;
        }

        .btn-primary {
            width: 100%;
        }

        a {
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="card" style="background-color: rgba(30, 144, 255, 0.4); color: white;">
        <h2 class="card-title">LEXIFY</h2>
        <div class="card-body">

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <div class="mt-3 text-center">
                <p>Belum punya akun? <a href="#">Daftar di sini</a>.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
