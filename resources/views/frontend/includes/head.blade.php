   <meta charset="utf-8" />
    <title>{{$page_content['page_title'] ?? 'Dashboard'}} Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Abaash" name="description" />
    <meta content="Abaash" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('tamplate/assets/images/Fav-Icon.png')}}">

    <!-- jquery.vectormap css -->
    <link href="{{asset('tamplate/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet"
        type="text/css" />

    <!-- DataTables -->
    <link href="{{asset('tamplate/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('tamplate/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"
        type="text/css" />

    <link href="{{asset('tamplate/assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('tamplate/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('tamplate/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet')}}" type="text/css">
    <link href="{{asset('tamplate/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">

    <!-- Bootstrap Css -->
    <!-- <link href="{{asset('tamplate/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" /> -->

    <!-- Icons Css -->
    <link href="{{asset('tamplate/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('tamplate/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    {{-- @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
   <link href="{{asset('css/custom_style.css')}}" type="text/css" rel="stylesheet">
   @stack('css')



