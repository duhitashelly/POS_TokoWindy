<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registrasi Akun</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* Fullscreen background image */
        body {
            background: url('path/to/your/background-image.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: 'Nunito', sans-serif;
        }

        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: rgba(0, 0, 0, 0.4); /* Transparent overlay */
        }

        .card {
            border-radius: 15px;
            background: #fff;
            width: 400px;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #0065A1; /* Ruangguru-like blue */
            border-color: #0065A1;
            border-radius: 25px;
            padding: 12px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #005488;
            border-color: #005488;
        }

        .form-control {
            border-radius: 25px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .small {
            font-size: 12px;
            color: #0065A1;
        }

        .small:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="card">
            <div class="card-header">
                <h1>Buat Akun!</h1>
            </div>
            <form action="{{ route('register') }}" method="POST" class="user">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" class="form-control form-control-user @error('name') is-invalid @enderror"
                        placeholder="Nama Lengkap" required autofocus>
                    @error('name')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                        placeholder="Alamat Email" required>
                    @error('email')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                            placeholder="Kata Sandi" required>
                        @error('password')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <input type="password" name="password_confirmation" class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                            placeholder="Ulangi Kata Sandi" required>
                        @error('password_confirmation')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Daftar Akun
                </button>
                <hr>
            </form>
            <div class="text-center">
                <a class="small" href="{{ route('login') }}">Sudah punya akun? Masuk!</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
