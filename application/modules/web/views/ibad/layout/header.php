<!--HEADER START-->
<header class="header <?php echo (empty($home) ? 'workDetail' : ''); ?> isSticky" id="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 noPaddingLeft">
                <div class="logo">
                    <?php if(empty($home)) { ?>
                        <a href="<?php echo site_url(); ?>"><img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/flogo.png" alt=""></a>
                    <?php } else { ?>
                        <a href="<?php echo site_url(); ?>"><img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/logo.png" alt=""></a>
                    <?php } ?> 
                    
                </div>
                <div class="logo logoText hidden">
                    <h1><a href="<?php echo site_url(); ?>">Ibadurrohman</a></h1>
                </div>
                <div class="stickyLogo">
                    <a href="<?php echo site_url(); ?>"><img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/flogo.png" alt=""></a>
                </div>
            </div>
            <div class="col-md-8">
                <nav class="mainMenu">
                    <div class="mobileBar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <?php
                    // Link Builder
                    $siteUrl = site_url();
                    $linkHome = '#slider';
                    $linkProfile = '#about';
                    $linkWhatwe = '#whatwe';
                    $linkOurwork = '#school';
                    $linkBlog = '#blog';
                    $linkContact = '#contact';
                    if(empty($home)){ // not homepage
                        $linkHome = $siteUrl;
                        $linkProfile = $siteUrl . '#about';
                        $linkWhatwe = $siteUrl . '#whatwe';
                        $linkOurwork = $siteUrl . '#school';
                        $linkBlog = $siteUrl . '#blog';
                        $linkContact = $siteUrl . '#contact';
                    }
                    ?>
                    <ul>
                        <li class="scroll active"><a href="<?php echo $linkHome; ?>">HOME</a></li>
                        <li class="scroll"><a href="<?php echo $linkProfile; ?>">PROFILE</a></li>
                        <li class="scroll"><a href="<?php echo $linkWhatwe; ?>">KEUNGGULAN</a></li>
                        <li class="scroll has-menu-items"><a href="<?php echo $linkOurwork; ?>">JENJANG</a>
                            <ul class="sub-menu">
                            <?php foreach($schools as $obj ){ ?>
                                <li><a href="<?php echo site_url('school/'.$obj->id); ?>" link="<?php echo site_url('school/'.$obj->id); ?>" onclick="change_school(this.getAttribute('link'));return false;"><?php echo $obj->school_name; ?></a></li>
                            <?php } ?>
                            </ul>
                        </li>
                        <li class="scroll"><a href="<?php echo $linkBlog; ?>">BERITA</a></li>
                        <li class="scroll"><a href="<?php echo $linkContact; ?>">HUBUNGI KAMI</a></li>
                        <?php if (logged_in_user_id()) { ?>  
                        <li class="scroll has-menu-items"><a href="#about">USER</a>
                            <ul class="sub-menu">
                                <li><a class="text" href="<?php echo site_url('dashboard'); ?>"><?php echo $this->lang->line('dashboard'); ?></a></li>
                                <li><a class="text" href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a></li>
                            </ul>
                        </li>
                        <?php }else{ ?>
                            <li class="scroll"><a class="text" href="<?php echo site_url('login'); ?>"><?php echo $this->lang->line('login'); ?></a></li>
                        <?php } ?>
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