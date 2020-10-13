<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Ibad - Selamat Datang di Ma'had Ibadurrohman</title>

        <!-- ALL CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/owl.carousel.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/owl.theme.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/animate.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/slick.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/flaticon.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/settings.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/style.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/preset.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/ibad/css/responsive.css">

        <!--[if lt IE 9]>
              <script src="js/html5shiv.js"></script>
              <script src="js/respond.min.js"></script>
          <![endif]-->

        <!-- Favicon Icon -->
        <link rel="icon"  type="image/png" href="<?php echo VENDOR_URL; ?>/ibad/images/favicon.png">
        <!-- Favicon Icon -->
    </head>
    <body>

        <!--PRELOADER START-->
        <div class="preloader">
            <div class="loader">
                <img src="<?php echo VENDOR_URL; ?>/ibad/images/loader.gif" alt="">
            </div>
        </div>
        <!--PRELOADER END-->

        <!--HEADER START-->
        <header class="header isSticky" id="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-2 noPaddingLeft">
                        <div class="logo">
                            <a href="/"><img src="<?php echo VENDOR_URL; ?>/ibad/images/logo.png" alt=""></a>
                        </div>
                        <div class="logo logoText hidden">
                            <h1><a href="/">Ibadurrohman</a></h1>
                        </div>
                        <div class="stickyLogo">
                            <a href="/"><img src="<?php echo VENDOR_URL; ?>/ibad/images/flogo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <nav class="mainMenu">
                            <div class="mobileBar">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <ul>
                                <li class="scroll has-menu-items active"><a href="#slider">HOME</a></li>
                                <li class="scroll"><a href="#about">PROFILE</a></li>
                                <li class="scroll"><a href="#whatwe">KEUNGGULAN</a></li>
                                <li class="scroll"><a href="#ourwork">JENJANG</a>
                                    <ul class="sub-menu">
                                    <?php foreach($schools as $obj ){ ?>
                                        <li><a href="#" link="<?php echo site_url('school/'.$obj->id); ?>" onclick="change_school(this.getAttribute('link'));return false;"><?php echo $obj->school_name; ?></a></li>
                                    <?php } ?>
                                    </ul>
                                </li>
                                <li class="scroll has-menu-items"><a href="#blog">BERITA</a></li>
                                <li class="scroll"><a href="#contact">HUBUNGI KAMI</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-2 hidden-sm md_class noPaddingRight">
                        <div class="callus">
                            <p>call us <b>0265-320223</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--HEADER END-->

        <!--SLIDER START-->
        <section class="slider slider2" id="slider">
            <div class="tp-banner">
                <ul>
                    <li data-transition="fade" data-slotamount="7" data-masterspeed="1000">
                        <img src="<?php echo VENDOR_URL; ?>/ibad/images/slider/s21.jpg"  alt=""> 
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="-40"
                             data-speed="1600"
                             data-start="1000"
                             data-easing="easeInOutCubic">
                            <div class="revCon">
                                <h5 class="text-uppercase color_white">Selamat Datang di Ma'had</h5>
                            </div>
                        </div>
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="35"
                             data-speed="2000"
                             data-start="1500"
                             data-easing="Power4.easeOut">
                            <div class="revCon">
                                <h2 class="lead color_white">Ibadurrohman</h2>
                            </div>
                        </div>
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="148"
                             data-speed="2000"
                             data-start="2000"
                             data-easing="Power4.easeOut">
                            <div class="revCon revBtn home_page2">
                                <a href="#about" class="bes_button2"><span>Lihat Profil Kami <i class="flaticon-arrows"></i></span></a>
                            </div>
                        </div>
                    </li>
                    <li data-transition="cube" data-slotamount="7" data-masterspeed="1000">
                        <img src="<?php echo VENDOR_URL; ?>/ibad/images/slider/s22.jpg"  alt=""> 
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="-40"
                             data-speed="1600"
                             data-start="1000"
                             data-easing="easeInOutCubic">
                            <div class="revCon">
                                <h5 class="text-uppercase color_white">Selamat Datang Calon</h5>
                            </div>
                        </div>
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="35"
                             data-speed="2000"
                             data-start="1500"
                             data-easing="Power4.easeOut">
                            <div class="revCon">
                                <h2 class="lead color_white">Pemimpin Masa Depan</h2>
                            </div>
                        </div>
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="148"
                             data-speed="2000"
                             data-start="2000"
                             data-easing="Power4.easeOut">
                            <div class="revCon revBtn home_page2">
                                <a href="#" class="bes_button2"><span>Daftar PPDB Sekarang<i class="flaticon-arrows"></i></span></a>
                            </div>
                        </div>
                    </li>
                    <li data-transition="cube" data-slotamount="7" data-masterspeed="1000">
                        <img src="<?php echo VENDOR_URL; ?>/ibad/images/slider/s23.jpg"  alt=""> 
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="-40"
                             data-speed="1600"
                             data-start="1000"
                             data-easing="easeInOutCubic">
                            <div class="revCon">
                                <h5 class="text-uppercase color_white">Sekolah Terbaik Di</h5>
                            </div>
                        </div>
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="35"
                             data-speed="2000"
                             data-start="1500"
                             data-easing="Power4.easeOut">
                            <div class="revCon">
                                <h2 class="lead color_white">Kota Tasikmalaya</h2>
                            </div>
                        </div>
                        <div class="tp-caption sfb"
                             data-x="center"
                             data-y="center"
                             data-hoffset="0"
                             data-voffset="148"
                             data-speed="2000"
                             data-start="2000"
                             data-easing="Power4.easeOut">
                            <div class="revCon revBtn home_page2">
                                <a href="#contact" class="bes_button2"><span>Hubungi Kami <i class="flaticon-arrows"></i></span></a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="mouseSlider">
                <a href="#team" class="normal"><img src="<?php echo VENDOR_URL; ?>/ibad/images/mouse.png" alt=""></a>
                <a href="#team" class="hover"><img src="<?php echo VENDOR_URL; ?>/ibad/images/mouseh2.png" alt=""></a>
            </div>
        </section>
        <!--SLIDER END-->

        <!--ABOUT START-->
        <section class="about about2" id="about">
            <div class="perelaxBg1"></div>
            <div class="aboutTop home_page2">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="abcontentT">
                                <h5 class="text-uppercase greeny bold">Profil Ma'had</h5>
                                <h3 class="lead light">
                                    Ibadurrohman memiliki 10 prinsip pendidikan<br> Rendah Hati, Syukur, Tawakkal, Dermawan, Tauhid, Pembinaan, Bersih, Rapih, Kuat dan Cerdas.
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="abBigtitle home_page2">
                <h1 class="lead">Science.Technology.Qur'ani</h1>
            </div>
            <div class="aboutBottom home_page2">
                <div class="perelaxBg2"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-left">
                            <div class="abcontentB noPadding">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="lead bold">Memadukan 3 unsur pendidikan utama </h5>
                                    </div>
                                    <div class="col-lg-7">
                                        <h3 class="light">
                                        fokus kepada pengembangan science, teknologi dan pemahaman serta hafalan Al Qur'an
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ourServices">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="singleService">
                                <div class="serImg">
                                    <img src="<?php echo VENDOR_URL; ?>/ibad/images/services/1.png" alt="">
                                </div>
                                <h6 class="lead text-uppercase bold">SMP-SMA</h6>
                                <p>Jenjang Menengah Pertama dan Atas dengan sistem Boarding atau Pondok dilengkapi sistem Ketahfizhan terpadu.</p>
                                <a href="#" class="learn">Selengkapnya</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="singleService">
                                <div class="serImg">
                                    <img src="<?php echo VENDOR_URL; ?>/ibad/images/services/2.png" alt="">
                                </div>
                                <h6 class="lead text-uppercase bold">SD</h6>
                                <p>Jenjang Dasar memadukan science dengan pembinaan akhlak dan adab.</p>
                                <a href="#" class="learn">Selengkapnya</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="singleService">
                                <div class="serImg">
                                    <img src="<?php echo VENDOR_URL; ?>/ibad/images/services/3.png" alt="">
                                </div>
                                <h6 class="lead text-uppercase bold">TK/PAUD</h6>
                                <p>Jenjang Pre-Sekolah yang menyenangkan dan terarah. Mengajarkan kedisiplinan sejak dini.</p>
                                <a href="#" class="learn">Selengkapnya</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <a href="#" class="bes_button2">Selangkapnya Tentang Ma'had <i class="flaticon-arrows"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--ABOUT END-->

        <!--TEAM START-->
        <!--
        <section class="team" id="team">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sectionTitle epr200">
                            <h5 class="greeny text-uppercase bold">meet the team</h5>
                            <h3 class="lead">Powerful web services for your modern digital needs.</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="teamTop">
                        <div class="col-sm-6">
                            <div class="teamBig">
                                <img src="<?php echo VENDOR_URL; ?>/ibad/images/team/1b.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="testmonial" id="testmonial">
                                <div class="singleTestm">
                                    <p>
                                        We work with big brands and agencies through to small businesses and startups in Kent and beyond.
                                    </p>
                                    <div class="teamDeg">
                                        <h4 class="greeny">Richie Meldrum</h4>
                                        <p>Creative Director</p>
                                    </div>
                                </div>
                                <div class="singleTestm">
                                    <p>
                                        We work with big brands and agencies through to small businesses and startups in Kent and beyond.
                                    </p>
                                    <div class="teamDeg">
                                        <h4 class="greeny">Richie Meldrum</h4>
                                        <p>Creative Director</p>
                                    </div>
                                </div>
                                <div class="singleTestm">
                                    <p>
                                        We work with big brands and agencies through to small businesses and startups in Kent and beyond.
                                    </p>
                                    <div class="teamDeg">
                                        <h4 class="greeny">Richie Meldrum</h4>
                                        <p>Creative Director</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 sm_class">
                        <div class="singleTeam">
                            <img src="images/team/1.jpg" alt="">
                            <div class="teamDeg">
                                <h4>Pauline Russell</h4>
                                <p>Senior Account Director</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 sm_class">
                        <div class="singleTeam">
                            <img src="<?php echo VENDOR_URL; ?>/ibad/images/team/2.jpg" alt="">
                            <div class="teamDeg">
                                <h4>Joel Stevens</h4>
                                <p>Digital Producer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 sm_class">
                        <div class="singleTeam">
                            <img src="<?php echo VENDOR_URL; ?>/ibad/images/team/3.jpg" alt="">
                            <div class="teamDeg">
                                <h4>Marah Houlihan</h4>
                                <p>Senior Account Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 sm_class">
                        <div class="singleTeam">
                            <img src="<?php echo VENDOR_URL; ?>/ibad/images/team/4.jpg" alt="">
                            <div class="teamDeg">
                                <h4>David Dennis</h4>
                                <p>Head of Operations</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section-->
        <!--TEAM END-->

        <!--WHAT WE DO START-->
        <section class="whatwe home_page2" id="whatwe">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1 text-center">
                        <div class="wedoContent">
                            <h5 class="text-uppercase color_white bold">YANG KITA LAKUKAN</h5>
                            <h2 class="lead color_white">Mendidik, Membina <span>&</span> Mengembangkan.</h2>
                            <a href="<?php echo site_url('admission-online'); ?>" class="bes_button2">Daftarkan Anak Anda Sekarang Juga <i class="flaticon-arrows"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--WHAT WE DO END-->

        <!--OUR WORK START-->
        <!--
        <section class="ourwork" id="ourwork">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="sectionTitle bigTitle">
                            <h5 class="greeny text-uppercase bold">meet the team</h5>
                            <h2 class="lead">we create masterpieces.</h2>
                            <p>We believe in coming up with original ideas and turning them into digital work that is both innovative and measurable.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8 noPadding">
                        <div class="single_folio single_folio2">
                            <a href="work-detail.html">
                                <div class="polioThumb">
                                    <div class="overlayHover"></div>
                                    <img src="images/work/h2/1.jpg" alt="">
                                </div>
                            </a>
                            <div class="folio_hover2">
                                <h6 class="color_yellow text-uppercase bold">Recent Casestudy</h6>
                                <h3 class="lead color_white semi_Bold">Adventure Begins Here.</h3>
                                <div class="workTag">
                                    <a href="#" tabindex="0">Branding</a>/
                                    <a href="#" tabindex="0">Web Design</a>
                                </div>
                                <a class="work_btn" href="work-detail.html"><i class="flaticon-arrows"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 noPadding">
                        <div class="single_folio single_folio2">
                            <a href="work-detail.html">
                                <div class="polioThumb">
                                    <div class="overlayHover"></div>
                                    <img src="images/work/h2/2.jpg" alt="">
                                </div>
                            </a>
                            <div class="folio_hover2">
                                <h6 class="color_yellow text-uppercase bold">Recent Casestudy</h6>
                                <h3 class="lead color_white semi_Bold">Design The Future</h3>
                                <div class="workTag">
                                    <a href="#" tabindex="0">Branding</a>/
                                    <a href="#" tabindex="0">Web Design</a>
                                </div>
                                <a class="work_btn" href="work-detail.html"><i class="flaticon-arrows"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 noPadding">
                        <div class="single_folio single_folio2">
                            <a href="work-detail.html">
                                <div class="polioThumb">
                                    <div class="overlayHover"></div>
                                    <img src="images/work/h2/3.jpg" alt="">
                                </div>
                            </a>
                            <div class="folio_hover2">
                                <h6 class="color_yellow text-uppercase bold">Recent Casestudy</h6>
                                <h3 class="lead color_white semi_Bold">Design The Future</h3>
                                <div class="workTag">
                                    <a href="#" tabindex="0">Branding</a>/
                                    <a href="#" tabindex="0">Web Design</a>
                                </div>
                                <a class="work_btn" href="work-detail.html"><i class="flaticon-arrows"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 noPadding">
                        <div class="single_folio single_folio2">
                            <a href="work-detail.html">
                                <div class="polioThumb">
                                    <div class="overlayHover"></div>
                                    <img src="<?php echo VENDOR_URL; ?>/ibad/images/work/h2/4.jpg" alt="">
                                </div>
                            </a>
                            <div class="folio_hover2">
                                <h6 class="color_yellow text-uppercase bold">Recent Casestudy</h6>
                                <h3 class="lead color_white semi_Bold">Design The Future</h3>
                                <div class="workTag">
                                    <a href="#" tabindex="0">Branding</a>/
                                    <a href="#" tabindex="0">Web Design</a>
                                </div>
                                <a class="work_btn" href="work-detail.html"><i class="flaticon-arrows"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 noPadding">
                        <div class="single_folio single_folio2">
                            <a href="work-detail.html">
                                <div class="polioThumb">
                                    <div class="overlayHover"></div>
                                    <img src="<?php echo VENDOR_URL; ?>/ibad/images/work/h2/5.jpg" alt="">
                                </div>
                            </a>
                            <div class="folio_hover2">
                                <h6 class="color_yellow text-uppercase bold">Recent Casestudy</h6>
                                <h3 class="lead color_white semi_Bold">Design The Future</h3>
                                <div class="workTag">
                                    <a href="#" tabindex="0">Branding</a>/
                                    <a href="#" tabindex="0">Web Design</a>
                                </div>
                                <a class="work_btn" href="work-detail.html"><i class="flaticon-arrows"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section-->
        <!--OUR WORK END-->

        <!--CHOOSE US START-->
        <!--
        <section class="chooseus home_page2" id="chooseus">
            <div class="perelaxBg3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="sectionTitle bigTitle2">
                            <h5 class="greeny text-uppercase bold">why choose us?</h5>
                            <h2 class="lead">we dont just build websites, we build brands.</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="chooseUsContent">
                            <h3 class="greeny normal">Our team works shoulder-to- shoulder, ensuring a project is never created in isolation.</h3>
                            <p>Every project has its own unique goals and vision. Whatever your project demands, our extended network of strategists, creatives and technology specialists is always eager to pitch in. We know it helps to know good people.</p>
                            <div class="signatureandname">
                                <h4>Richie Meldrum</h4>
                                <img src="<?php echo VENDOR_URL; ?>/ibad/images/signature.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="imagesDiv chooseUsImg">
                            <img src="<?php echo VENDOR_URL; ?>/ibad/images/choose.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section-->
        <!--CHOOSE US END-->

        <!--TESTMONIAL START-->
        <section class="testmonialSec home_page2 overlayw10" id="testmonialSec">
            <div class="perelaxBg4"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="testmonialCaro" class="home_page2">
                            <div class="singleTestmn">
                                <p>Memadukan teknologi, science dan akhlak serta adab merupakan visi dan misi dari Ma'had Ibadurrohman. Menjadikan kualitas prioritas utama dalam target pendidikan kami.</p>
                                <div class="testAut">
                                    <h4>Agus Sugianto</h4>
                                    <p>Sekretaris IBAD</p>
                                </div>
                            </div>
                            <div class="singleTestmn">
                                <p>Dilengkapi Sistem e-IBAD mengatur seluruh aktivitas santri dari absensi, pencapaian tahfizh, raport, sertifikat, pembayaran, dan juga surat menyurat</p>
                                <div class="testAut">
                                    <h4>Angga</h4>
                                    <p>Finance IBAD</p>
                                </div>
                            </div>
                            <div class="singleTestmn">
                                <p>Ibadurrohman telah terakreditasi A dan diakui sebagai salah satu sekolah terbaik di Kota Tasikmalaya.</p>
                                <div class="testAut">
                                    <h4>Reni N.</h4>
                                    <p>Pengurus IBAD</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--TESTMONIAL END-->
        
        <!--CLIENT START-->
        <!--
        <section class="client home_page2" id="client">
            <div class="perelaxBg5"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="sectionTitle bigTitle3">
                            <h5 class="text-uppercase bold">who we worked for</h5>
                            <h2 class="lead">Our client experience</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/1.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/2.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/3.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/4.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/5.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/6.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/7.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/8.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/9.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/10.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/11.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/12.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/13.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/14.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/15.jpg" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="singleClient">
                            <a href="#"><img src="<?php echo VENDOR_URL; ?>/ibad/images/client/16.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </section-->
        <!--CLIENT END-->

        <!--BLOG START-->
        <section class="blogSection home_page2" id="blog">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="sectionTitle bigTitle2">
                            <h5 class="text-uppercase bold">BLOGS AND INSIGHTS</h5>
                            <h2 class="lead">ARTIKEL PROGRAM</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 noPadding">
                        <div class="singleBlog">
                            <div class="blogThumb">
                                <img src="<?php echo VENDOR_URL; ?>/ibad/images/blog/1.jpg" alt="">
                            </div>
                            <div class="blogDec">
                                <div class="blogDate">December, 20, 2019</div>
                                <h2 class="blogTitle"><a href="blog-detail.html">Infaq Pembangunan Masjid Ibadurrohman</a></h2>
                                <div class="bperaDiv">
                                    <p>Alhamdulillah, pembangunan masjid Ibadurrohman sudah sampai tahap finishing. Terimakasih atas dukungan dari para muhsinin selama ini. </p>
                                </div>
                                <div class="blogBott">
                                    <div class="bauthor">oleh<a href="#">Deri K</a></div>
                                    <div class="blogComs"><img src="<?php echo VENDOR_URL; ?>/ibad/images/comment.png" alt=""><a href="#">2 Comments</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 noPadding">
                        <div class="singleBlog">
                            <div class="blogThumb">
                                <img src="<?php echo VENDOR_URL; ?>/ibad/images/blog/2.jpg" alt="">
                            </div>
                            <div class="blogDec">
                                <div class="blogDate">December, 20, 2019</div>
                                <h2 class="blogTitle"><a href="blog-detail.html">Integratated Ibadurrohman 4</a></h2>
                                <div class="bperaDiv">
                                    <p>Event tahunan ini sukses mengundang bintang tamu spesial. Tim Nasyid Al fatih dan juga semintar parenting islami.</p>
                                </div>
                                <div class="blogBott">
                                    <div class="bauthor">oleh<a href="#">Deri K</a></div>
                                    <div class="blogComs"><img src="<?php echo VENDOR_URL; ?>/ibad/images/comment.png" alt=""><a href="#">2 Comments</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 noPadding">
                        <div class="singleBlog">
                            <div class="blogThumb">
                                <img src="<?php echo VENDOR_URL; ?>/ibad/images/blog/3.jpg" alt="">
                            </div>
                            <div class="blogDec">
                                <div class="blogDate">December, 20, 2019</div>
                                <h2 class="blogTitle"><a href="blog-detail.html">PPDB SMA IT 2020/2021</a></h2>
                                <div class="bperaDiv">
                                    <p>Ingin Hafal Qur'an sekaligus menguasai 3 bahasa? juga tersedia program khusus bahasa arab. Silahkan daftarkan anak Anda ke ma'had Ibadurrohman SMAIT</p>
                                </div>
                                <div class="blogBott">
                                    <div class="bauthor">oleh<a href="#">Deri K</a></div>
                                    <div class="blogComs"><img src="<?php echo VENDOR_URL; ?>/ibad/images/comment.png" alt=""><a href="#">2 Comments</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--BLOG END-->

        <!--SAY HELLO START-->
        <!--
        <section class="sayhello" id="sayhello">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="sectionTitle bigTitle2">
                            <h5 class="text-uppercase bold">we would love to hear from you</h5>
                            <h2 class="lead">say hello!</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="singleSay saypaddingR text-center">
                            <div class="sayThumb">
                                <img src="<?php echo VENDOR_URL; ?>/ibad/images/say/1.jpg" alt="">
                                <h3 class="text-uppercase">San fransisco</h3>
                            </div>
                            <div class="sayDec">
                                <h6 class="bold text-uppercase">san fransisco office</h6>
                                <p>70 Greenview Ave.</p>
                                <p>Temple Hills, MD 20748</p>
                                <h6 class="bold">1.800.987.6543</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="singleSay saypaddingl text-center">
                            <div class="sayThumb">
                                <img src="<?php echo VENDOR_URL; ?>/ibad/images/say/2.jpg" alt="">
                                <h3 class="text-uppercase">new york</h3>
                            </div>
                            <div class="sayDec">
                                <h6 class="bold text-uppercase">new york office</h6>
                                <p>70 Greenview Ave.</p>
                                <p>Temple Hills, MD 20748</p>
                                <h6 class="bold">1.800.987.6543</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section-->
        <!--SAY HELLO END-->

        <!--CONTACT START-->
        <section class="contact home_page2" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="contactInner">
                            <h3 class="greeny light">Kontak kami jika ingin mengajukan pertanyaan</h3>
                            <div class="contactForm">
                                <form action="#" method="post" id="contactForm">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="single_form home_page2">
                                                <label for="con_name">Nama:</label>
                                                <input type="text" name="con_name" id="con_name" class="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="single_form home_page2">
                                                <label for="con_phone">No HP/WA:</label>
                                                <input type="text" name="con_phone" id="con_phone" class="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="single_form home_page2">
                                                <label for="con_email">Email:</label>
                                                <input type="email" name="con_email" id="con_email" class="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="single_form home_page2">
                                                <label for="con_company">Asal:</label>
                                                <input type="text" name="con_company" id="con_company" class="required">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="single_form home_page2">
                                                <label for="con_msg">Pesan:</label>
                                                <textarea id="con_msg" name="con_msg" class="required"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-center">
                                            <input type="submit" value="KIRIM" id="con_submit" class="bes_button2">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--CONTACT END-->

        <!--FOOTER START-->
        <footer class="footer bggreay" id="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <aside class="widget">
                            <div class="textWidget">
                                <div class="flogow">
                                    <div class="flogo">
                                        <a href="index.html"><img src="<?php echo VENDOR_URL; ?>/ibad/images/flogo.png" alt=""></a>
                                    </div>
                                    <div class="logo logoText hidden">
                                        <h1><a href="index.html">Ibadurrohman</a></h1>
                                    </div>
                                </div>
                                <h3 class="widgetTitle">Tentang <b>ma'had</b></h3>
                                <p>Akta Notaris : Heri Hendriyana, SH, MH Nomor 226 SK. Menteri Hukum dan HAM Nomor : AHU-3176.AH.01.04.Tahun 2011 Jl. Lengkong Tengah RT. 03 RW. 02 Kelurahan Lengkongsari Kecamatan Tawang Kota Tasikmalaya 46111 Telp. 0265-320223</p>
                                <div class="socialIcon">
                                    <a class="fb" href="#"><i class="fa fa-facebook"></i></a>
                                    <a class="tw" href="#"><i class="fa fa-twitter"></i></a>
                                    <a class="gp" href="#"><i class="fa fa-google-plus"></i></a>
                                    <a class="dr" href="#"><i class="fa fa-dribbble"></i></a>
                                    <a class="be" href="#"><i class="fa fa-behance"></i></a>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="col-sm-6">
                        <aside class="widget">
                            <div class="newsletterwid">
                                <h3 class="widgetTitle">Daftar <b>Pemberitahuan</b></h3>
                                <div class="newsletter">
                                    <form action="#" method="post" id="subscriptForm">
                                        <input type="email" name="sub_email" id="sub_email" placeholder="Enter your email address.">
                                        <input type="submit" name="sub_submit" id="sub_submit" value="SUBSCRIBE">
                                    </form>
                                </div>
                                <div class="fooInfo">
                                    <p><i class="flaticon-pin"></i><b>Kantor Pusat:</b> Jalan Cisumur, Kota Tasikmalaya</p>
                                    <p><i class="flaticon-technology"></i><b>0265-320223</b></p>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </footer>
        <!--FOOTER END-->

        <!--COPY RIGHT START-->
        <section class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="copyPera">&COPY; 2020 Ibad. All Rights Reserved. Ibadurrohman.Sch.Id</p>
                    </div>
                </div>
            </div>
        </section>
        <!--COPY RIGHT END-->

        <div class="subscriptionSuccess">
            <div class="subsNotice">
                <i class="fa fa-thumbs-o-up closers"></i>
                <div class="clearfix"></div>
                <p class="closers">Subscription Request Successfully placed!</p>
            </div>
        </div>
        <div class="contactSuccess">
            <div class="consNotice">
                <i class="fa fa-thumbs-o-up closers"></i>
                <div class="clearfix"></div>
                <p class="closers">Your Message successfully sent!</p>
            </div>
        </div>


        <a id="backToTop" href="#"><i class="fa fa-angle-double-up"></i></a>

        <!-- ALL JS -->
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/owl.carousel.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/slick.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/jquery.themepunch.revolution.min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/jquery.parallax-1.1.3.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/jquery.localscroll-1.2.7-min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/jquery.scrollTo-1.4.2-min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/ibad/js/theme.js"></script>
    </body>
</html>


