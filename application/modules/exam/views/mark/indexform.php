<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-file-text-o"></i><small> <?php echo $this->lang->line('manage_mark'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
               
            <div class="x_content quick-link">
                 <?php $this->load->view('quick-link-exam'); ?> 
            </div>      
            
            <?php 
                $url_bind = $school_id.'/'.$academic_year_id.'/'.$class_id.'/'.$section_id.'/'.$student_id; 
                $url_bind_s = $school_id.'/'.$academic_year_id.'/'.$class_id.'/'.$section_id; 
                $form_url = site_url('exam/mark/form/'.$formtype.'/'.$url_bind);
                $form_url_s = substr(site_url('exam/mark/form/'.$formtype.'/'.$url_bind_s), 0, -5);
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
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value,'');">
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
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?>  <span class="required">*</span></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id" required="required" onchange="get_student_by_section(this.value,'');">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>
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

           <?php  if (isset($students) && !empty($students)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-4  col-sm-offset-4 layout-box">
                        <p>
                            <h4><?php echo $this->lang->line('exam_mark'); ?></h4>                            
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
            <?php $url_bind = $students['school_id'].'/'.$students['academic_year_id'].'/'.$students['class_id'].'/'.$students['section_id'].'/'.$students['student_id']; 
            $form_url = site_url('exam/mark/form/'.$formtype.'/'.$url_bind);
            ?>
                 <?php echo form_open($form_url, array('name' => 'addmarkform', 'id' => 'addmarkform', 'class'=>'form-horizontal form-label-left'), ''); ?>
                 <input type="hidden" name="school_id" value="<?php echo $students['school_id']; ?>">
                  <input type="hidden" name="academic_year_id" value="<?php echo $students['academic_year_id']; ?>">
                  <input type="hidden" name="class_id" value="<?php echo $students['class_id']; ?>">
                  <input type="hidden" name="section_id" value="<?php echo $students['section_id']; ?>">
                  <input type="hidden" name="student_id" value="<?php echo $students['student_id']; ?>">
                <?php /*
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="item form-group">
                            <label  for="from_date_mark">Tanggal Awal Penilaian <span class="required">*</span></label>
                            <input  class="form-control col-md-7 col-xs-12"  name="from_date_mark"  id="add_from_date_mark" value="<?php echo isset($post['from_date_mark']) ?  $post['from_date_mark'] : ''; ?>" placeholder="Tanggal Awal Penilaian" required="required" type="text" autocomplete="off">
                            <div class="help-block"><?php echo form_error('from_date_mark'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="item form-group">
                            <label  for="to_date_mark">Tanggal Akhir Penilaian <span class="required">*</span></label>
                            <input  class="form-control col-md-7 col-xs-12"  name="to_date_mark"  id="add_to_date_mark" value="<?php echo isset($post['to_date_mark']) ?  $post['to_date_mark'] : ''; ?>" placeholder="Tanggal Akhir Penilaian" required="required" type="text" autocomplete="off">
                            <div class="help-block"><?php echo form_error('to_date_mark'); ?></div>
                        </div>
                    </div>
                </div> */ ?>
                <?php if($formtype == 'bpi') { ?>
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="item form-group">
                        <label for="level-choice">Pilih Level</label>
                        <select class="form-control" id="level" name="level">
                            <option>------</option>
                            <option <?php if(isset($_GET['l']) && $_GET['l'] == '1'){echo 'selected';} ?> value="1">Tingkat Dasar</option>
                            <option <?php if(isset($_GET['l']) && $_GET['l'] == '2'){echo 'selected';} ?> value="2">Tingkat Lanjut</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="item form-group">
                        <label for="period-choice">Pilih Period</label>
                            <select class="form-control" id="period" name="period">
                                <option>--------</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q1'){echo 'selected';} ?> value="Q1">Q1</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q2'){echo 'selected';} ?> value="Q2">Q2</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q3'){echo 'selected';} ?> value="Q3">Q3</option>
                                <option <?php if(isset($_GET['p']) && $_GET['p'] == 'Q4'){echo 'selected';} ?> value="Q4">Q4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php } else if ($formtype == 'tahfizh') { ?>
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="item form-group">
                        <label for="period-choice">Pilih Semester</label>
                        <select class="form-control" id="period2" name="period">
                            <option>------</option>
                            <option <?php if(isset($_GET['p']) && $_GET['p'] == 'SM1'){echo 'selected';} ?> value="SM1">Semester 1</option>
                            <option <?php if(isset($_GET['p']) && $_GET['p'] == 'SM2'){echo 'selected';} ?> value="SM2">Semester 2</option>
                        </select>
                        </div>
                    </div>
                </div>
                <?php } ?>
               
                <?php 
                if(!empty($_GET['p'])){ 
                ?>
                <?php if($formtype == 'bpi') { ?>
                <div id="bpi-form">
                    <h3>Mutabaah</h3>
                    <section>
                        <?php
                        // Kalkulasi Shalat Berjamaah 5 waktu
                        // Target 5x per hari
                        // atau 420x per Period (3bulan)
                        $mutapray5i = '';
                        if(isset($markvalues2['pray'])){
                            $pray5 = $markvalues2['pray'];
                            $mutapray5i = get_muta_score('pray', $pray5);
                        }

                        $mutadhuhai = '';
                        if(isset($markvalues2['dhuha'])){
                            $dhuha = $markvalues2['dhuha'];
                            $mutadhuhai = get_muta_score('dhuha', $dhuha);
                        }

                        $mutatilawahi = '';
                        if(isset($markvalues2['tilawah'])){
                            $tilawah = $markvalues2['tilawah'];
                            $mutatilawahi = get_muta_score('tilawah', $tilawah);
                        }

                        $mutaqiyami = '';
                        if(isset($markvalues2['qiyam'])){
                            $qiyam = $markvalues2['qiyam'];
                            $mutaqiyami = get_muta_score('qiyam', $qiyam);
                        }

                        $mutarawatibi = '';
                        if(isset($markvalues2['rawatib'])){
                            $rawatib = $markvalues2['rawatib'];
                            $mutarawatibi = get_muta_score('rawatib', $rawatib);
                        }

                        $mutadzikiri = '';
                        if(isset($markvalues2['dzikir'])){
                            $dzikir = $markvalues2['dzikir'];
                            $mutadzikiri = get_muta_score('dzikir', $dzikir);
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_pray">Shalat Berjamaah</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[pray]"  id="muta_pray" value="<?php echo isset($markvalues2['pray']) ?  $markvalues2['pray'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[pray]'); ?>" type="text" autocomplete="off">
                                    <?php echo $mutapray5i; ?>
                                    <div class="help-block"><?php echo form_error('indicator2[pray]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_tilawah">Tilawah/Murajaah Al Qur'an</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[tilawah]"  id="muta_tilawah" value="<?php echo isset($markvalues2['tilawah']) ?  $markvalues2['tilawah'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[tilawah]'); ?>" type="text" autocomplete="off">
                                    <?php echo $mutatilawahi; ?>
                                    <div class="help-block"><?php echo form_error('indicator2[tilawah]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_qiyam">Shalat Tahadjud/Qiyamullail</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[qiyam]"  id="muta_qiyam" value="<?php echo isset($markvalues2['qiyam']) ?  $markvalues2['qiyam'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[qiyam]'); ?>" type="text" autocomplete="off">
                                    <?php echo $mutaqiyami;?>
                                    <div class="help-block"><?php echo form_error('indicator2[qiyam]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_dhuha">Shalat Dhuha</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[dhuha]"  id="muta_dhuha" value="<?php echo isset($markvalues2['dhuha']) ?  $markvalues2['dhuha'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[dhuha]'); ?>" type="text" autocomplete="off">
                                    <?php echo $mutadhuhai;?>
                                    <div class="help-block"><?php echo form_error('indicator2[dhuha]'); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_rawatib">Shalat Rawatib</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[rawatib]"  id="muta_rawatib" value="<?php echo isset($markvalues2['rawatib']) ?  $markvalues2['rawatib'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[rawatib]'); ?>" type="text" autocomplete="off">
                                    <?php echo $mutarawatibi; ?>
                                    <div class="help-block"><?php echo form_error('indicator2[rawatib]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_dzikir">Dzikir Almatsurat</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[dzikir]"  id="muta_dzikir" value="<?php echo isset($markvalues2['dzikir']) ?  $markvalues2['dzikir'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[dzikir]'); ?>" type="text" autocomplete="off">
                                    <?php echo $mutadzikiri;?>
                                    <div class="help-block"><?php echo form_error('indicator2[dzikir]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_siyam">Puasa Sunnah</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[siyam]"  id="muta_siyam" value="<?php echo isset($markvalues2['siyam']) ?  $markvalues2['siyam'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[siyam]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[siyam]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_book">Membaca Buku Tematik</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[book]"  id="muta_book" value="<?php echo isset($markvalues2['book']) ?  $markvalues2['book'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[book]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[book]'); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_sedekah">Sedekat</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[sedekah]"  id="muta_sedekah" value="<?php echo isset($markvalues2['sedekah']) ?  $markvalues2['sedekah'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[sedekah]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[sedekah]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="meta_silat">Silaturrahim</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[silat]"  id="meta_silat" value="<?php echo isset($markvalues2['silat']) ?  $markvalues2['silat'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[silat]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[silat]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="muta_sport">Berolahraga</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[sport]"  id="muta_sport" value="<?php echo isset($markvalues2['sport']) ?  $markvalues2['sport'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[sport]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[sport]'); ?></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>Ketidakhadiran</h3>
                    <section>
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_present">Jumlah Pertemuan</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[present]"  id="abs_present" value="<?php echo isset($markvalues2['present']) ?  $markvalues2['present'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[present]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[present]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_sick">Sakit</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[sick]"  id="abs_sick" value="<?php echo isset($markvalues2['sick']) ?  $markvalues2['sick'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[sick]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[sick]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_permit">Izin</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[permit]"  id="abs_permit" value="<?php echo isset($markvalues2['permit']) ?  $markvalues2['permit'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[permit]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[permit]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_alpha">Alpha</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[alpha]"  id="abs_alpha" value="<?php echo isset($markvalues2['alpha']) ?  $markvalues2['alpha'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[alpha]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[alpha]'); ?></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>Karakter</h3>
                    <section>
                        <div id="bpi-indicator">
                            <?php 
                            if(!empty($characters)) {
                                foreach ($characters as $chara){
                                    echo '<h3><strong>'.$chara['name'].'</strong></h3>';
                                    if(!empty($chara['indicator'])){
                                        echo '<navigation>';
                                        $number = 1;
                                        foreach($chara['indicator'] as $indicator => $value){
                                            echo '<div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group indicator">';
                                            echo '<h5>'. $number . '. ' . $value.'</h5>';
                                            $onevalue = $twovalue = $threevalue = $fourvalue = '';
                                            $selected = 'checked';
                                            if(!empty($markvalues)){
                                                if($markvalues[$indicator] == 1){
                                                    $onevalue = $selected;
                                                } else if($markvalues[$indicator] == 2){
                                                    $twovalue = $selected;
                                                } else if($markvalues[$indicator] == 3){
                                                    $threevalue = $selected;
                                                } else if($markvalues[$indicator] == 4){
                                                    $fourvalue = $selected;
                                                }
                                            }
                                            echo 
                                            '<label class="radio-inline">
                                                <input type="radio" '.$onevalue.' name="indicator['.$indicator.']" value="1">1</label>
                                            <label class="radio-inline">
                                                <input type="radio" '.$twovalue.' name="indicator['.$indicator.']" value="2">2</label>
                                            <label class="radio-inline">
                                                <input type="radio" '.$threevalue.' name="indicator['.$indicator.']" value="3">3</label>
                                            <label class="radio-inline">
                                            <input type="radio" '.$fourvalue.' name="indicator['.$indicator.']" value="4">4</label>';
                                            
                                            echo '</div></div></div>';
                                            $number++;
                                        }
                                        echo '</navigation>';
                                    }
                                    
                                }
                            }
                            ?>
                        </div>

                        <div class="row char-note">
                            <div class="col-md-2">
                                <label for="char_note">Saran Perkembangan</label>  
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="item form-group">
                                    <textarea class="form-control col-md-2 col-xs-4"  name="indicator2[charnote]"  id="char_note" placeholder="<?php echo $this->lang->line('indicator2[charnote]'); ?>"  rows="3"><?php echo isset($markvalues2['charnote']) ?  $markvalues2['charnote'] : ''; ?></textarea>
                                    <div class="help-block"><?php echo form_error('indicator2[charnote]'); ?></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div> 
                <?php } else if($formtype == 'tahfizh') { ?>
                <div id="tahfizh-form">
                    <h3>Ujian Tahfizh</h3>
                    <section>
                        <div class="row">
                            <div class="col-md-12">
                                Pilih Surat, Ayat dan Isi Nilai dengan Angka
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <fieldset id="buildyourform">
                                    <?php echo $tahfizhvalues; ?>
                                </fieldset>
                                <input type="button" value="Tambah Materi Ujian" class="btn btn-dark" id="add" />
                            </div>
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <div class="item form-group">
                                    <label for="tahfizh_note">Catatan Tahfizh</label>
                                    <textarea class="form-control col-md-2 col-xs-4"  name="indicator2[tfnote]"  id="tahfizh_note" placeholder="<?php echo $this->lang->line('indicator2[tfnote]'); ?>"  rows="10"><?php echo isset($markvalues2['tfnote']) ?  $markvalues2['tfnote'] : ''; ?></textarea>
                                    <div class="help-block"><?php echo form_error('indicator2[tfnote]'); ?></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>Ujian Tahsin</h3>
                    <section>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="tahsin_fluent">Kelancaran</label>
                                <input  class="form-control col-md-2 col-xs-4"  name="indicator2[fluent]"  id="tahsin_fluent" value="<?php echo isset($markvalues2['fluent']) ?  $markvalues2['fluent'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[fluent]'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('indicator2[fluent]'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="tahsin_makhraj">Makhorijul Huruf</label>
                                <input  class="form-control col-md-2 col-xs-4"  name="indicator2[makhraj]"  id="tahsin_makhraj" value="<?php echo isset($markvalues2['makhraj']) ?  $markvalues2['makhraj'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[makhraj]'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('indicator2[makhraj]'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="tahsin_tajwid">Tajwid</label>
                                <input  class="form-control col-md-2 col-xs-4"  name="indicator2[tajwid]"  id="tahsin_tajwid" value="<?php echo isset($markvalues2['tajwid']) ?  $markvalues2['tajwid'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[tajwid]'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('indicator2[tajwid]'); ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group">
                                <label for="tahsin_lastread">Bacaan Terakhir</label>
                                <input  class="form-control col-md-2 col-xs-4"  name="indicator2[lastread]"  id="tahsin_lastread" value="<?php echo isset($markvalues2['lastread']) ?  $markvalues2['lastread'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[lastread]'); ?>" type="text" autocomplete="off">
                                <div class="help-block"><?php echo form_error('indicator2[lastread]'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="item form-group">
                                <label for="tahsin_note">Catatan Tahsin</label>
                                <textarea class="form-control col-md-2 col-xs-4"  name="indicator2[note]"  id="tahsin_note" placeholder="<?php echo $this->lang->line('indicator2[note]'); ?>"  rows="10"><?php echo isset($markvalues2['note']) ?  $markvalues2['note'] : ''; ?></textarea>
                                <div class="help-block"><?php echo form_error('indicator2[note]'); ?></div>
                            </div>
                        </div>
                    </div>
                    </section>
                    <h3>Ketidakhadiran</h3>
                    <section>
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_present">Jumlah Pertemuan</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[present]"  id="abs_present" value="<?php echo isset($markvalues2['present']) ?  $markvalues2['present'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[present]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[present]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_sick">Sakit</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[sick]"  id="abs_sick" value="<?php echo isset($markvalues2['sick']) ?  $markvalues2['sick'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[sick]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[sick]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_permit">Izin</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[permit]"  id="abs_permit" value="<?php echo isset($markvalues2['permit']) ?  $markvalues2['permit'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[permit]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[permit]'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="item form-group">
                                    <label for="abs_alpha">Alpha</label>
                                    <input  class="form-control col-md-2 col-xs-4"  name="indicator2[alpha]"  id="abs_alpha" value="<?php echo isset($markvalues2['alpha']) ?  $markvalues2['alpha'] : ''; ?>" placeholder="<?php echo $this->lang->line('indicator2[alpha]'); ?>" type="text" autocomplete="off">
                                    <div class="help-block"><?php echo form_error('indicator2[alpha]'); ?></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div> 
                <?php } ?>

                <div class="row submit-mark-button">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group text-right">
                            <input type="submit" id="submit" class="btn btn-custom btn-success btn-lg" name="submit" value="Kirim Nilai">
                        </div>
                    </div>
                </div>

                <?php
                }
                ?>

                 <?php echo form_close(); ?>

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('exam_mark_instruction'); ?></div>
                </div>
            </div> 
            
        </div>
    </div>
</div>
<style>
#datatable-responsive label.error{display: none !important;}
</style>
<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
<link href="<?php echo CSS_URL; ?>jquery.steps.css" rel="stylesheet">
<script src="<?php echo JS_URL; ?>jquery.steps.min.js"></script>

<!-- Super admin js START  -->
<script type="text/javascript">
$(document).ready(function() {
    var fOption = "<?php echo $thesurat; ?>";
    
    <?php if(!empty($tahfizhvalues)) {?>
        $(".remove").click(function() {
            $(this).parent().remove();
        });
        $('select[id^="thesurat"]').select2({
            placeholder: 'Pilih Surat',
            language: 'id',
            width: 'resolve'
        }); 
        var lastField = $("#buildyourform div:last");
        lastField.data("idx", <?php echo $tahfizhlastfields; ?>);
    <?php } ?>
    $("#add").click(function() {
    	var lastField = $("#buildyourform div:last");
        var intId = (lastField && lastField.length && lastField.data("idx") + 1 ) || 1;
        var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
        fieldWrapper.data("idx", intId);
        var fCol = $("<div class='col-md-3' />");
        var fName = $("<input name=\"ayat["+intId+"][]\" type=\"text\" class=\"fieldname form-control\" placeholder=\"Ayat\" />");
        var fType = $("<select id=\"thesurat"+intId+"\" name=\"thesurat["+intId+"][]\" class=\"fieldtype form-control\">"+fOption+"</select>");
        var fMark = $("<input name=\"mark["+intId+"][]\" type=\"text\" class=\"fieldname form-control\" placeholder=\"Nilai\" />");
        var removeButton = $("<input type=\"button\" class=\"remove\" value=\"-\" />");
        removeButton.click(function() {
            $(this).parent().remove();
        });
        fieldWrapper.append(fType);
        fieldWrapper.append(fName);
        fieldWrapper.append(fMark);
        fieldWrapper.append(removeButton);
        $("#buildyourform").append(fieldWrapper);
        $('select[id^="thesurat"]').select2({
            placeholder: 'Pilih Surat',
            language: 'id',
            width: 'resolve'
        }); 
    });
    $("#preview").click(function() {
        $("#yourform").remove();
        var fieldSet = $("<fieldset id=\"yourform\"><legend>Your Form</legend></fieldset>");
        $("#buildyourform div").each(function() {
            var id = "input" + $(this).attr("id").replace("field","");
            var label = $("<label for=\"" + id + "\">" + $(this).find("input.fieldname").first().val() + "</label>");
            var input;
            switch ($(this).find("select.fieldtype").first().val()) {
                case "checkbox":
                    input = $("<input type=\"checkbox\" id=\"" + id + "\" name=\"" + id + "\" />");
                    break;
                case "textbox":
                    input = $("<input type=\"text\" id=\"" + id + "\" name=\"" + id + "\" />");
                    break;
                case "textarea":
                    input = $("<textarea id=\"" + id + "\" name=\"" + id + "\" ></textarea>");
                    break;    
            }
            fieldSet.append(label);
            fieldSet.append(input);
        });
        $("body").append(fieldSet);
    });
});

        $("#bpi-form").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            cssClass: "tabcontrol"
        });

        $("#tahfizh-form").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            cssClass: "tabcontrol"
        });

        $("#bpi-indicator").steps({
            headerTag: "h3",
            bodyTag: "navigation",
            transitionEffect: "slideLeft",
            stepsOrientation: "vertical",
            enableAllSteps: true,
            enableFinishButton: false,
            enablePagination: false,
        });
        $("document").ready(function() {
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
      
        <?php if(isset($class_id) && isset($section_id)){ ?>
            get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
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
    $('#period2').change(function(){
        var p = this.value;
        window.location = "<?php echo $form_url; ?>?p="+p;
        /*$('#addmarkform').submit();*/
    });
    $('#level').change(function(){
        var l = this.value;
        window.location = "<?php echo $form_url; ?>?p=Q1&l="+l;
        /*$('#addmarkform').submit();*/
    });
    $('#period').change(function(){
        var l = $("#level option:selected").val();
        var p = this.value;
        window.location = "<?php echo $form_url; ?>?p="+p+"&l="+l;
        /*$('#addmarkform').submit();*/
    });
    $("#send").on("click", function(e){
        e.preventDefault();
        var student_id = $("#student_id option:selected").val();
        var fullurl = "<?php echo $form_url_s; ?>/"+student_id+".html?p=Q1&l=1";
        $('#resultcard').attr('action', fullurl).submit();
    });
    
</script>
<style>
.select2-container {
    float: left; 
    width: 50% !important;
}
.select2-container .select2-selection--single {
    height: 35px;
    margin-top: 5px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 6px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 32px;
}

fieldset
{
    padding:10px;
    display:block;
    clear:both;
    margin:5px 0px;
}
legend
{
    padding:0px 10px;
    background:black;
    color:#FFF;
}
input.add
{
    float:right;
}
.fieldwrapper {
    clear: left;
}
input.fieldname
{
    float:left;
    display:block;
    margin:5px;
    width: 80px;
}
select.fieldtype
{
    float:left;
    display:block;
    margin:5px;
}
input.remove
{
    float:left;
    display:block;
    margin:5px;
}
#yourform label
{
    float:left;
    clear:left;
    display:block;
    margin:5px;
}
#yourform input, #yourform textarea
{
    float:left;
    display:block;
    margin:5px;
}
</style>