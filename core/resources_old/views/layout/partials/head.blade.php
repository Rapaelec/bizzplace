<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title> {{$gs->website_title}} | @yield('title') </title>
<!-- favicon -->
<link rel="shortcut icon" href="{{asset('assets/user/interfaceControl/logoIcon/icon.jpg')}}" type="image/x-icon">
<!-- bootstrap -->
<link rel="stylesheet" href="{{asset('assets/user/css/bootstrap.min.css')}}">
<!-- icofont -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="{{asset('assets/user/css/fontawesome.min.css')}}">
<!-- DataTable CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>
<!-- animate.css -->
<link rel="stylesheet" href="{{asset('assets/user/css/animate.css')}}">
<!-- Owl Carousel -->
<link rel="stylesheet" href="{{asset('assets/user/css/owl.carousel.min.css')}}">
<!-- tabbed js-->
<link rel="stylesheet" href="{{asset('assets/plugins/tabs/css/responsive-tabs.css')}}">

<!-- magnific popup -->
<link rel="stylesheet" href="{{asset('assets/user/css/magnific-popup.css')}}">
<!-- jQUery UI -->
<link rel="stylesheet" href="{{asset('assets/user/css/jquery-ui.css')}}">
<!-- select 2  -->
<link rel="stylesheet" href="{{asset('assets/user/css/select2.min.css')}}">
<!-- Toastr  -->
<link rel="stylesheet" href="{{asset('assets/user/css/toastr.min.css')}}">
{{-- File input CSS --}}
<link href="{{ asset('assets/plugins/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
<!-- stylesheet -->
<link rel="stylesheet" href="{{asset('assets/user/css/style.css')}}">
<!-- responsive -->
<link rel="stylesheet" href="{{asset('assets/user/css/responsive.css')}}">

<link rel="stylesheet" href="{{asset('assets/plugins/tabs/css/ion.tabs.css')}}">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
{{-- Base Color Change... --}}
<link href="{{url('/')}}/assets/user/css/themes/base-color.php?color={{$gs->base_color_code}}" rel="stylesheet">
<!-- jquery -->
<script src="{{asset('assets/user/js/jquery.js')}}"></script>
<script src="{{asset('assets/plugins/loading/jquery.loadButton.min.js')}}"></script>

<!-- tabs js-->
<script src="{{asset('assets/plugins/tabs/js/ion.tabs.min.js')}}"></script>

<style type="text/css">
    .txt{
        color:white;
    }
    .txt:hover{
        color:chocolate;
    }
</style>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
@stack('styles')
{{-- NICedit CDN --}}
@stack('nicedit-scripts')
