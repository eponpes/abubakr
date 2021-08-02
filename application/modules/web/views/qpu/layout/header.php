<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg fixed-top navbar-custom navbar-light sticky">
    		<div class="container">
			    <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <!-- Applock -->
                    <img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/logo.png" class="l-dark" height="23" alt="">
                    <img src="<?php echo VENDOR_URL; ?>/<?php echo $theme; ?>/images/logo-light.png" class="l-light" height="23" alt="">
                </a>
				
			    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			        <span class="mdi mdi-menu"></span>
			    </button><!--end button-->

			    <div class="collapse navbar-collapse" id="navbarCollapse">
			        <ul class="navbar-nav mx-auto">
			            <li class="nav-item active">
			                <a class="nav-link" href="<?php echo site_url(); ?>">Beranda</a>
			            </li><!--end nav item-->
						<li class="nav-item">
			                <a class="nav-link" href="<?php echo site_url(); ?>#program">Program</a>
			            </li><!--end nav item-->    
			            <li class="nav-item">
			                <a class="nav-link" href="<?php echo site_url(); ?>#services">Fitur</a>
			            </li><!--end nav item-->    
			            <li class="nav-item">
			                <a class="nav-link" href="<?php echo site_url(); ?>#video">Video Metode Puzzle</a>
			            </li><!--end nav item-->
						<li class="nav-item">
			                <a class="nav-link" href="<?php echo site_url(); ?>#team">Tim</a>
			            </li><!--end nav item-->
						<?php if (logged_in_user_id()) { ?>                     
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('dashboard'); ?>"><?php echo $this->lang->line('dashboard'); ?></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a>
							</li>
						<?php }else{ ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo site_url('login'); ?>"><?php echo $this->lang->line('login'); ?></a>
							</li>
						<?php } ?>
                    </ul><!--end navbar nav-->

                    <?php if(isset($school->enable_online_admission) && $school->enable_online_admission){ ?>
                        <div class="hta-box">
                            <a class="login-button mouse-down ml-3" href="<?php echo site_url('admission-online'); ?>">DAFTAR GRATIS</a>
                        </div>
                    <?php } ?> 
                    
                   

			    </div><!--end collapse-->
		    </div><!--end container-->
		</nav><!--end navbar-->
        <!-- Navbar End -->