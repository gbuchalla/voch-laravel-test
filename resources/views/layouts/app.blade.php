<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>

<body class="bg-light">

    @include('partials.navbar')

    <div class="d-flex" id="wrapper">

        <!-- /#sidebar-wrapper -->
        <div id=sidebar-wrapper>
            @include('partials.sidebar')
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            <div class="container-fluid mt-3">
                @yield('content')
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Custom JS for toggling the sidebar -->
    <script>
        $(document).ready(function() {
            $('#menu-toggle').click(function(e) {
                e.preventDefault();
                $('#wrapper').toggleClass('toggled');
            });
        });
    </script>


    <style>

        .container {
            max-width: 1200px; 
            margin: 0 auto;    
            padding: 20px;     
        }


        .table {
            width: 100%; 
            table-layout: fixed; 
            margin-bottom: 20px;
        }


        .table th, .table td {
            text-align: center;
            padding: 10px; 
            vertical-align: middle;
        }


        .pagination {
            justify-content: center; /
        }

        .page-link {
            color: #495057;
            border: 1px solid #dee2e6;
            padding: 5px 10px; 
        }

        .page-item.active .page-link {
            background-color: #FF7E5F;
            border-color: #FF7E5F;
            color: white;
        }

        /* Ajusta o tamanho e o espaçamento nos modais */
        .modal-dialog {
            max-width: 800px; 
            margin: 30px auto; 
        }

        .modal-content {
            padding: 20px; 
        }

        /* Ajustando o layout do sidebar */
        #sidebar-wrapper {
            width: 250px;
            position: fixed;
            top: 56px; 
            left: 0;
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            padding-left: 20px;
            padding-right: 20px;
        }

        /* Certificando que o conteúdo não ultrapasse a tela */
        #page-content-wrapper {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px); 
        }

        body {
            background-color: #f8f9fa; 
            font-family: 'Roboto', sans-serif;
        }

        /* Melhora o estilo do botão de logout */
        .logout-btn {
            font-size: 1rem;
            letter-spacing: 1px;
            padding: 8px 15px;
            background: none;
            border: none;
            text-transform: uppercase;
            color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #FF7E5F;
            color: white;
        }


        /* A sidebar, quando a classe "toggled" é adicionada, deve se mover para fora da tela */
        #sidebar-wrapper {
            transition: width 0.5s ease;
            width: 250px; 
        }

        #wrapper.toggled #sidebar-wrapper {
            transform: translateX(-250px);
        }

        #page-content-wrapper {
            transition: width 0.5s ease;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 0; 
            width: 100%; 
        }
    
    </style>

</body>

</html>
