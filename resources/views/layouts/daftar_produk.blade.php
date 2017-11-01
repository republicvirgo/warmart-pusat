<!doctype html>
<html lang="en">
<head>
    <title>War-Mart.id</title>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png" />
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/material-dashboard.css?v=1.2.0') }}" rel="stylesheet" />

    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!--     Fonts and icons     -->
    <link href="{{ asset('css/material-kit.css?v=1.2.0')}}" rel="stylesheet"/>
    <link href="{{ asset('assets/assets-for-demo/vertical-nav.css')}}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    <!-- MINIFIED -->
    {!! SEO::generate(true) !!}
    

    <!-- LUMEN -->
    {!! app('seotools')->generate() !!}

</head>

<body class="ecommerce-page">
    <nav class="navbar navbar-default navbar-transparent navbar-fixed-top navbar-color-on-scroll" color-on-scroll="100" id="sectionsNav">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="https://war-mart.id"> WAR-MART.ID </a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">person</i> {{ Auth::user()->name }}
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-with-icons">
                            <li>
                                <a href="{{ url('/ubah-profil') }}">
                                    <i class="fa fa-edit"></i> Ubah Profil
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/ubah-password') }}">
                                    <i class="fa fa-expeditedssl"></i> Ubah Password
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                                    <i class="fa  fa-sign-out"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>                            
                        </ul>
                    </li>

                    <li class="button-container">
                        <a href="{{ url('/keranjang-belanja') }}" target="_blank" class="btn btn-rose btn-round">
                            <i class="material-icons">shopping_cart</i> Keranjang Belanja
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-header header-filter header-small" data-parallax="true"" style="{!! $foto_latar_belakang !!}">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="brand">
                        <h1 class="title">PASAR MUSLIM INDONESIA</h1>
                        <h4 class="title"> Segala Kemudahan Untuk Umat Muslim Berbelanja.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main main-raised">

        <div class="section" style="background-color: #E5E5E5">
            <div class="container">

                <h3 class="title text-center">{!! $nama_kategori !!}</h3>

                <div class="card card-raised card-form-horizontal">
                    <div class="card-content">
                        <form method="" action="">
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">search</i>
                                        </span>
                                        <input type="email" id="cari_produk" value="" placeholder="Cari Produk.." class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-block" style="background-color: #f44336">Cari Produk</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3"> 
                        <ul class="nav nav-tabs" data-tabs="tabs" style="background-color: #f44336">                                        
                            <li><a href="{{route('daftar_produk.index')}}"><i class="material-icons">format_align_justify</i> Semua Kategori</a></li>
                        </ul>
                    </div>
                    <div class="col-md-9">                        
                        <ul class="nav nav-tabs" data-tabs="tabs" style="background-color: #f44336">
                            {!! $kategori_produk !!}
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <!-- Menampilkan Produk -->
                            <span id="span-produk">{!! $daftar_produk !!}</span>
                            <div class="col-md-12">
                                {{$produk_pagination}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- section -->

    </div> <!-- end-main-raised -->

    <div class="section section-blog">
    </div><!-- section -->

    <footer class="footer footer-black footer-big">
        <div class="container">

            <div class="content">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Tentang Kami</h5>
                        <p>Creative Tim is a startup that creates design tools that make the web development process faster and easier. </p> <p>We love the web and care deeply for how users interact with a digital product. We power businesses and individuals to create better looking web projects around the world. </p>
                    </div>

                    <div class="col-md-4">
                        <h5>Media Sosial</h5>
                        <div class="social-feed">
                            <div class="feed-line">
                                <i class="fa fa-twitter"></i>
                                <p>How to handle ethical disagreements with your clients.</p>
                            </div>
                            <div class="feed-line">
                                <i class="fa fa-twitter"></i>
                                <p>The tangible benefits of designing at 1x pixel density.</p>
                            </div>
                            <div class="feed-line">
                                <i class="fa fa-facebook-square"></i>
                                <p>A collection of 25 stunning sites that you can use for inspiration.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <h5>Instagram</h5>
                        <div class="gallery-feed">
                        </div>

                    </div>
                </div>
            </div>


            <hr />

            <ul class="pull-left">
                <li>
                    <a href="#pablo">
                     Blog
                 </a>
             </li>
             <li>
                <a href="#pablo">
                    Presentation
                </a>
            </li>
            <li>
                <a href="#pablo">
                 Discover
             </a>
         </li>
         <li>
            <a href="#pablo">
                Payment
            </a>
        </li>
        <li>
            <a href="#pablo">
                Contact Us
            </a>
        </li>
    </ul>

    <div class="copyright pull-right">
        Copyright &copy; <script>document.write(new Date().getFullYear())</script> <a href="https://andaglos.id/"> PT. Andaglos Global Teknologi.</a>
    </div>
</div>
</footer>
</body>

<!--   Core JS Files   -->
<script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
<!-- Library for adding dinamically elements -->
<script src="{{ asset('js/arrive.min.js') }}" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<!-- Promise Library for SweetAlert2 working on IE -->
<script src="{{ asset('js/es6-promise-auto.min.js') }}"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="{{ asset('js/moment.min.js') }}"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<script src="{{ asset('js/chartist.min.js') }}"></script>
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{ asset('js/jquery.bootstrap-wizard.js') }}"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="{{ asset('js/bootstrap-notify.js') }}"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>
<!--    Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select   -->
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{ asset('js/jquery-jvectormap.js') }}"></script>
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<script src="{{ asset('js/nouislider.min.js') }}"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{ asset('js/jquery.select-bootstrap.js') }}"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="{{ asset('js/sweetalert2.js') }}"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{ asset('js/jasny-bootstrap.min.js') }}"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{{ asset('js/jquery.tagsinput.js') }}"></script>

<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/demo.js') }}"></script>
<script src="{{ asset('js/material-kit.js?v=1.2.0')}}" type="text/javascript"></script>

<script>
    $(document).on('click','.btn-wishlist',function(){
        var data_toggle = $(this).attr('data-toogle');
        var id = $(this).attr('data-id');

        if (data_toggle == 0) {
            $(this).attr("data-toogle", 1);
            $(this).attr("data-original-title", "Hapus Dari Wishlist");
            $("#icon_wishlist-"+id+"").text("favorite");
        }
        else{
            $(this).attr("data-toogle", 0);
            $(this).attr("data-original-title", "Tambah Ke Wishlist");                
            $("#icon_wishlist-"+id+"").text("favorite_border");
        }            
    }); 
    $("#form_filter_kategori").submit(function(){
        return false;
    });
</script>

<script type="text/javascript">
   $(document).ready(function(){
    $("#cari_produk").focus();
});
</script>


</html>