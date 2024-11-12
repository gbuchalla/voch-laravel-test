<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    </style>
</head>

<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6">
                <div class="card border-light shadow-lg rounded-lg">
                    <div class="card-header text-center bg-dark text-light">
                        <h3>Login</h3>
                        <p class="mb-0">Acesse sua conta para continuar</p>
                    </div>
                    <div class="card-body p-4 bg-dark text-light">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="john.doe@example.com" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="password">Senha</label>
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" value="password" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-warning btn-block">Entrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-dark text-light">
                        <p>Não tem uma conta? <a href="{{ route('register') }}" class="text-warning">Registrar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Bootstrap and jQuery CDN -->
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
 
</body>
</html>
