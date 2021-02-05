<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-check-square-o"></i><small> <?php echo $this->lang->line('student'); ?> <?php echo $this->lang->line('tahfizh'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content"> 
                <?php echo form_open_multipart(site_url('tahfizh/student/index'), array('name' => 'student', 'id' => 'student', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">
                    
                    <?php $this->load->view('layout/school_list_filter'); ?>
                    
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('class'); ?>  <span class="required">*</span></div>
                            <?php $teacher_access_data = get_teacher_access_data('student'); ?>
                            <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class(this.value, '');">
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                <?php foreach ($classes as $obj) { ?>
                                    <?php if(isset($classes) && !empty($classes)) { ?>
                                    <?php if($this->session->userdata('role_id') == TEACHER && !in_array($obj->id, $teacher_access_data)){ continue; } ?>   
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                        </div>
                    </div>
                    <?php /*
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div> */ ?>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group">  
                            <div><?php echo $this->lang->line('date'); ?> <span class="required">*</span></div>
                            <input  class="form-control col-md-7 col-xs-12"  name="date"  id="date" value="<?php if(isset($date)){ echo $date;} ?>" placeholder="<?php echo $this->lang->line('date'); ?>" required="required" type="text" autocomplete="off">
                            <div class="help-block"><?php echo form_error('date'); ?></div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
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
                            <h4><?php echo $this->lang->line('deposit'); ?></h4>
                            <?php echo $this->lang->line('day'); ?> : <?php echo date('l', strtotime($date)); ?><br/>
                            <?php echo $this->lang->line('date'); ?> : <?php echo date('d M Y', strtotime($date)); ?><?php //echo date($this->gsms_setting->sms_date_format, strtotime($date)); ?>
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content x_apps">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?></th>
                            <?php /*
                            <th><?php echo $this->lang->line('photo'); ?></th>
                            <th><?php echo $this->lang->line('email'); ?></th>
                            <th><?php echo $this->lang->line('phone'); ?></th>
                            <th><?php echo $this->lang->line('roll_no'); ?></th>
                            */ ?>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <?php /*
                            <th><input type="checkbox" value="Z" name="present" id="fn_present" class="fn_all_attendnce"/> <?php echo $this->lang->line('ziyadah'); ?></th>                                            
                            <th><input type="checkbox" value="M" name="late" id="fn_late"  class="fn_all_attendnce"/> <?php echo $this->lang->line('repetition'); ?></th>                                            
                            <th><input type="checkbox" value="A" name="absent" id="fn_absent"  class="fn_all_attendnce"/> <?php echo $this->lang->line('absent_all'); ?></th>                                            
                            */ ?>
                            </tr>
                    </thead>
                    <tbody id="fn_attendance">   
                        <?php
                        $count = 1;
                        if (isset($students) && !empty($students)) {
                            ?>
                            <?php foreach ($students as $obj) { ?>
                            <?php  $attendance = get_student_tahfizh($obj->id, $school_id, $academic_year_id, $class_id, $section_id, $year, $month, $day ); 

                            $getdata = json_decode($attendance);
                            $tahfizhm_type = '';
                            $tahfizhm_shaff = '';
                            $tahfizhm_shaff_o = '';
                            $tahfizhm_shaff_note = '';
                            $tahfizhm_shaff_score = '';

                            $tahfizhl_type = '';
                            $tahfizhl_shaff = '';
                            $tahfizhl_shaff_o = '';
                            $tahfizhl_shaff_note = '';
                            $tahfizhl_shaff_score = '';

                            $tahfizhz_type = '';
                            $tahfizhz_shaff = '';
                            $tahfizhz_shaff_o = '';
                            $tahfizhz_shaff_note = '';
                            $tahfizhz_shaff_score = '';

                            $rawatib_subuh = '';
                            $rawatib_dzuhur = '';
                            $rawatib_ashar = '';
                            $rawatib_maghrib = '';
                            $rawatib_isya = '';
                            $qiyam = '';
                            $nabung = '';
                            $dhuha = '';
                            $siyam = '';
                            $infaq = '';
                            
                            foreach($getdata as $gda){

                                if($gda->type == "M"){
                                    $tahfizhm_type = !empty($gda->type) ? $gda->type : "";
                                    $tahfizhm_shaff = !empty($gda->shaff) ? $gda->shaff : "";
                                    $tahfizhm_shaff_o = !empty($gda->shaffo) ? $gda->shaffo : "";
                                    $tahfizhm_shaff_note = !empty($gda->shaffn) ? $gda->shaffn : "";
                                    $tahfizhm_shaff_score = !empty($gda->shaffs) ? $gda->shaffs : "";
                                }

                                if($gda->type == "L"){
                                    $tahfizhl_type = !empty($gda->type) ? $gda->type : "";
                                    $tahfizhl_shaff = !empty($gda->shaff) ? $gda->shaff : "";
                                    $tahfizhl_shaff_o = !empty($gda->shaffo) ? $gda->shaffo : "";
                                    $tahfizhl_shaff_note = !empty($gda->shaffn) ? $gda->shaffn : "";
                                    $tahfizhl_shaff_score = !empty($gda->shaffs) ? $gda->shaffs : "";
                                }

                                if($gda->type == "Z"){
                                    $tahfizhz_type = !empty($gda->type) ? $gda->type : "";
                                    $tahfizhz_shaff = !empty($gda->shaff) ? $gda->shaff : "";
                                    $tahfizhz_shaff_o = !empty($gda->shaffo) ? $gda->shaffo : "";
                                    $tahfizhz_shaff_note = !empty($gda->shaffn) ? $gda->shaffn : "";
                                    $tahfizhz_shaff_score = !empty($gda->shaffs) ? $gda->shaffs : "";
                                }

                                
                                if($gda->type == "shu"){
                                    $rawatib_subuh = $gda->val;
                                }

                                if($gda->type == "dzu"){
                                    $rawatib_dzuhur = $gda->val;
                                }

                                if($gda->type == "ash"){
                                    $rawatib_ashar = $gda->val;
                                }

                                if($gda->type == "mag"){
                                    $rawatib_maghrib = $gda->val;
                                }

                                if($gda->type == "isy"){
                                    $rawatib_isya = $gda->val;
                                }

                                if($gda->type == "dhu"){
                                    $dhuha = $gda->val;
                                }

                                if($gda->type == "qiy"){
                                    $qiyam = $gda->val;
                                }

                                if($gda->type == "siy"){
                                    $siyam = $gda->val;
                                }

                                if($gda->type == "inf"){
                                    $infaq = $gda->val;
                                }

                                if($gda->type == "nab"){
                                    $nabung = $gda->val;
                                }
                                    
                                
                            }
                            
                            ?>
                                <tr>
                                    <td><?php echo $count++;  ?></td>
                                    <td><?php echo ucfirst($obj->name); ?></td>
                                    <?php /*
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="60" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="60" /> 
                                        <?php } ?>
                                    </td>  
                                    
                                    <td><?php echo $obj->email; ?></td>
                                    <td><?php echo $obj->phone; ?></td>
                                    <td><?php echo $obj->roll_no; ?></td>
                                    */ ?>
                                    <td>
                                        <div id="shaff_type_<?php echo $obj->id; ?>" class="table-responsive">
                                            <div class="row noMargin">
                                                <div class="col-md-12">
                                                    <div class="radio col-xs-12">
                                                        <label class="col-xs-6" for="Present"> 
                                                            <input type="radio" value="P" itemid="<?php echo $obj->id; ?>" name="student_<?php echo $obj->id; ?>" id="student_<?php echo $obj->id; ?>" class="present form-check-input fn_single_attendnce" <?php if($tahfizhm_type == 'M' || $tahfizhz_type == 'Z' ){ echo 'checked="checked"'; } ?> />&nbsp;<b>Setoran</b>
                                                        </label>
                                                        <label class="col-xs-6" for="Absent"> 
                                                            <input type="radio" value="A" itemid="<?php echo $obj->id; ?>" name="student_<?php echo $obj->id; ?>" id="student_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($tahfizh_type == 'A'){ echo 'checked="checked"'; } ?> />&nbsp;<b>Tidak Setoran</b>
                                                        </label>
                                                    </div>

                                                    <fieldset class="group_tahfizh col-xs-12" id="group_tahfizh_<?php echo $obj->id; ?>" style="<?php if($tahfizhm_type == 'M' || $tahfizhz_type == 'Z' || $tahfizhl_type == 'L') echo 'display:block'; else echo 'display:none' ?>">
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-4">
                                                                <div class="checkbox">
                                                                    <label for="Ziyadah"> 
                                                                        <input type="checkbox" value="Z" itemid="<?php echo $obj->id; ?>" name="tahfizhz_<?php echo $obj->id; ?>" id="tahfizhz_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($tahfizhz_type == 'Z'){ echo 'checked="checked"'; } ?> />&nbsp;&nbsp; Tambah Ziyadah
                                                                    </label>
                                                                </div>
                                                                <div id="detail_shaffz_<?php echo $obj->id; ?>" style="<?php if($tahfizhz_type == 'Z') echo 'display:block'; else echo 'display:none' ?>">
                                                                    <select class="form-control" itemid="<?php echo $obj->id; ?>" id="shaffz_<?php echo $obj->id; ?>" name="shaffz_<?php echo $obj->id; ?>">
                                                                        <option value="">Jumlah Ziyadah</option>
                                                                        <option value="0.3" <?php if($tahfizhz_shaff == '0.3') echo 'selected';?>>1/3 Halaman</option>
                                                                        <option value="0.5" <?php if($tahfizhz_shaff == '0.5') echo 'selected';?>>1/2 Halaman</option>
                                                                        <option value="1" <?php if($tahfizhz_shaff == '1') echo 'selected';?>>1 Halaman</option>
                                                                        <option value="1.3" <?php if($tahfizhz_shaff == '1.3') echo 'selected';?>>1 1/3 Halaman</option>
                                                                        <option value="1.5" <?php if($tahfizhz_shaff == '1.5') echo 'selected';?>>1 1/2 Halaman</option>
                                                                        <option value="2" <?php if($tahfizhz_shaff == '2') echo 'selected';?>>2 Halaman</option>
                                                                        <option value="O" <?php if($tahfizhz_shaff == 'O') echo 'selected';?>>Lainnya</option>
                                                                    </select>
                                                                    <div id="shaffz_other_<?php echo $obj->id; ?>" style="<?php if($tahfizhz_shaff == 'O') echo 'display:block'; else echo 'display:none'?>">
                                                                        <input class="form-control" type="text" id="shaffz_o_<?php echo $obj->id; ?>" name="shaffz_o_<?php echo $obj->id; ?>" value="<?php if(!empty($tahfizhz_shaff_o)) echo $tahfizhz_shaff_o;?>" style='width:45px'/> Halaman
                                                                    </div>
                                                                    <div class="shaffz_note">
                                                                    <label for="shaffz_note_<?php echo $obj->id; ?>">Catatan:</label>  
                                                                    <textarea  class="shaffz_note_textarea form-control" id="shaffz_note_<?php echo $obj->id; ?>" name="shaffz_note_<?php echo $obj->id; ?>" /><?php if(!empty($tahfizhz_shaff_note)) echo $tahfizhz_shaff_note;?></textarea>
                                                                    <select class="form-control" itemid="<?php echo $obj->id; ?>" id="shaffz_score_<?php echo $obj->id; ?>" name="shaffz_score_<?php echo $obj->id; ?>">
                                                                        <option value="">Nilai</option>
                                                                        <option value="A+" <?php if($tahfizhz_shaff_score == 'A+') echo 'selected';?>>A+ (Mumtaz-Sempurna)</option>
                                                                        <option value="A" <?php if($tahfizhz_shaff_score == 'A') echo 'selected';?>>A (Jayyid Jiddan-Baik Sekali)</option>
                                                                        <option value="B" <?php if($tahfizhz_shaff_score == 'B') echo 'selected';?>>B (Jayyid-Baik)</option>
                                                                        <option value="C" <?php if($tahfizhz_shaff_score == 'C') echo 'selected';?>>C (Maqbul-Cukup)</option>
                                                                        <option value="D" <?php if($tahfizhz_shaff_score == 'D') echo 'selected';?>>D(Naqis-Kurang Baik)</option>
                                                                        <option value="E" <?php if($tahfizhz_shaff_score == 'E') echo 'selected';?>>E (Dhoif-Lemah)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12 col-md-4">
                                                                <div class="checkbox">
                                                                    <label for="Murajaah"> 
                                                                        <input type="checkbox" value="M" itemid="<?php echo $obj->id; ?>" name="tahfizhm_<?php echo $obj->id; ?>" id="tahfizhm_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($tahfizhm_type == 'M'){ echo 'checked="checked"'; } ?> />&nbsp;&nbsp; Tambah Murajaah Sabaqi
                                                                    </label>
                                                                </div>
                                                                
                                                                <div class="form-group" id="detail_shaffm_<?php echo $obj->id; ?>" style="<?php if($tahfizhm_type == 'M') echo 'display:block'; else echo 'display:none' ?>">
                                                                    <select class="form-control" itemid="<?php echo $obj->id; ?>" id="shaffm_<?php echo $obj->id; ?>" name="shaffm_<?php echo $obj->id; ?>">
                                                                        <option value="">Jumlah Murajaah</option>
                                                                        <option value="0.3" <?php if($tahfizhm_shaff == '0.3') echo 'selected';?>>1/3 Halaman</option>
                                                                        <option value="0.5" <?php if($tahfizhm_shaff == '0.5') echo 'selected';?>>1/2 Halaman</option>
                                                                        <option value="1" <?php if($tahfizhm_shaff == '1') echo 'selected';?>>1 Halaman</option>
                                                                        <option value="1.3" <?php if($tahfizhm_shaff == '1.3') echo 'selected';?>>1 1/3 Halaman</option>
                                                                        <option value="1.5" <?php if($tahfizhm_shaff == '1.5') echo 'selected';?>>1 1/2 Halaman</option>
                                                                        <option value="2" <?php if($tahfizhm_shaff == '2') echo 'selected';?>>2 Halaman</option>
                                                                        <option value="O" <?php if($tahfizhm_shaff == 'O') echo 'selected';?>>Lainnya</option>
                                                                    </select>
                                                                    <div id="shaffm_other_<?php echo $obj->id; ?>" style="<?php if($tahfizhm_shaff == 'O') echo 'display:block'; else echo 'display:none'?>">
                                                                        <input class="form-control" type="text" id="shaffm_o_<?php echo $obj->id; ?>" name="shaffm_o_<?php echo $obj->id; ?>" value="<?php if(!empty($tahfizhm_shaff_o)) echo $tahfizhm_shaff_o;?>" style='width:45px'/> Halaman
                                                                    </div>
                                                                    <div class="shaffm_note">
                                                                        <label for="shaffm_note_<?php echo $obj->id; ?>">Catatan:</label>  
                                                                        <textarea class="shaffm_note_textarea form-control" id="shaffm_note_<?php echo $obj->id; ?>" name="shaffm_note_<?php echo $obj->id; ?>" /><?php if(!empty($tahfizhm_shaff_note)) echo $tahfizhm_shaff_note;?></textarea>
                                                                        
                                                                        <select class="form-control" itemid="<?php echo $obj->id; ?>" id="shaffm_score_<?php echo $obj->id; ?>" name="shaffm_score_<?php echo $obj->id; ?>">
                                                                            <option value="">Nilai</option>
                                                                            <option value="A+" <?php if($tahfizhm_shaff_score == 'A+') echo 'selected';?>>A+ (Mumtaz-Sempurna)</option>
                                                                            <option value="A" <?php if($tahfizhm_shaff_score == 'A') echo 'selected';?>>A (Jayyid Jiddan-Baik Sekali)</option>
                                                                            <option value="B" <?php if($tahfizhm_shaff_score == 'B') echo 'selected';?>>B (Jayyid-Baik)</option>
                                                                            <option value="C" <?php if($tahfizhm_shaff_score == 'C') echo 'selected';?>>C (Maqbul-Cukup)</option>
                                                                            <option value="D" <?php if($tahfizhm_shaff_score == 'D') echo 'selected';?>>D(Naqis-Kurang Baik)</option>
                                                                            <option value="E" <?php if($tahfizhm_shaff_score == 'E') echo 'selected';?>>E (Dhoif-Lemah)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12 col-md-4">
                                                                <?php if($clientcode == 'ymk') { ?>
                                                                <div class="checkbox">
                                                                    <label for="Murajaah"> 
                                                                        <input type="checkbox" value="L" itemid="<?php echo $obj->id; ?>" name="tahfizhl_<?php echo $obj->id; ?>" id="tahfizhl_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($tahfizhl_type == 'L'){ echo 'checked="checked"'; } ?> />&nbsp;&nbsp; Tambah Murajaah Manzil
                                                                    </label>
                                                                </div>
                                                                
                                                                <div class="form-group" id="detail_shaffl_<?php echo $obj->id; ?>" style="<?php if($tahfizhl_type == 'L') echo 'display:block'; else echo 'display:none' ?>">
                                                                    <select class="form-control" itemid="<?php echo $obj->id; ?>" id="shaffl_<?php echo $obj->id; ?>" name="shaffl_<?php echo $obj->id; ?>">
                                                                        <option value="">Jumlah Murajaah</option>
                                                                        <option value="0.3" <?php if($tahfizhl_shaff == '0.3') echo 'selected';?>>1/3 Halaman</option>
                                                                        <option value="0.5" <?php if($tahfizhl_shaff == '0.5') echo 'selected';?>>1/2 Halaman</option>
                                                                        <option value="1" <?php if($tahfizhl_shaff == '1') echo 'selected';?>>1 Halaman</option>
                                                                        <option value="1.3" <?php if($tahfizhl_shaff == '1.3') echo 'selected';?>>1 1/3 Halaman</option>
                                                                        <option value="1.5" <?php if($tahfizhl_shaff == '1.5') echo 'selected';?>>1 1/2 Halaman</option>
                                                                        <option value="2" <?php if($tahfizhl_shaff == '2') echo 'selected';?>>2 Halaman</option>
                                                                        <option value="O" <?php if($tahfizhl_shaff == 'O') echo 'selected';?>>Lainnya</option>
                                                                    </select>
                                                                    <div id="shaffl_other_<?php echo $obj->id; ?>" style="<?php if($tahfizhl_shaff == 'O') echo 'display:block'; else echo 'display:none'?>">
                                                                        <input class="form-control" type="text" id="shaffl_o_<?php echo $obj->id; ?>" name="shaffl_o_<?php echo $obj->id; ?>" value="<?php if(!empty($tahfizhl_shaff_o)) echo $tahfizhl_shaff_o;?>" style='width:45px'/> Halaman
                                                                    </div>
                                                                    <div class="shaffl_note">
                                                                        <label for="shaffl_note_<?php echo $obj->id; ?>">Catatan:</label>  
                                                                        <textarea class="shaffl_note_textarea form-control" id="shaffl_note_<?php echo $obj->id; ?>" name="shaffl_note_<?php echo $obj->id; ?>" /><?php if(!empty($tahfizhl_shaff_note)) echo $tahfizhl_shaff_note;?></textarea>
                                                                        
                                                                        <select class="form-control" itemid="<?php echo $obj->id; ?>" id="shaffl_score_<?php echo $obj->id; ?>" name="shaffl_score_<?php echo $obj->id; ?>">
                                                                            <option value="">Nilai</option>
                                                                            <option value="A+" <?php if($tahfizhl_shaff_score == 'A+') echo 'selected';?>>A+ (Mumtaz-Sempurna)</option>
                                                                            <option value="A" <?php if($tahfizhl_shaff_score == 'A') echo 'selected';?>>A (Jayyid Jiddan-Baik Sekali)</option>
                                                                            <option value="B" <?php if($tahfizhl_shaff_score == 'B') echo 'selected';?>>B (Jayyid-Baik)</option>
                                                                            <option value="C" <?php if($tahfizhl_shaff_score == 'C') echo 'selected';?>>C (Maqbul-Cukup)</option>
                                                                            <option value="D" <?php if($tahfizhl_shaff_score == 'D') echo 'selected';?>>D(Naqis-Kurang Baik)</option>
                                                                            <option value="E" <?php if($tahfizhl_shaff_score == 'E') echo 'selected';?>>E (Dhoif-Lemah)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        
                                                    </fieldset>             
                                                    <?php if($clientcode == 'ymk') { ?>
                                                    <div id="mutabaah_<?php echo $obj->id; ?>">
                                                        <div class="form-row top-border">
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="dhu_<?php echo $obj->id; ?>">Dhuha</label>
                                                                <input type="text" name="dhu_<?php echo $obj->id; ?>" class="form-control" id="dhu_<?php echo $obj->id; ?>" placeholder="Rakaat" value="<?php echo (!empty($dhuha)?$dhuha:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="qiy_<?php echo $obj->id; ?>">Qiyam</label>
                                                                <input type="text" name="qiy_<?php echo $obj->id; ?>" class="form-control" id="qiy_<?php echo $obj->id; ?>" placeholder="Rakaat" value="<?php echo (!empty($qiyam)?$qiyam:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="siy_<?php echo $obj->id; ?>">Shiyam</label>
                                                                <input type="text" name="siy_<?php echo $obj->id; ?>" class="form-control" id="siy_<?php echo $obj->id; ?>" placeholder="" value="<?php echo (!empty($siyam)?$siyam:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="inf_<?php echo $obj->id; ?>">Infaq</label>
                                                                <input type="text" name="inf_<?php echo $obj->id; ?>" class="form-control" id="inf_<?php echo $obj->id; ?>" placeholder="Rupiah" value="<?php echo (!empty($infaq)?$infaq:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="nab_<?php echo $obj->id; ?>">Nabung</label>
                                                                <input type="text" name="nab_<?php echo $obj->id; ?>" class="form-control" id="nab_<?php echo $obj->id; ?>" placeholder="Rupiah" value="<?php echo (!empty($nabung)?$nabung:'0') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-row top-border">
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="raw_<?php echo $obj->id; ?>">Rwtb. Shubuh</label>
                                                                <input type="text" name="shu_<?php echo $obj->id; ?>" class="form-control" id="shu_<?php echo $obj->id; ?>" placeholder="Rakaat" value="<?php echo (!empty($rawatib_subuh)?$rawatib_subuh:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="raw_<?php echo $obj->id; ?>">Rwtb. Dzuhur</label>
                                                                <input type="text" name="dzu_<?php echo $obj->id; ?>" class="form-control" id="dzu_<?php echo $obj->id; ?>" placeholder="Rakaat" value="<?php echo (!empty($rawatib_dzuhur)?$rawatib_dzuhur:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="raw_<?php echo $obj->id; ?>">Rwtb. Ashar</label>
                                                                <input type="text" name="ash_<?php echo $obj->id; ?>" class="form-control" id="ash_<?php echo $obj->id; ?>" placeholder="Rakaat" value="<?php echo (!empty($rawatib_ashar)?$rawatib_ashar:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="raw_<?php echo $obj->id; ?>">Rwtb. Maghrib</label>
                                                                <input type="text" name="mag_<?php echo $obj->id; ?>" class="form-control" id="mag_<?php echo $obj->id; ?>" placeholder="Rakaat" value="<?php echo (!empty($rawatib_maghrib)?$rawatib_maghrib:'0') ?>">
                                                            </div>
                                                            <div class="col-xs-6 col-sm-2 col-md-2 mb-1">
                                                                <label for="raw_<?php echo $obj->id; ?>">Rwtb. Isya</label>
                                                                <input type="text" name="isy_<?php echo $obj->id; ?>" class="form-control" id="isy_<?php echo $obj->id; ?>" placeholder="Rakaat" value="<?php echo (!empty($rawatib_isya)?$rawatib_isya:'0') ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>     
                                            </div>   
                                        </div>
                                    
                                    </td>
                                    <td>
                                        <input type="submit" value="SIMPAN" class="form-control btn-success" itemid="<?php echo $obj->id; ?>" name="submit_tahfizh_<?php echo $obj->id; ?>">
                                    </td>
                                    <?php /*
                                    <td><input type="radio" value="Z" itemid="<?php echo $obj->id; ?>" name="student_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($attendance == 'Z'){ echo 'checked="checked"'; } ?> /></td>
                                    <td><input type="radio" value="M" itemid="<?php echo $obj->id; ?>"  name="student_<?php echo $obj->id; ?>" class="late fn_single_attendnce" <?php if($attendance == 'M'){ echo 'checked="checked"'; } ?>/></td>
                                    <td><input type="radio" value="A" itemid="<?php echo $obj->id; ?>" name="student_<?php echo $obj->id; ?>" class="absent fn_single_attendnce" <?php if($attendance == 'A'){ echo 'checked="checked"'; } ?>/></td>
                                    */ ?>
                                    </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr>
                                    <td colspan="9" align="center"><?php echo $this->lang->line('no_data_found'); ?></td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div> 
            
        </div>
    </div>
</div>


 <!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>

 <!-- Super admin js START  -->
 <script type="text/javascript">
         
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id) && $this->session->userdata('role_id') != TEACHER){ ?>
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();        
        var class_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            class_id =  '<?php echo $class_id; ?>';
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
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
    }); 

  </script>
<!-- Super admin js end -->

 <script type="text/javascript">
     
  $('#date').datepicker();
  
    <?php if(isset($class_id) && isset($section_id)){ ?>
        get_section_by_class('<?php echo $class_id; ?>', '<?php echo $section_id; ?>');
    <?php } ?>
    
    function get_section_by_class(class_id, section_id){    

        var school_id = $('#school_id').val();  

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
  
  $(document).ready(function(){

    $('.fn_single_attendnce').click(function(){
           var status     = $(this).prop('checked') ? $(this).val() : '';
           var student_id = $(this).attr('itemid');
           if(status == 'A'){
            $("#detail_shaff_"+student_id).hide();
            $("#group_tahfizh_"+student_id).hide();
            $("input[name='tahfizh_"+student_id+"']").prop('disabled', true);
           } else {
            $("#detail_shaff_"+student_id).show();
            $("#group_tahfizh_"+student_id).show();
            $("input[name='tahfizh_"+student_id+"']").prop('disabled', false);
           }
           
    }); 

    $("[name^='tahfizhm_']").on('change', function() {
        var status     = $(this).prop('checked') ? $(this).val() : '';
        var itemid = $(this).attr('itemid');
        if (status === "M"){
            $("#detail_shaffm_"+itemid).show();
        } else {
            $("#detail_shaffm_"+itemid).hide();
        }
    });

    $("[name^='tahfizhl_']").on('change', function() {
        var status     = $(this).prop('checked') ? $(this).val() : '';
        var itemid = $(this).attr('itemid');
        if (status === "L"){
            $("#detail_shaffl_"+itemid).show();
        } else {
            $("#detail_shaffl_"+itemid).hide();
        }
    });

    $("[name^='tahfizhz_']").on('change', function() {
        var status     = $(this).prop('checked') ? $(this).val() : '';
        var itemid = $(this).attr('itemid');
        if (status === "Z"){
            $("#detail_shaffz_"+itemid).show();
        } else {
            $("#detail_shaffz_"+itemid).hide();
        }
    });

    $("[name^='shaffm']").on('change', function() {
        var val = $(this).val();
        var itemid = $(this).attr('itemid');
        $("#shaffm_other_"+itemid).hide();
        if (val === "O"){
            $("#shaffm_other_"+itemid).show();
        }
    });

    $("[name^='shaffl']").on('change', function() {
        var val = $(this).val();
        var itemid = $(this).attr('itemid');
        $("#shaffl_other_"+itemid).hide();
        if (val === "O"){
            $("#shaffl_other_"+itemid).show();
        }
    });

    $("[name^='shaffz']").on('change', function() {
        var val = $(this).val();
        var itemid = $(this).attr('itemid');
        $("#shaffz_other_"+itemid).hide();
        if (val === "O"){
            $("#shaffz_other_"+itemid).show();
        }
    });

    $("[name^='submit_tahfizh_']").on('click', function() {
        var itemid = student_id = $(this).attr('itemid');

        var status = new Array(); 
        let type;
        //let status;

        $.each($("#student_"+itemid+":checked"), function(){
            type = $(this).val();
        });
        var school_id   = $('#school_id').val();
        var class_id   = $('#class_id').val();
        var section_id = $('#section_id').val();
        var date       = $('#date').val();
        var obj = $(this);
        var dateString = date,
            dateTimeParts = dateString.split(' '),
            dateParts = dateTimeParts[0].split('-'),
            dateg;

            dateg = new Date(dateParts[2], parseInt(dateParts[1], 10) - 1, dateParts[0]);
        var datefix = dateg.getTime();

        //var shaff = $("#shaff_"+itemid).val();
        //var shaff_other = $("#shaff_o_"+itemid).val();
        //var shaff_note = $("#shaff_note_"+itemid).val();
        var tahfizhdate = Math.floor(datefix / 1000);
        var tahfizhm     = $("#tahfizhm_"+itemid).prop('checked') ? $("#tahfizhm_"+itemid).val() : '';
        var tahfizhz     = $("#tahfizhz_"+itemid).prop('checked') ? $("#tahfizhz_"+itemid).val() : '';
        var tahfizhl     = $("#tahfizhl_"+itemid).prop('checked') ? $("#tahfizhl_"+itemid).val() : '';
        
        var mymuta = new Array(); 
        $("#mutabaah_"+itemid+" :input").each(function(){
            let input = $(this);
            let name = input.attr('name').substring(0, 3);
            let value = input.val();
            mymuta = { type: name, date: tahfizhdate, val: value }
            status.push ( mymuta );
        });

        if(type == 'A'){
            status = { type: type, date: tahfizhdate };
        } else {
            if(tahfizhm === 'M'){
                var shaffm = $("#shaffm_"+itemid).val();
                var shaffm_other = $("#shaffm_o_"+itemid).val();
                var shaffm_note = $("#shaffm_note_"+itemid).val();
                var shaffm_score = $("#shaffm_score_"+itemid).val();
                tahfizhmpush = { type: tahfizhm, date: tahfizhdate, shaff: shaffm, shaffo : shaffm_other, shaffn : shaffm_note, shaffs : shaffm_score };
                status.push (  tahfizhmpush );
            } 
            if(tahfizhl === 'L'){
                var shaffl = $("#shaffl_"+itemid).val();
                var shaffl_other = $("#shaffl_o_"+itemid).val();
                var shaffl_note = $("#shaffl_note_"+itemid).val();
                var shaffl_score = $("#shaffl_score_"+itemid).val();
                tahfizhlpush = { type: tahfizhl, date: tahfizhdate, shaff: shaffl, shaffo : shaffl_other, shaffn : shaffl_note, shaffs : shaffl_score };
                status.push (  tahfizhlpush );
            } 
            if(tahfizhz === 'Z'){
                var shaffz = $("#shaffz_"+itemid).val();
                var shaffz_other = $("#shaffz_o_"+itemid).val();
                var shaffz_note = $("#shaffz_note_"+itemid).val();
                var shaffz_score = $("#shaffz_score_"+itemid).val();
                tahfizhzpush = { type: tahfizhz, date: tahfizhdate, shaff: shaffz, shaffo : shaffz_other, shaffn : shaffz_note, shaffs : shaffz_score };
                status.push (  tahfizhzpush );
            }
        }

        console.log(status);

        status = JSON.stringify(status);

           $.ajax({       
             type   : "POST",
             url    : "<?php echo site_url('tahfizh/student/update_single_tahfizh'); ?>",
             data   : { school_id:school_id, status : status , student_id: student_id, class_id:class_id, section_id:section_id, date:date},               
             async  : false,
             success: function(response){ 
                if(response == 'ay'){
                    
                    toastr.error('<?php echo $this->lang->line('set_academic_year_for_school'); ?>'); 
                    $(obj).prop('checked', false);
                    
                }else if(response == 1){
                    toastr.success('<?php echo $this->lang->line('update_success'); ?>'); 
                }else{
                    toastr.error('<?php echo $this->lang->line('update_failed'); ?>'); 
                    $(obj).prop('checked', false);
                } 
             }
         }); 

    });
  });
   $("#student").validate();    
</script>



