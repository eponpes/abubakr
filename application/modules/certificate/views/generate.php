<!DOCTYPE html>
<html>
<head>      

        <title><?php echo $this->lang->line('generate_certificate'); ?></title>
        
        <?php if($this->global_setting->favicon_icon){ ?>
            <link rel="icon" href="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->favicon_icon; ?>" type="image/x-icon" />             
        <?php }else{ ?>
            <link rel="icon" href="<?php echo IMG_URL; ?>favicon.ico" type="image/x-icon" />
        <?php } ?>    
        
         <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=EB+Garamond" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Extra+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Limelight" rel="stylesheet">  
        <link href="https://fonts.googleapis.com/css?family=Michroma" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Prosto+One" rel="stylesheet">   
        <link href="https://fonts.googleapis.com/css?family=Stalemate" rel="stylesheet">   
              
        <!-- Bootstrap -->
        <link href="<?php echo VENDOR_URL; ?>bootstrap/bootstrap.min.css" rel="stylesheet">       
        <!-- Custom Theme Style -->
        <link href="<?php echo CSS_URL; ?>custom.css" rel="stylesheet">
        
        <style>
            @import url('https://fonts.cdnfonts.com/css/righten');
            @font-face {
            font-family: 'hand-script';
                src:  url('https://pptq.eponpes.id/assets/images/font/hand-script.ttf.woff') format('woff'),
                url('https://pptq.eponpes.id/assets/images/font/hand-script.ttf.svg#hand-script') format('svg'),
                url('https://pptq.eponpes.id/assets/images/font/hand-script.ttf.eot'),
                url('https://pptq.eponpes.id/assets/images/font/hand-script.eot?#iefix') format('embedded-opentype'); 
                font-weight: normal;
                font-style: normal;
            }
            body {background: #fff;}
            @page { margin: 0; }   
            @media print {
                .certificate {                   
                    background: url("<?php echo UPLOAD_PATH; ?>certificate/<?php echo $certificate->background; ?>") no-repeat !important;    
                    width: 1200px;
                    height: 810px;
                    padding: 10%;
                    margin-left: auto;
                    margin-right: auto;
                    background-size: 100% 100% !important;
                   -webkit-print-color-adjust: exact !important; 
                    color-adjust: exact !important; 
                    text-align: center;
                }
                .name-text {               
                    text-align: center !important;  
                }  
            } 
   
            .certificate {
                min-height: 550px;
                margin-left: auto;
                margin-right: auto;
                padding: 80px 120px;
                background: url("<?php echo UPLOAD_PATH; ?>certificate/<?php echo $certificate->background; ?>") no-repeat;    
                background-size: 100% 100%;
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                text-align: center;
            }
            .main-text {
                font-family: 'Righten', sans-serif;
                padding-top: 320px; 
                font-size: 110px;
                padding-left: 0px;
            }
            .main-text span {
                text-transform: capitalize;
            }
            .main-text span {
                text-decoration: auto;
            }
            .main-text-block {
                margin-top: -55px;
            }
            .main-class-name {
                letter-spacing: 4px;
                font-family: 'Oswald';
                position: absolute;
                font-size: 24px;
                font-weight: bold;
                top: 55%;
                left: 25.5%;
                width: 110px;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
                padding: 0;
                text-transform: uppercase;
            }
            

    </style>
    </head>

    <body>
        <div class="x_content">
             <div class="row">
                 <div class="col-sm-12">                 
                    <div class="certificate">
                        <?php /*
                        <div class="certificate-top">
                            <h2 class="top-heading-title"><?php echo $certificate->top_title; ?></h2>                              
                           <div class="row">
                                <span class="sub-title-img">
                                  <?php if($school->logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
                                 <?php }else if($school->frontend_logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
                                 <?php }else{ ?>                                                        
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
                                 <?php } ?>
                                </span> 
                           </div>                            
                        </div> */ ?>
                       <div class="clear"></div>
                       <?php /*
                        <div class="name-section">                           
                            <div style="text-align:center;">
                                <h3 class="name-text"><?php echo $certificate->name; ?></h3>
                            </div>                           
                        </div> */ ?>
                        <div class="clear"></div>
                        <div class="main-text-block">
                            <p class="main-text">
                                <?php echo ucwords(strtolower($certificate->main_text)); ?>
                            </p>
                        </div>
                        <div class="footer-section">
                            <div class="row" >
                                <div class="col-sm-4 <?php if($certificate->footer_left){ echo 'footer_text'; } ?>"><?php echo $certificate->footer_left; ?></div>
                                <div class="col-sm-4 <?php if($certificate->footer_middle){ echo 'footer_text'; } ?>"><?php echo $certificate->footer_middle; ?></div>
                                <div class="col-sm-4 <?php if($certificate->footer_right){ echo 'footer_text'; } ?>"><?php echo $certificate->footer_right; ?></div>
                            </div>
                        </div>
                    </div>                 
                 </div>
             </div>

            <!-- this row will not appear when printing -->
            <center class="row no-print">
                <div class="col-xs-12">
                    <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </center>
        </div>
    </body>
</html>