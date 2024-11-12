<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar</title>
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
                        <h3>Registrar</h3>
                        <p class="mb-0">Crie uma conta para começar</p>
                    </div>
                    <div class="card-body p-4 bg-dark text-light">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="password">Senha</label>
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="password_confirmation">Confirmar Senha</label>
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                            </div>
    
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-warning btn-block">Registrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center bg-dark text-light">
                        <p>Já tem uma conta? <a href="{{ route('login') }}" class="text-warning">Entrar</a></p>
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
