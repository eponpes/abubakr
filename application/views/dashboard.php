<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">            
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h4 class="head-title">Aktivitas</h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row home-row">
                    <div class="tile_button">
                    <?php if(has_permission(VIEW, 'attendance', 'student')){ ?>
                    <?php if($responsibility != 'bpi' && $responsibility != 'tahfidz' ) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('attendance/student/index'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/attendances.png"></figure>
                            <div class="text">
                            <?php echo $this->lang->line('student_attendance'); ?>
                            </div>
                        </a></div>
                    <?php } ?>
                    <?php if($responsibility != 'bpi' ) { ?>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('tahfizh/student/index'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/tahfizh.png"></figure>
                            <div class="text">
                            <?php echo $this->lang->line('student_tahfizh'); ?>
                            </div>
                        </a></div>
                    <?php } ?>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('userleave/index'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/leave.png"></figure>
                            <div class="text">
                            <?php echo $this->lang->line('manage_leave'); ?>
                            </div>
                        </a>    
                    </div>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('statistics'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/stats.png"></figure>
                            <div class="text">
                            Statistik
                            </div>
                        </a>    
                    </div>
                    <?php } ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">            
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h4 class="head-title">Akademik</h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row ">
                    <div class="tile_button">
                    <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('student/index'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/student.png"></figure>
                            <div class="text">
                            <?php echo $this->lang->line('student_list'); ?>
                            </div>
                        </a></div>
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'teacher', 'teacher')){ ?>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('teacher/index'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/teacher.png"></figure>
                            <div class="text">
                            <?php echo $this->lang->line('teacher'); ?>
                            </div>
                        </a></div>
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'administrator', 'year')){ ?>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('administrator/year/index'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/academic.png"></figure>
                            <div class="text">
                            <?php echo $this->lang->line('academic_year'); ?>
                            </div>
                        </a></div>
                    <?php } ?>
                    <?php if(has_permission(VIEW, 'academic', 'classes')){ ?>
                    <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                        <a href="<?php echo site_url('academic/classes/index'); ?>" class="button">
                            <figure><img src="<?php echo IMG_URL; ?>icon/class.png"></figure>
                            <div class="text">
                            <?php echo $this->lang->line('class'); ?>
                            </div>
                        </a></div>
                    <?php } ?>
                    </div>
                </div>
                <div class="row home-row">
                    <div class="tile_button">
                        <?php if(has_permission(VIEW, 'academic', 'section')){ ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('academic/section/index'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/section.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('section'); ?>
                                </div>
                            </a>    
                        </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'academic', 'subject')){ ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('academic/subject/index'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/subject.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('subject'); ?>
                                </div>
                            </a>    
                        </div>
                        <?php } ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">            
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h4 class="head-title">Pengisian Nilai dan Rapot</h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row home-row">
                    <div class="tile_button">
                        <?php if(has_permission(VIEW, 'exam', 'mark') && has_permission(VIEW, 'exam', 'resultcard')){ ?>
                            <?php if($responsibility != 'bpi' || $responsibility == 'tbi') { ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('exam/mark/form/tahfizh'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/lock.png"></figure>
                                <div class="text">
                                Input Nilai Tahfizh
                                </div>
                            </a>    
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('exam/resultcardform/view/tahfizh'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/lock.png"></figure>
                                <div class="text">
                                Rapot Tahfizh
                                </div>
                            </a>
                        </div>
                            <?php } ?>
                            
                        <?php } ?>
                      
                    </div>
                </div>
                <div class="row home-row">
                    <div class="tile_button">
                    
                    <?php if(has_permission(VIEW, 'exam', 'resultcard') && has_permission(VIEW, 'exam', 'mark')){ ?>
                        <?php if($responsibility != 'tahfidz' || $responsibility == 'tbi') { ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('exam/mark/form/bpi'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/lock.png"></figure>
                                <div class="text">
                                Input Nilai BPI
                                </div>
                            </a>    
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('exam/resultcardform/view/bpi'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/lock.png"></figure>
                                <div class="text">
                                Rapot BPI
                                </div>
                            </a>    
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('exam/resultcardform/view/character'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/lock.png"></figure>
                                <div class="text">
                                Rapot Karakter BPI
                                </div>
                            </a>    
                        </div>
                            <?php } ?>
                       
                        <?php } ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">            
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h4 class="head-title">Komunikasi</h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row home-row">
                    <div class="tile_button">
                        <?php if(has_permission(VIEW, 'complain', 'complain')){ ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('complain/index'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/complain.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('manage_complain'); ?>
                                </div>
                            </a></div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'message', 'message')){ ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('message/inbox'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/message.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('message'); ?>
                                </div>
                            </a></div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'announcement', 'notice')){ ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('announcement/notice/index'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/notice.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('notice'); ?>
                                </div>
                            </a>    
                        </div>
                        <?php } ?>
                        <?php if(has_permission(VIEW, 'announcement', 'news')){ ?>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('announcement/news/index'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/news.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('news'); ?>
                                </div>
                            </a>    
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(has_permission(VIEW, 'report', 'report')){ ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">            
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h4 class="head-title">Laporan</h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row home-row">
                    <div class="tile_button">
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('report/stahfizh'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/stats2.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('student_tahfizh_report'); ?>
                                </div>
                            </a></div>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('report/sattendance'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/report1.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('student_attendance_report'); ?>
                                </div>
                            </a></div>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('report/tattendance'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/report2.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('teacher_attendance_report'); ?>
                                </div>
                            </a>    
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                            <a href="<?php echo site_url('report/student'); ?>" class="button">
                                <figure><img src="<?php echo IMG_URL; ?>icon/report-student.png"></figure>
                                <div class="text">
                                <?php echo $this->lang->line('student_report'); ?>
                                </div>
                            </a>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>