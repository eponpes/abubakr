<?php /*
<div class="bgimage"><img src="<?php echo IMG_URL; ?>signature/stamp.png"></div>
*/ ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title no-print">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_result_card'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
                                             
            <div class="x_content quick-link no-print">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>      

            <?php 
                $form_url = site_url('exam/resultcardform/view/'.$formtype);
                $form_url_s = substr(site_url('exam/resultcardform/view/'.$formtype), 0, -5);
            ?>
               
            <div class="x_content no-print"> 
                <?php echo form_open_multipart($form_url, array('name' => 'resultcard', 'id' => 'resultcard', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">  
                    
                    <?php $this->load->view('layout/school_list_filter'); ?> 
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('academic_year'); ?> <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                <?php foreach ($academic_years as $obj) { ?>
                                <?php $running = $obj->is_running ? ' ['.$this->lang->line('running_year').']' : ''; ?>
                                <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; echo $running; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <?php if($this->session->userdata('role_id') != STUDENT ){ ?>    
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <?php $teacher_student_data = get_teacher_access_data('student'); ?>
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_student_by_class(this.value,'', '<?php echo $formtype; ?>');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                    <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_student_data)){ continue;  ?>
                                    <?php }elseif($this->session->userdata('role_id') == GUARDIAN && !in_array($obj->id, $guardian_class_data)){ continue; } ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    <?php /*
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id" required="required" onchange="get_student_by_section(this.value,'');">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div> */ ?>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('student'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="student_id" id="student_id" required="required">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('student_id'); ?></div>
                        </div>
                    </div>
                    <?php } ?>    
                
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <div class="form-group"><br/>
                            <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('find'); ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="x_content no-print">  
            <?php  if (isset($student) && !empty($student)) { ?>
            <?php if($formtype == 'bpi' || $formtype == 'character') { ?>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="level-choice">Pilih Level</label>
                            <select class="form-control" id="level" name="level">
                                <option value="0">-------</option>
                                <option <?php if(isset($_GET['l']) && $_GET['l'] == '1'){echo 'selected';} ?> value="1">Tingkat Dasar&Lanjut</option>
                                <?php /*<option <?php if(isset($_GET['l']) && $_GET['l'] == '2'){echo 'selected';} ?> value="2">Tingkat Lanjut</option>*/ ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="semester-choice">Pilih Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                <option value="0">-------</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '1'){echo 'selected';} ?> value="1">1</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '2'){echo 'selected';} ?> value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="semester-choice">Pilih Period</label>
                            <select class="form-control" id="period" name="period">
                                <option value="0">-------</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q1'){echo 'selected';} ?> value="Q1">Q1</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q2'){echo 'selected';} ?> value="Q2">Q2</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q3'){echo 'selected';} ?> value="Q3">Q3</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q4'){echo 'selected';} ?> value="Q4">Q4</option>
                            </select>
                        </div>
                    </div>
                </div>
            <?php } else { ?> 
                <?php if($clientcode == 'ibd') { ?>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="semester-choice">Pilih Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                <option value="0">-------</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '1'){echo 'selected';} ?> value="1">UTS SM1</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '2'){echo 'selected';} ?> value="2">UAS SM1</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '3'){echo 'selected';} ?> value="3">UTS SM2</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '4'){echo 'selected';} ?> value="4">UAS SM2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php } else if($clientcode == 'ymn') { ?>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="semester-choice">Pilih Caturwulan</label>
                            <select class="form-control" id="semester" name="semester">
                                <option value="0">-------</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '1'){echo 'selected';} ?> value="1">CAWU 1</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '2'){echo 'selected';} ?> value="2">CAWU 2</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '3'){echo 'selected';} ?> value="3">CAWU 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php } else { ?>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="semester-choice">Pilih Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                <option value="0">-------</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '1'){echo 'selected';} ?> value="1">UAS SM1</option>
                                <option <?php if(isset($_GET['s']) && $_GET['s'] == '2'){echo 'selected';} ?> value="2">UAS SM2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
            </div>
            <?php } ?>

            <?php  if ($formtype == 'other') { ?>
            <?php  if (isset($student) && !empty($student)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-6 col-xs-6  col-sm-offset-3 col-xs-offset-3  layout-box">
                        <p>
                            <?php if(isset($school)){ ?>
                            <h4><?php echo $school->school_name; ?></h4>
                            <p> <?php echo $school->address; ?></p>
                            <?php } ?>
                            <h4><?php echo $this->lang->line('result_card'); ?> BPI</h4> 
                            <div class="profile-pic">
                                <?php if ($student->photo != '') { ?>
                                   <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $student->photo; ?>" alt="" width="80" /> 
                                <?php } else { ?>
                                    <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="45" /> 
                                <?php } ?>
                            </div>
                            <?php echo $this->lang->line('name'); ?> : <?php echo $student->name; ?><br/>
                            <?php echo $this->lang->line('class'); ?> : <?php echo $student->class_name; ?>,
                            <?php echo $this->lang->line('section'); ?> : <?php echo $student->section; ?>,
                            <?php echo $this->lang->line('roll_no'); ?> : <?php echo $student->roll_no; ?>
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
             <?php } ?>

             <?php  if ($formtype == 'tahfizh' || $formtype == 'tahsin') { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="text-center align-middle">
                            <div class="row">
                                <div class="school-logo col-sm-1 col-xs-2">
                                    <?php if($school->logo){ ?>
                                        <img class="logo-report" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="80" />
                                    <?php } ?>
                                </div>
                                <div class="school-info col-sm-9 col-xs-8">
                                    <div class="top-school"><?php echo $school->school_parent; ?></div>
                                    <?php if(isset($school)){ ?>
                                    <div class="name-school"><?php echo $school->school_name; ?></div>
                                    <p> <?php echo $school->address; ?></p>
                                <?php } ?>
                                </div>
                                <?php if($clientcode == 'ymn') {
                                    ?>
                                    <div class="school-logo col-sm-1 col-xs-2">
                                        <img class="logo-report" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt="" height="80" />
                                    </div>
                                    <?php
                                } 
                                ?>
                                
                            </div>

                            <hr class="style8" />
                            <?php 
                                $periodic = 'uas';
                                $period_label = '';
                                $numperiod = $_GET['s'];
                                $numperiodp = $_GET['p'];
                                if ($clientcode == 'ibd'){
                                    if($_GET['p'] == 'SM1' || $_GET['p'] == 'SM3') {
                                        $periodic = 'uts';
                                    }
                                    if($numperiod == 1 || $numperiod == 2){
                                        $period_label = 'Semester 1';
                                    } else if($numperiod == 3 || $numperiod == 4){
                                        $period_label = 'Semseter 2';
                                    }
                                } else {
                                    $period_label = 'Semester 1';
                                    if($_GET['p'] == 'SM2') {
                                        $period_label = 'Semester 2';
                                    }
                                }
                            ?>
                            <?php if($formtype == 'tahfizh') { ?>
                                <?php if($periodic == 'uts') { ?>
                                    <h4><strong>تقرير نتائج الإمتحان النصفي في تحسين القرآن و تحفيظه </strong></h4>
                                    <h5><strong>LAPORAN PENILAIAN UJIAN TENGAH SEMESTER TAHSIN DAN TAHFIDZ AL-QUR’AN</strong></h5>
                            <?php } else if ($periodic == 'uas') { ?>
                                    <h4><strong>تقرير نتائج الامتحان النهائي في تحسين القرآن وتحفيظه</strong><h4>
                                    <h5><strong>LAPORAN PENILAIAN UJIAN AKHIR SEMESTER TAHSIN DAN TAHFIDZ AL-QUR’AN</strong></h5>
                                <?php } ?>
                                
                            <?php } else if($formtype == 'tahsin') { ?>
                                <?php if($periodic == 'uas') { ?>
                                    <h4><strong>تقرير نتائج الامتحان النهائي في تحسين القرآن</strong><h4>
                                <h5><strong>LAPORAN PENILAIAN TAHSIN AKHIR SEMESTER</strong></h5>                                
                                <?php } else if ($periodic == 'uts') { ?>
                                <h4><strong>تقرير نتائج الامتحان النصفي في تحسين القرآن</strong><h4>
                                <h5><strong>LAPORAN PENILAIAN TAHSIN TENGAH SEMESTER</strong></h5>
                                <?php } ?>

                                
                            <?php } ?>
                            
                        </div>
                        <table id="datatable-responsive" class="table dt-responsive nowrap noborder" cellspacing="0" width="100%">
                            <tr>
                                <td style="text-align:left; width: 150px">Nama</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->name; ?></td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Tahun Pelajaran</td>
                                <td style="text-align:left; width: 150px"><?php echo $session; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width: 150px">NIS/NISN</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->roll_no; ?></td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Kelas/Semester</td>
                                <td style="text-align:left; width: 150px"><?php echo $student->class_name . ' ' . $student->section; ?> / <?php echo $period_label; ?></td>
                            </tr>
                        </table>
                        
                    </div>
                </div>            
            </div>
             <?php } else if ($formtype == 'bpi' || $formtype == 'character') { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="text-center align-middle">
                            <div class="row">
                                <div class="school-logo col-md-1 col-sm-2 col-xs-2">
                                    <?php if($school->logo){ ?>
                                        <img class="logo-report" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="80" />
                                    <?php } ?>
                                </div>
                                <div class="school-info col-md-9 col-sm-9 col-xs-9">
                                    <div class="top-school"><?php echo $school->school_parent; ?></div>
                                    <?php if(isset($school)){ ?>
                                    <div class="name-school"><?php echo $school->school_name; ?></div>
                                    <p> <?php echo $school->address; ?></p>
                                <?php } ?>
                                </div>
                                <?php if($clientcode == 'ymn') {
                                    ?>
                                    <div class="school-logo col-md-1 col-sm-1 col-xs-2">
                                        <img class="logo-report" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt="" height="80" />
                                    </div>
                                    <?php
                                } 
                                ?>
                            </div>

                            <hr class="style8" />

                            <h5><strong>LAPORAN PENCAPAIAN BPI (BINA PRIBADI ISLAM)</strong></h5>
                        </div>
                        <?php $periode = !empty($_GET['p'])? $_GET['p'] : 'Q1'; ?>
                        <table id="datatable-responsive" class="table dt-responsive nowrap noborder" cellspacing="0" width="100%">
                            <tr>
                                <td style="text-align:left; width: 150px">Nama</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->name; ?></td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Periode</td>
                                <td style="text-align:left; width: 30%">: <?php echo get_period_name($periode); ?> <?php echo get_academic_year_name($periode, $academic_sessions); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width: 150px">NIS/NISN</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->roll_no; ?></td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Kelas/Semester</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->class_name . ' ' . $student->section; ?> </td>
                            </tr>
                        </table>
                        
                    </div>
                </div>            
            </div>
             <?php } ?>

            <div class="x_content">
                <div class="row justify-content-center no-margin">

                <?php echo $html_table_character; ?>

                <?php echo $html_table_character3; ?>

                <?php echo $html_table_character2; ?>

                <?php echo $html_table_tahfizh; ?>

                </div>
    
            </div>
          
            <?php if($formtype == 'bpi' || $formtype == 'character') { ?>
                <div class="rowt with-top-space"><div class="col-lg-12">&nbsp;</div></div>
                <div class="rowt">
                    <div class="col-xs-7">&nbsp;</div>
                    <div class="col-xs-4 text-right">
                        <?php
                        $day = date("d");
                        $month = get_sign_date(date("m"));
                        $year = date("Y");
                        $signdate = $day . ' ' . $month . ' ' . $year;
                        ?>
                        <span class="date-sign">Tasikmalaya, <?php echo $signdate; ?></span>
                    </div>
                </div>
                <div class="rowt">
                    <div class="col-xs-1 text-center" style="width: 6%">&nbsp;</div>
                    <div class="col-xs-3 text-center" style="width: 28%">
                        <div class="knowing">
                            <?php
                                $imagepath1 = IMG_URL . 'signature/1.png?v=9.12.21';
                                $defaultpath1 = IMG_URL . 'signature/default.png';
                                if(remote_file_exists($imagepath1))
                                {
                                    echo "<img class=\"sign-teacher middle\" src=\"$imagepath1\"/>\n";
                                }
                                else
                                {
                                    echo "<img class=\"sign-teacher default\" src=\"$defaultpath1\"/>\n";
                                } 
                            ?>
                            <p>Direktur Harian PPTQ Ibadurrohman</p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_principal)) {
                                echo $school->adm_principal;
                            } ?>
                        </div>
                        <div class="stamp"><img src="<?php echo IMG_URL; ?>signature/stamp.png"></div>
                    </div>
                    <div class="col-xs-1 text-center" style="width: 4.15%">
                        &nbsp;
                    </div>
                    <div class="col-xs-3 text-center" style="width: 28%">
                        <div class="knowing">
                            <?php
                                $imagepath = IMG_URL . 'signature/2.png';
                                $defaultpath = IMG_URL . 'signature/default.png';
                                if(remote_file_exists($imagepath))
                                {
                                    echo "<img class=\"sign-teacher middle\" src=\"$imagepath\"/>\n";
                                }
                                else
                                {
                                    echo "<img class=\"sign-teacher default\" src=\"$defaultpath\"/>\n";
                                } 
                            ?>
                            <p>Ketua BPI</p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_siebpi)) {
                                echo $school->adm_siebpi;
                            } ?>
                        </div>
                    </div>
                    <div class="col-xs-1 text-center" style="width: 4.15%">
                        &nbsp;
                    </div>
                    <div class="col-xs-3 text-center" style="width: 28%">
                        <div class="knowing">
                            <?php
                                $teacherpict = array();
                                $teacherpict['id'] = $myteacher->id;
        
                                if($clientcode == 'ibd') {
                                    $teacherpict = get_teacher_sign($teacherpict['id']);
                                }
                                $imagepath1 = IMG_URL . 'signature/'.$teacherpict['id'].'.png';
                                $defaultpath1 = IMG_URL . 'signature/default.png';
                                if(remote_file_exists($imagepath1))
                                {
                                    echo "<img class=\"sign-teacher middle\" src=\"$imagepath1\"/>\n";
                                }
                                else
                                {
                                    echo "<img class=\"sign-teacher default\" src=\"$defaultpath1\"/>\n";
                                } 
                            ?>
                            <p>Guru Pembina BPI</p>
                        </div>
                        <div class="signature">
                            <?php 
                                if(isset($myteacher)) {
                                    if(!empty($teacherpict['name'])){
                                        echo $teacherpict['name'];
                                    } else {
                                        echo $myteacher->name;
                                    }
                                } 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else if($formtype == 'tahfizh' || $formtype == 'tahsin') { ?>
                <div class="rowt"><div class="col-lg-12">&nbsp;</div></div>
                <div class="rowt">
                    <div class="col-xs-7">&nbsp;</div>
                    <div class="col-xs-4 text-right">
                        <?php
                        $day = date("d");
                        $month = get_sign_date(date("m"));
                        $year = date("Y");
                        $signdate = $day . ' ' . $month . ' ' . $year;
                        ?>
                        <span class="date-sign">Tasikmalaya, <?php echo $signdate; ?></span>
                    </div>
                </div>
                <div class="rowt">
                    <div class="col-xs-1 text-center" style="width: 3%">&nbsp;</div>
                    <div class="col-xs-3 text-center" style="width: 28%">
                        <div class="knowing">
                            <p>ORANG TUA/WALI SANTRI</p>
                        </div>
                        <div class="signature">
                            ( .............................. )
                        </div>
                    </div>
                    <div class="col-xs-1 text-center" style="width: 5.15%">
                        &nbsp;
                    </div>
                    <div class="col-xs-3 text-center" style="width: 28%">
                        <div class="knowing">
                        <?php
                            $imagepath = IMG_URL . 'signature/1.png?v=9.12.21';
                            $defaultpath = IMG_URL . 'signature/default.png';
                            if(remote_file_exists($imagepath))
                            {
                                echo "<img class=\"sign-teacher middle\" src=\"$imagepath\"/>\n";
                            }
                            else
                            {
                                echo "<img class=\"sign-teacher default\" src=\"$defaultpath\"/>\n";
                            } 
                        ?>
                        <?php if($clientcode == 'ibd') {
                            $dirlabel = "DIREKTUR HARIAN";
                        } else {
                            $dirlabel = "PIMPINAN";
                        } ?>
                        <p><?php echo $dirlabel; ?> <?php echo isset($school->school_name) ? $school->school_name : ''; ?></p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_principal)) {
                                echo $school->adm_principal;
                            } ?>
                        </div>
                        <div class="stamp"><img src="<?php echo IMG_URL; ?>signature/stamp.png"></div>
                    </div>
                    <div class="col-xs-1 text-center" style="width: 5.15%">
                        &nbsp;
                    </div>
                    <div class="col-xs-3 text-center" style="width: 28%">
                        <div class="knowing">
                            <?php if($clientcode == 'ymk' || $clientcode == 'ymn') { ?>
                            <?php
                            $nowversion = strtotime("now");
                            $imagepath1 = IMG_URL . 'signature/'.$myteacher->id.'.png?v=1.'.$nowversion;
                            $defaultpath1 = IMG_URL . 'signature/default.png';
                            if(remote_file_exists($imagepath1))
                            {
                                echo "<img class=\"sign-teacher middle\" src=\"$imagepath1\"/>\n";
                            }
                            else
                            {
                                echo "<img class=\"sign-teacher default\" src=\"$defaultpath1\"/>\n";
                            } 
                            ?>
                            <p>MUHAFIZH/AH</p>
                            <?php } else { ?>
                            <?php
                            $imagepath1 = IMG_URL . 'signature/3.png';
                            $defaultpath1 = IMG_URL . 'signature/default.png';
                            if(remote_file_exists($imagepath1))
                            {
                                echo "<img class=\"sign-teacher middle\" src=\"$imagepath1\"/>\n";
                            }
                            else
                            {
                                echo "<img class=\"sign-teacher default\" src=\"$defaultpath1\"/>\n";
                            } 
                            ?>
                            <p>KETUA BIDANG TAHFIDZ</p>
                            <?php } ?>
                        </div>
                        <div class="signature">
                            <?php 
                            if($clientcode == 'ymk' || $clientcode == 'ymn') {
                                if(isset($myteacher)) {
                                    echo $myteacher->name;
                                }    
                            } else {
                                if(isset($school->adm_sietahfizh)) {
                                    echo $school->adm_sietahfizh;
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
            <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="editmyraport();"><i class="fa fa-pencil-square-o" style="color: black"></i> Edit Raport</button>
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 no-print">
                <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('mark_sheet_instruction'); ?></div>
            </div>
        </div>
    </div>
</div>



<!-- Super admin js START  -->
 <script type="text/javascript">
        function editmyraport(){
            var type = "<?php echo $formtype; ?>";
            var code = "<?php echo $clientcode; ?>";
            var param = '?';
            
            var paramformat = '';
            if(code == 'ymk' || code == 'ymn'){
                var paramformat = '&format=surat';
            }
            
            if(type == 'tahfizh' || type == 'tahsin'){
                var p = $("#semester option:selected").val();
                param += 'p=SM'+p;
            } else {
                var l = $("#level option:selected").val();
                if(l != 0){
                    param += 'l='+l;
                } else {
                    param += 'l=1';
                }
                var p = $("#period option:selected").val();
                if(p != 0){
                    param += '&p='+p;
                } else {
                    param += '&p=Q1';
                }
            }

            var params = param + paramformat;
            <?php 
            $mytype = $formtype;
            if($formtype == 'tahsin'){
                $mytype = 'tahfizh';
            }
            ?>
            <?php $identity = $school_id.'/'.$academic_year_id.'/'.$class_id.'/'.$student_id; ?>
            var loc = "<?php echo site_url('exam/mark/form/'.$mytype.'/'.$identity); ?>";
            window.location = loc+params;
        }
    $("document").ready(function() {
        $('#student_id').select2({
            placeholder: 'Pilih Siswa',
            language: 'id',
        }); 
         <?php if(isset($school_id) && !empty($school_id) &&  $this->session->userdata('role_id') == SUPER_ADMIN){ ?>               
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var academic_year_id = '';
        var class_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            academic_year_id =  '<?php echo $academic_year_id; ?>';     
            class_id =  '<?php echo $class_id; ?>';           
         <?php } ?> 
           
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id, academic_year_id:academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#academic_year_id').html(response);  
                    get_class_by_school(school_id,class_id); 
               }
            }
        });
    }); 

   function get_class_by_school(school_id, class_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#class_id').html(response); 
               }
            }
        }); 
   }  
   
  </script>
