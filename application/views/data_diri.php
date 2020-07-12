<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Herbalife</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url()?>assets/assetshome/img/core-img/icon3.png">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/nice-select.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/flaticon.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/gijgo.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/slick.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/slicknav.css">
    <link rel="stylesheet" href="<?php echo base_url()?>aset/css/style.css">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-xl-5 col-lg-1" align="center">
                            <div class="logo">
                                <a href="index.html">
                                    <img src="<?php echo base_url()?>aset/img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-4">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="<?=site_url ()?>welcome">Beranda</a></li>
                                        <li><a href="#">Data <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="<?=site_url ()?>Data">Data Diri</a></li>
                                                <li><a href="<?=site_url ()?>Data/data_analisis">Data Hasil Analisa</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="<?=site_url ()?>welcome/#Tentang">Tentang</a></li>
                                        <li><a href="<?=site_url ()?>welcome/#Produk">Produk</a></li>
                                         <li><a href="<?=site_url ()?>welcome/#Kontak">Kontak</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
   <section class="sample-text-area">
        <div class="container box_1170">
        </div>
    </section>
    <!-- End Sample Area -->

    <!-- Start Button -->

    <!-- Start Align Area -->
    <div class="whole-wrap">
        <div class="container box_1170">
            <div class="section-top-border">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h3 class="mb-30" align="center">Data Diri</h3>
                        <form action="#">
                            <div class="mt-10">
                                <input type="text" name="first_name" placeholder="First Name"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required
                                    class="single-input">
                            </div>
                            <div class="mt-10">
                                <input type="text" name="last_name" placeholder="Last Name"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required
                                    class="single-input">
                            </div>
                            <div class="mt-10">
                                <input type="text" name="username" placeholder="Username"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" required
                                    class="single-input">
                            </div>
                            <div class="mt-10">
                                <input type="password" name="password" placeholder="password"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required
                                    class="single-input">
                            </div>
                            <div class="mt-10">
                                <input type="email" name="EMAIL" placeholder="Email address"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email address'" required
                                    class="single-input">
                            </div>
                            <div class="input-group-icon mt-10">
                                <div class="icon"><i class="fa fa-thumb-tack" aria-hidden="true"></i></div>
                                <input type="text" name="address" placeholder="Address" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Address'" required class="single-input">
                            </div>
                            <div class="mt-10">
                                <input type="date" name="ttl" placeholder="Tanggal_lahir"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Tanggal_lahir'" required
                                    class="single-input">
                            </div>
                            <!-- For Gradient Border Use -->
                            <!-- <div class="mt-10">
                                        <div class="primary-input">
                                            <input id="primary-input" type="text" name="first_name" placeholder="Primary color" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Primary color'">
                                            <label for="primary-input"></label>
                                        </div>
                                    </div> -->
                                    <div class="mt-10">
                                <input type="text" name="TELP" placeholder="telepon"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Telepon'" required
                                    class="single-input">
                                    <br>
                                    <br>
                                    <div class="col-xl-12">
                             <p align="center" class="genric-btn info radius" href="#">Simpan</a> </p>
                                    <p align="center" class="genric-btn warning radius" href="#">Edit</a> </p>
                            </p>
                        </div>
                                    

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
            <div class="copy-right_text">
                <div class="container">
                    <div class="footer_border"></div>
                    <div class="row">
                        <div class="col-xl-12">
                            <p class="copy_right text-center">
                              Herbalife | Skripsi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    <!-- JS here -->
    <script src="<?php echo base_url()?>aset/<?php echo base_url()?>aset/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/popper.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/isotope.pkgd.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/ajax-form.js"></script>
    <script src="<?php echo base_url()?>aset/js/waypoints.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/scrollIt.js"></script>
    <script src="<?php echo base_url()?>aset/js/jquery.scrollUp.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/wow.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/nice-select.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/jquery.slicknav.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/plugins.js"></script>
    <script src="<?php echo base_url()?>aset/js/gijgo.min.js"></script>

    <!--contact js-->
    <script src="<?php echo base_url()?>aset/js/contact.js"></script>
    <script src="<?php echo base_url()?>aset/js/jquery.ajaxchimp.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/jquery.form.js"></script>
    <script src="<?php echo base_url()?>aset/js/jquery.validate.min.js"></script>
    <script src="<?php echo base_url()?>aset/js/mail-script.js"></script>

    <script src="<?php echo base_url()?>aset/js/main.js"></script>
</body>

</html>