
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?php echo $title_for_layout; ?></title>   
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PISTOL (Program Setoran Online), Karantina 3 Hari 2 Malam, Workshop Seminar 120 Menit" />
        <meta name="keywords" content="tahfidz, tahfizh, setoran online, karantina, pistol, workshop, quran" />
        <meta content="Themesdesign" name="author" />
        <!-- favicon -->
        <?php if($this->global_setting->favicon_icon){ ?>
            <link rel="icon" href="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->favicon_icon; ?>" type="image/x-icon" />             
        <?php }else{ ?>
            <link rel="shortcut icon" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/favicon.ico">
        <?php } ?>

        <!-- Bootstrap -->
        <link href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Magnific -->
        <link href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/magnific-popup.css" rel="stylesheet" type="text/css" />
        <!-- Icon -->
        <link href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" />          
        <!-- SLICK SLIDER -->
        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/owl.carousel.min.css"/> 
        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/owl.theme.css"/> 
        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/owl.transitions.css"/>   
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/swiper.min.css">
        <!-- Animation -->
        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/aos.css">
        <!-- Custom Css -->
        <link href="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>select2/dist/css/select2.min.css">

    </head>

    <body>
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="sk-circle">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>
            </div>
        </div>
        <!-- Loader -->

        <?php $this->load->view('layout/header'); ?>  
        
        <!-- page content -->        
        <?php echo $content_for_layout; ?>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php $this->load->view('layout/footer'); ?>   
        <!-- /footer content -->


        <!-- javascript -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.min.js"></script>
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.easing.min.js"></script>
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/scrollspy.min.js"></script>
        <!-- SLIDER -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/owl.carousel.min.js "></script>
        <!-- Magnific Popup -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.magnific-popup.min.js"></script>
        <!-- Contact -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/contact.js"></script>
        <!-- Counter -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/counter.init.js"></script>
        <!-- Swiper JS -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/swiper.min.js"></script>
        <!-- Animation JS -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/aos.js"></script>
        <!-- Animation JS -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/jquery.nicescroll.js"></script>
        <!-- Plugin init -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/plugin.init.js"></script>
        <!-- Main Js -->
        <script src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/js/app.js"></script>
        <script type="text/javascript" src="<?php echo VENDOR_URL; ?>select2/dist/js/select2.min.js"></script> 
        <script type="text/javascript">

            jQuery.extend(jQuery.validator.messages, {
                required: "<?php echo $this->lang->line('required_field'); ?>",
                email: "<?php echo $this->lang->line('enter_valid_email'); ?>",
                url: "<?php echo $this->lang->line('enter_valid_url'); ?>",
                date: "<?php echo $this->lang->line('enter_valid_date'); ?>",
                number: "<?php echo $this->lang->line('enter_valid_number'); ?>",
                digits: "<?php echo $this->lang->line('enter_only_digit'); ?>",
                equalTo: "<?php echo $this->lang->line('enter_same_value_again'); ?>",
                remote: "<?php echo $this->lang->line('pls_fix_this'); ?>",
                dateISO: "Please enter a valid date (ISO).",
                maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
                minlength: jQuery.validator.format("Please enter at least {0} characters."),
                rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
                range: jQuery.validator.format("Please enter a value between {0} and {1}."),
                max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
                min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
            });
            
            
             function change_school(url){
                if(url){
                    window.location.href = url; 
                }
            }           
        </script>
        <script type="text/javascript">
    <?php if($post && !empty ($post)){ ?>  
        get_section_by_class('<?php echo $post['class_id']; ?>', '<?php echo $post['section_id']; ?>');
        get_cities_by_prov('<?php echo $post['province_id']; ?>', '<?php echo $post['regency_id']; ?>');
        get_district_by_city('<?php echo $post['regency_id']; ?>', '<?php echo $post['district_id']; ?>');
        get_villages_by_district('<?php echo $post['district_id']; ?>', '<?php echo $post['villages_id']; ?>');
    <?php } ?>    
    function get_cities_by_prov(province_id, regency_id){       
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('web/get_cities_by_prov'); ?>",
            data   : { province_id : province_id , regency_id: regency_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#add_regency_id').html(response);
                }
            }
        });  
                     
        
    }
    
    function get_district_by_city(regency_id, district_id){       
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('web/get_district_by_city'); ?>",
            data   : { regency_id : regency_id , district_id: district_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   
                       $('#add_district_id').html(response);
                   
               }
            }
        });  
                     
        
    }
    
    function get_villages_by_district(district_id, villages_id){       
            $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('web/get_villages_by_district'); ?>",
            data   : { district_id : district_id , villages_id: villages_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  
                       $('#add_villages_id').html(response);
                  
               }
            }
        });  
                     
        
    }
    
    function get_postal_code(){
    
        
            var urban = $('#add_villages_id option:selected').text();
            var sub_district = $('#add_district_id option:selected').text();
            var city = $('#add_regency_id option:selected').text();
            var province_code = $('#add_province_id option:selected').val();
        
        
        var kab = city.startsWith("KABUPATEN");
        var kota = city.startsWith("KOTA");
    
        if(kab){
            city = city.slice(10);
        } else if(kota){
            city = city.slice(5);
        }
    
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('web/get_postal_code'); ?>",
            data   : { urban : urban , sub_district : sub_district, city : city, province_code : province_code},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   
                       $('#add_postal_code').val(response);
                   
               } else {
                
                    $('#add_postal_code').val("");
                
               }
            }
        }); 
    
        
    }
    
            $('#add_province_id').select2({
                placeholder: 'Pilih Provinsi',
                language: "id"
            });
            $('#add_regency_id').select2({
                placeholder: 'Pilih Kota/Kab',
                language: "id"
            });
            $('#add_district_id').select2({
                placeholder: 'Pilih Kecamatan',
                language: "id"
            });
            $('#add_villages_id').select2({
                placeholder: 'Pilih Kelurahan',
                language: "id"
            });
            function change_school(url){
                if(url){
                    window.location.href = url; 
                }
            }   
        </script>
    </body>
</html>