<!-- Super admin js end -->


 <script type="text/javascript">     
    
    <?php if(isset($class_id)){ ?>
            get_student_by_class('<?php echo $class_id; ?>', '<?php echo $student_id; ?>', '<?php echo $formtype; ?>');
        <?php } ?>
        
        function get_student_by_class(class_id, student_id, formtype){       
            
            var school_id = $('#school_id').val();  
            if(!school_id){
               toastr.error('<?php echo $this->lang->line('select_school'); ?>');
               return false;
            } 
            $.ajax({       
                type   : "POST",
                url    : "<?php echo site_url('ajax/get_student_by_class'); ?>",
                data   : {school_id:school_id, class_id: class_id, student_id: student_id, formtype: formtype},               
                async  : false,
                success: function(response){                                                   
                   if(response)
                   {
                      $('#student_id').html(response);
                   }
                }
            });         
        }

    <?php if(isset($class_id) && isset($section_id)){ ?>
        <?php /* get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>'); */ ?>
    <?php } ?>
    
    function get_section_by_class(class_id, section_id){       
       
        var school_id = $('.fn_school_id').val();     
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : { school_id:school_id, class_id : class_id , section_id: section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#section_id').html(response);
               }
            }
        });         
    }
 
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_student_by_section('<?php echo $section_id; ?>', '<?php echo $student_id; ?>');
    <?php } ?>
    
    function get_student_by_section(section_id, student_id){       
        
        var school_id = $('#school_id').val();  
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        } 
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_student_by_section'); ?>",
            data   : {school_id:school_id, section_id: section_id, student_id: student_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                  $('#student_id').html(response);
               }
            }
        });         
    }
 
  $("#marksheet").validate();
