<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Ibad - Selamat Datang di Ma'had Ibadurrohman</title>

        <!-- ALL CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/owl.carousel.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/owl.theme.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/animate.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/slick.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/flaticon.css">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/settings.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/style.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/preset.css" >
        <link rel="stylesheet" type="text/css" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/responsive.css">
        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>select2/dist/css/select2.min.css">
        <!--[if lt IE 9]>
              <script src="js/html5shiv.js"></script>
              <script src="js/respond.min.js"></script>
          <![endif]-->

        <!-- Favicon Icon -->
        <link rel="icon"  type="image/png" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/favicon.png">
        <!-- Favicon Icon -->
    </head>
    <body>

        <!--PRELOADER START-->
        <div class="preloader">
            <div class="loader">
                <img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/loader.gif" alt="">
            </div>
        </div>
        <!--PRELOADER END-->
        <div id="preloader"></div>
        
        <?php $this->load->view('ibad/layout/header'); ?>  
        
        <!-- page content -->        
        <?php echo $content_for_layout; ?>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php $this->load->view($theme.'/layout/footer'); ?>   
        <!-- /footer content -->

        <!-- ALL JS -->
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/owl.carousel.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/slick.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.themepunch.revolution.min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.parallax-1.1.3.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.localscroll-1.2.7-min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>select2/dist/js/select2.min.js"></script> 
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.scrollTo-1.4.2-min.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/theme.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/addr.js"></script>
        <script type="text/javascript">
    <?php if($post && !empty ($post)){ ?>  
        get_section_by_class('<?php echo $post['class_id']; ?>', '<?php echo $post['section_id']; ?>');
        get_cities_by_prov('<?php echo $post['province_id']; ?>', '<?php echo $post['regency_id']; ?>');
        get_district_by_city('<?php echo $post['regency_id']; ?>', '<?php echo $post['district_id']; ?>');
        get_villages_by_district('<?php echo $post['district_id']; ?>', '<?php echo $post['villages_id']; ?>');
    <?php } ?>    
        </script>
    </body>
</html>