<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta charset="ISO-8859-15">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $title_for_layout; ?></title>   
        <?php if($this->global_setting->favicon_icon){ ?>
            <link rel="icon" href="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->favicon_icon; ?>" type="image/x-icon" />             
        <?php }else{ ?>
            <link rel="icon" href="<?php echo IMG_URL; ?>favicon.ico" type="image/x-icon" />
        <?php } ?>
        
        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/fontawesome-all.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/animate.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/meanmenu.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/jquery.fancybox.min.css">
        
        <?php if(isset($school->theme_name)){ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/theme/<?php echo $school->theme_name; ?>.css">
        <?php }else{ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/style.css">
        <?php } ?>  
        
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/responsive.css">
        
        <?php if($school->enable_rtl){ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/rtl.css">
        <?php }elseif($this->global_setting->enable_rtl){ ?>
            <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/rtl.css">
        <?php } ?>

        <link rel="stylesheet" href="<?php echo VENDOR_URL; ?>select2/dist/css/select2.min.css">
         
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <script src="<?php echo JS_URL; ?>front/jquery-3.3.1.min.js"></script>
        <script src="<?php echo JS_URL; ?>jquery.validate.js"></script>
        
        <?php if(isset($this->global_setting->google_analytics) && !empty($this->global_setting->google_analytics)){ ?>         
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $this->global_setting->google_analytics; ?>"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', '<?php echo $this->global_setting->google_analytics; ?>');
            </script>
        <?php } ?>
           
    </head>

    <body>
        <div id="preloader"></div>
        
        <?php $this->load->view('layout/header'); ?>  
        
        <!-- page content -->        
        <?php echo $content_for_layout; ?>
        <!-- /page content -->
        
        <!-- footer content -->
        <?php $this->load->view('layout/footer'); ?>   
        <!-- /footer content -->


        <!-- Scripts -->      
        <script src="<?php echo JS_URL; ?>front/jquery-ui.js"></script>
        <script src="<?php echo JS_URL; ?>front/owl.carousel.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.counterup.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.meanmenu.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.fancybox.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.scrollUp.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.waypoints.min.js"></script>
<!--        <script src="<?php echo JS_URL; ?>front/popper.min.js"></script>-->
        <script src="<?php echo JS_URL; ?>front/bootstrap.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/theme.js"></script> 
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