$('#level').change(function(e){
    e.preventDefault();
    var l = this.value;
    if(l == "1" || l == "2")
        window.location = "?s=1&l="+l;
    /*$('#addmarkform').submit();*/
}); 
$('#semester').change(function(e){
    e.preventDefault();
    var s = this.value;
    if(s == "1" || s == "2" || s == "3" || s == "4") {
        <?php if($formtype == 'tahfizh' || $formtype == 'tahsin') { ?>
            window.location = "?s="+s+"&p=SM"+s;
        <?php } else { ?>
            var l = $("#level option:selected").val();
            window.location = "?s="+s+"&l="+l;
        <?php } ?>
    }
    
    /*$('#addmarkform').submit();*/
}); 
$('#period').change(function(e){
    e.preventDefault();
    var p = this.value;
    var s = $("#semester option:selected").val();
    var l = $("#level option:selected").val();
    if(p == "Q1" || p == "Q2"){
        s = 1;
        window.location = "?s="+s+"&l="+l+"&p="+p;
    } else if(p == "Q3" || p == "Q4") {
        s = 2;
        window.location = "?s="+s+"&l="+l+"&p="+p;
    }
    
    /*$('#addmarkform').submit();*/
}); 
$("#send").on("click", function(e){
    e.preventDefault();
    <?php if($this->session->userdata('role_id') == '1'){ ?>
        var school_id = $("#school_id option:selected").val();
    <?php } else if(isset($school_id)) { ?>
        var school_id = <?php echo $school_id; ?>;
    <?php } ?>

    var academic_year_id = $("#academic_year_id option:selected").val();
    var class_id = $("#class_id option:selected").val();
    //var section_id = $("#section_id option:selected").val();
    var student_id = $("#student_id option:selected").val();
    var fullurl = "<?php echo $form_url_s; ?>/"+school_id+"/"+academic_year_id+"/"+class_id+"/"+student_id+".html";
    $('#resultcard').attr('action', fullurl).submit();
});
</script>
<link href="<?php echo CSS_URL; ?>print.css" rel="stylesheet">