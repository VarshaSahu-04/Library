
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Focus - Bootstrap Admin Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Add your CSS file -->
    <!-- Include any additional CSS or meta tags here -->
        <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <!-- Custom Stylesheet -->
    

</head>

<body>
    
        @include('header')
    

    
        
            @include('sidebar')
        

      <!-- <main>
            @yield('content')
        </main>-->
 

        @include('footer')


    
        <script src="./js/global.min.js"></script>
    <script src="./js/quixnav-init.js"></script>
    <script src="./js/custom.min.js"></script>
    



    <!-- Jquery Validation -->
    <script src="./js/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="./js/plugins-init/jquery.validate-init.js"></script>

     <!-- Datatable -->
     <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/datatables.init.js"></script>
   

    </body>
    </html>