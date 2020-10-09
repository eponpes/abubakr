<!--HEADER START-->
<header class="header <?php echo (empty($page) ? 'workDetail' : ''); ?> isSticky" id="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 noPaddingLeft">
                <div class="logo">
                    <?php if(empty($page)) { ?>
                        <a href="/"><img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/flogo.png" alt=""></a>
                    <?php } else { ?>
                        <a href="/"><img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/logo.png" alt=""></a>
                    <?php } ?> 
                    
                </div>
                <div class="logo logoText hidden">
                    <h1><a href="/">Ibadurrohman</a></h1>
                </div>
                <div class="stickyLogo">
                    <a href="/"><img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/flogo.png" alt=""></a>
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
                    <p class="scroll"><a href="<?php echo site_url('admission-online'); ?>">PSB ONLINE</a></p>
                </div>
            </div>
        </div>
    </div>
</header>
<!--HEADER END-->