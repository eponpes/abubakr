<?php
$clientcode = $this->global_setting->client_code;
$lang['student_list'] = $this->lang->line('student_list');
$lang['teacher'] = $this->lang->line('teacher');
$lang['class'] = $this->lang->line('class');
$lang['group'] = 'Halaqoh';

if($clientcode == 'qpu'){
    $lang['student_list'] = 'Daftar Peserta';
    $lang['teacher'] = 'Mentor';
    $lang['class'] = 'Batch';
    $lang['group'] = 'Group SAQU/MENTOR';
}
$features = array(
    'Activity' => array(
        'student_attendance' => array(
            'view' => 'attendance',
            'module' => 'student',
            'image' => 'icon/attendances.png',
            'label' => 'Kehadiran',
            'link' => site_url('attendance/student/index')
        ),
        'tahfizh' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/tahfizh.png',
            'label' => 'Mutabaah',
            'link' => site_url('tahfizh/student/index')
        ),
        'leave' => array(
            'view' => 'index',
            'module' => 'userleave',
            'image' => 'icon/leave.png',
            'label' => $this->lang->line('manage_leave'),
            'link' => site_url('userleave/index')
        ),
        'statistics' => array(
            'view' => 'index',
            'module' => 'satistics',
            'image' => 'icon/stats.png',
            'label' => 'Statistik',
            'link' => site_url('statistics')
        ),
    ),
    'Akademik' => array(
        'student' => array(
            'view' => 'student',
            'module' => 'student',
            'image' => 'icon/student.png',
            'label' => $lang['student_list'],
            'link' => site_url('student/index')
        ),
        'teacher' => array(
            'view' => 'teacher',
            'module' => 'teacher',
            'image' => 'icon/teacher.png',
            'label' => $lang['teacher'],
            'link' => site_url('teacher/index')
        ),
        'year' => array(
            'view' => 'administrator',
            'module' => 'year',
            'image' => 'icon/academic.png',
            'label' => $this->lang->line('academic_year'),
            'link' => site_url('administrator/year/index')
        ),
        'class' => array(
            'view' => 'academic',
            'module' => 'classes',
            'image' => 'icon/class.png',
            'label' => $lang['class'],
            'link' => site_url('academic/classes/index')
        ),
        'subject' => array(
            'view' => 'academic',
            'module' => 'subject',
            'image' => 'icon/subject.png',
            'label' => $this->lang->line('subject'),
            'link' => site_url('academic/subject/index')
        ),
        'group' => array(
            'view' => 'accounting',
            'module' => 'invoice',
            'image' => 'icon/class.png',
            'label' => $lang['group'],
            'link' => site_url('groups/groups/index')
        ),
        'library' => array(
            'view' => 'library',
            'module' => 'book',
            'image' => 'icon/class.png',
            'label' => 'Perpustakaan',
            'link' => site_url('library/book/index')
        ),
    ),
    'Raport' => array(
        'input_tahfizh' => array(
            'view' => 'exam',
            'module' => 'mark',
            'image' => 'icon/input-tahfizh.png',
            'label' => 'Input Nilai Tahfizh',
            'link' => site_url('exam/mark/form/tahfizh')
        ),
        'rapot_tahfizh' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/report-4.png',
            'label' => 'Rapot Tahfizh',
            'link' => site_url('exam/resultcardform/view/tahfizh')
        ),
        'rapot_tahsin' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/report-2.png',
            'label' => 'Rapot Tahsin',
            'link' => site_url('exam/resultcardform/view/tahsin')
        ),
        'input_bpi' => array(
            'view' => 'exam',
            'module' => 'resultcard',
            'image' => 'icon/input-bpi.png',
            'label' => 'Input Nilai BPI',
            'link' => site_url('exam/mark/form/bpi')
        ),
        'rapot_bpi' => array(
            'view' => 'exam',
            'module' => 'resultcard',
            'image' => 'icon/report-3.png',
            'label' => 'Rapot BPI',
            'link' => site_url('exam/resultcardform/view/bpi')
        ),
    ),
    'Komunikasi' => array(
        'complain' => array(
            'view' => 'complain',
            'module' => 'complain',
            'image' => 'icon/complain.png',
            'label' => $this->lang->line('manage_complain'),
            'link' => site_url('complain/index')
        ),
        'message' => array(
            'view' => 'message',
            'module' => 'message',
            'image' => 'icon/message.png',
            'label' => $this->lang->line('message'),
            'link' => site_url('message/message')
        ),
        'notice' => array(
            'view' => 'announcement',
            'module' => 'notice',
            'image' => 'icon/notice.png',
            'label' => $this->lang->line('notice'),
            'link' => site_url('announcement/notice/index')
        ),
        'news' => array(
            'view' => 'announcement',
            'module' => 'news',
            'image' => 'icon/news.png',
            'label' => $this->lang->line('news'),
            'link' => site_url('announcement/news/index')
        )
    ),
    'Keuangan' => array(
        'invoice' => array(
            'view' => 'accounting',
            'module' => 'invoice',
            'image' => 'icon/check.png',
            'label' => $this->lang->line('manage_invoice'),
            'link' => site_url('accounting/invoice/check')
        ),
    ),
    'Laporan' => array(
        'report_tahfizh' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/stats2.png',
            'label' => $this->lang->line('student_tahfizh_report'),
            'link' => site_url('report/stahfizh')
        ),
        'report_tahfizh_active' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/stats2.png',
            'label' => $this->lang->line('student_tahfizh_report'),
            'link' => site_url('report/qtahfizh')
        ),
        'report_attendance' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/report1.png',
            'label' => $this->lang->line('student_attendance_report'),
            'link' => site_url('report/sattendance')
        ),
        'report_tattenandace' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/report2.png',
            'label' => $this->lang->line('teacher_attendance_report'),
            'link' => site_url('report/tattendance')
        ),
        'report_student' => array(
            'view' => 'tahfizh',
            'module' => 'student',
            'image' => 'icon/report-student.png',
            'label' => $this->lang->line('student_report'),
            'link' => site_url('report/student')
        )
    ),
);  
// Gold Package
$clients1 = array(
    'Activity' => array(
        'student_attendance', 'tahfizh', 'leave', 'statistics'
    ),
    'Akademik' => array(
        'student', 'teacher', 'year', 'class', 'subject', 'group', 'library'
    ),
    'Raport' => array(
        'input_tahfizh', 'rapot_tahfizh', 'rapot_tahsin'
    ),
    'Komunikasi' => array(
        'complain', 'message', 'notice', 'news'
    ),
    'Keuangan' => array('invoice'),
    'Laporan' => array(
        'report_tahfizh', 'report_attendance', 'report_tattenandace', 'report_student'
    )
);
// Premium Package
$clients2 = array(
    'Activity' => array(
        'student_attendance', 'tahfizh', 'statistics'
    ),
    'Akademik' => array(
        'student', 'teacher', 'year', 'class', 'subject', 'group'
    ),
    'Komunikasi' => array(
        'complain', 'message', 'notice', 'news'
    ),
    'Laporan' => array(
        'report_tahfizh'
    )
);
// Quran Puzzle Package
$clients3 = array(
    'Activity' => array(
        'student_attendance', 'tahfizh'
    ),
    'Akademik' => array(
        'student', 'teacher', 'year', 'class', 'group'
    ),
    'Komunikasi' => array(
        'message', 'notice', 'news'
    ),
    'Laporan' => array(
        'report_tahfizh_active'
    )
);
if($clientcode == 'ibd'){
    $clients = $clients1;
    // New Feature
    $clients['Raport'][] = 'input_bpi';
    $clients['Raport'][] = 'rapot_bpi';
} else if($clientcode == 'ymk' || $clientcode == 'ymn'){
    $clients = $clients1;
} else if($clientcode == 'qpu'){
    $clients = $clients3;
    if($this->session->userdata('role_id') == STUDENT) {
        unset($features['Activity']);
        //unset($features['Akademik']['group']);
    }
    unset($features['Raport']);
    unset($features['Keuangan']);
} else {
    $clients = $clients2;
    unset($features['Raport']);
    unset($features['Keuangan']);
}

?>
<?php foreach($features as $key => $gro) { ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">            
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h4 class="head-title"><?php echo $key; ?></h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                                
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <?php
            $numOfCols = 4;
            $rowCount = 0;
            ?>
                <div class="row home-row">
                    <div class="tile_button">
                        <?php foreach($features[$key] as $featkey => $feat) {
                        if(in_array($featkey, $clients[$key])){
                            ?>
                                <div class="col-md-2 col-sm-3 col-xs-3 tile_stats_count">
                                    <a href="<?php echo $feat['link']; ?>" class="button">
                                        <figure><img src="<?php echo IMG_URL . $feat['image']; ?>"></figure>
                                        <div class="text">
                                        <?php echo $feat['label']; ?>
                                        </div>
                                    </a>
                                </div>
                            <?php

                        }
                        $rowCount++;
                        if($rowCount % $numOfCols == 0) echo '</div></div><div class="row home-row"><div class="tile_button">';
                    } 
                ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>