<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-users"></i><small> <?php echo $this->lang->line('manage_student'); ?></small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
          
            <div class="x_content quick-link">
                <?php $this->load->view('quick-link'); ?> 
            </div>
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs bordered">
                        
                        <?php if(isset($detail)){ ?>
                        
                        
                            <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="<?php echo site_url('student/index'); ?>"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                            
                            <?php if(has_permission(ADD, 'student', 'student')){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('student/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                            <?php } ?>
                           
                            <li  class="active"><a href="#tab_view_student"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('view'); ?></a> </li>                          
                            
                          
                        <?php }else{ ?> 
                            <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_student_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                            <?php if(has_permission(ADD, 'student', 'student')){ ?>
                                <?php if(isset($edit)){ ?>
                                    <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('student/add'); ?>"  aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                                 <?php }else{ ?>
                                     <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_student"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-plus-square-o"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                                 <?php } ?>
                            <?php } ?>

                            <?php if(isset($edit)){ ?>
                                <li  class="active"><a href="#tab_edit_student"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                            <?php } ?>
                        <?php } ?>     
                            
                         
                        <li class="li-class-list">
                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                            
                                <?php echo form_open(site_url('student/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id"  onchange="get_class_by_school(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select>
                                    <select  class="form-control col-md-7 col-xs-12" id="filter_class_id" name="class_id"  style="width:auto;" onchange="this.form.submit();">
                                         <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php if(isset($class_list) && !empty($class_list)){ ?>
                                            <?php foreach($class_list as $obj ){ ?>
                                                <option value="<?php echo $obj->id; ?>"><?php echo $obj->name; ?></option> 
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                   <?php echo form_close(); ?>
                            
                            <?php }else{  ?> 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_student_by_class(this.value);">
                                    <?php if($this->session->userdata('role_id') != STUDENT){ ?>    
                                        <option value="<?php echo site_url('student/index'); ?>">--<?php echo $this->lang->line('select'); ?>--</option> 
                                    <?php } ?>
                                    <?php $teacher_student_data = get_teacher_access_data('student'); ?>     
                                    <?php $guardian_class_data = get_guardian_access_data('class'); ?>      
                                    <?php foreach($classes as $obj ){ ?>
                                        <?php if($this->session->userdata('role_id') == STUDENT){ ?>
                                            <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?>
                                            <option value="<?php echo site_url('student/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>
                                            <?php if (!in_array($obj->id, $guardian_class_data)) { continue; } ?>
                                            <option value="<?php echo site_url('student/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>
                                            <?php if (!in_array($obj->id, $teacher_student_data)) { continue; } ?>
                                            <option value="<?php echo site_url('student/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php }else{ ?>
                                            <option value="<?php echo site_url('student/index/'.$obj->id); ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                        <?php } ?>
                                    <?php } ?>                                            
                                </select>                                
                            <?php } ?>
                        </li>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_student_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th>
                                         <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('photo'); ?></th>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('group'); ?></th>
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('section'); ?></th>
                                        <th><?php echo $this->lang->line('roll_no'); ?></th>
                                        <th>QrCode</th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>  
                                    <?php $guardian_student_data = get_guardian_access_data('student'); ?> 
                                    <?php  $count = 1; if(isset($students) && !empty($students)){ ?>
                                        <?php foreach($students as $obj){ ?>
                                        <?php 
                                            if($this->session->userdata('role_id') == GUARDIAN){
                                                if (!in_array($obj->id, $guardian_student_data)) { continue; }
                                            }elseif($this->session->userdata('role_id') == TEACHER){
                                                if (!in_array($obj->class_id, $teacher_student_data)) { continue; }
                                            }
                                        ?>
                                    <tr style="<?php if($obj->status_type !='regular'){ echo 'background:#f9bfbf; color:#000000;';} ?>">
                                            <td><?php echo $count++; ?></td>
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td>
                                                <?php  if($obj->photo != ''){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="70" /> 
                                                <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="70" /> 
                                                <?php } ?>
                                            </td>
                                            <td><?php echo ucfirst($obj->name); ?></td>
                                            <td><?php echo $this->lang->line($obj->group); ?></td>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->section; ?></td>
                                            <td><?php echo $obj->roll_no; ?></td>
                                            <td><img src="<?php echo UPLOAD_PATH; ?>/qrcode/<?php echo $obj->qrcode; ?>" alt="" width="70" /> 
                                                </td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'student', 'student') && $obj->status_type == 'regular'){ ?>
                                                    <a href="<?php echo site_url('student/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                               <?php if(has_permission(VIEW, 'student', 'student')){ ?>
                                                        <a href="javascript:void(0);" onclick="get_student_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-student-modal-lg" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                    <?php } ?>
                                                
                                 <?php 
                                 $belongs = ($this->session->userdata['profile_id'] == $obj->class_tahfizh_id) ? TRUE : FALSE;
                                 $belongs2 = ($this->session->userdata['profile_id'] == $obj->class_bpi_id) ? TRUE : FALSE;

                                 if (($belongs2 && $responsibility == 'bpi') || ($belongs2 && $responsibility == 'tbi') || $this->session->userdata('role_id') == SUPER_ADMIN || $this->session->userdata('role_id') == ADMIN) {
                                 echo '<a href="'.site_url('exam/resultcardform/view/bpi/'.$obj->school_id.'/'.$obj->academic_year_id.'/'.$obj->class_id.'/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i> Rapot BPI
                                  </a>
                                  <a href="'.site_url('exam/resultcardform/view/character/'.$obj->school_id.'/'.$obj->academic_year_id.'/'.$obj->class_id.'/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i> Rapot Karakter
                                  </a>
                                  <a href="'.site_url('exam/mark/form/bpi/'.$obj->school_id.'/'.$obj->academic_year_id.'/'.$obj->class_id.'/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i> Input Nilai BPI
                                  </a>';
                                 } 
                                 if (($belongs && $responsibility == 'tahfidz') || ($belongs && $responsibility == 'tbi')  || $this->session->userdata('role_id') == SUPER_ADMIN || $this->session->userdata('role_id') == ADMIN) {
                                    echo '
                                  <a href="'.site_url('exam/resultcardform/view/tahfizh/'.$obj->school_id.'/'.$obj->academic_year_id.'/'.$obj->class_id.'/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i> Raport Tahfizh
                                  </a>
                                  <a href="'.site_url('exam/mark/form/tahfizh/'.$obj->school_id.'/'.$obj->academic_year_id.'/'.$obj->class_id.'/'.$obj->id).'" type="button" class="btn btn-success btn-xs">
                                    <i class="fa fa-user"> </i> Input Nilai Tahfizh
                                  </a>';
                                 }
                                  
                                  ?>

                                                <?php if(has_permission(DELETE, 'student', 'student') && $obj->status_type == 'regular'){ ?>
                                                        <br/><a href="<?php echo site_url('student/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                                 <?php if(has_permission(EDIT, 'student', 'student')){ ?>
                                                    <select  class="form-control col-md-7 col-xs-12 status-type"  name="status_type"  id="status_type" onchange="update_status_type('<?php echo $obj->id; ?>', this.value);">
                                                        <option value="regular" <?php echo $obj->status_type == 'regular' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('regular'); ?></option>
                                                        <option value="drop" <?php echo $obj->status_type == 'drop' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('drop'); ?></option>
                                                        <option value="transfer" <?php echo $obj->status_type == 'transfer' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('transfer'); ?></option>
                                                        <option value="passed" <?php echo $obj->status_type == 'passed' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('passed'); ?></option>
                                                    </select>
                                                <?php } ?>    
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_student">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('student/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="row">                  
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="name"><?php echo $this->lang->line('name'); ?> Lengkap <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($post['name']) ?  $post['name'] : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('name'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="admission_no"><?php echo $this->lang->line('admission_no'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="admission_no"  id="admission_no" value="<?php echo isset($post['admission_no']) ?  $post['admission_no'] : ''; ?>" placeholder="<?php echo $this->lang->line('admission_no'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('admission_no'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <div class="item form-group">
                                            <label for="admission_date"><?php echo $this->lang->line('admission_date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="admission_date"  id="add_admission_date" value="<?php echo isset($post['admission_date']) ?  $post['admission_date'] : ''; ?>" placeholder="<?php echo $this->lang->line('admission_date'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('admission_date'); ?></div> 
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <div class="item form-group">
                                            <label for="pob">Tempat <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="pob"  id="pob" value="<?php echo isset($post['pob']) ?  $post['pob'] : ''; ?>" placeholder="<?php echo $this->lang->line('pob'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('pob'); ?></div> 
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label  for="dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="dob"  id="add_dob" value="<?php echo isset($post['dob']) ?  $post['dob'] : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('dob'); ?></div>
                                         </div>
                                    </div>
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="gender"><?php echo $this->lang->line('gender'); ?> <span class="required">*</span></label>
                                              <select  class="form-control col-md-7 col-xs-12"  name="gender"  id="gender" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $genders = get_genders(); ?>
                                                <?php foreach($genders as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php echo isset($post['gender']) && $post['gender'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('gender'); ?></div>
                                         </div>
                                     </div>
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="blood_group"><?php echo $this->lang->line('blood_group'); ?></label>
                                              <select  class="form-control col-md-7 col-xs-12" name="blood_group" id="blood_group">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $bloods = get_blood_group(); ?>
                                                <?php foreach($bloods as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php echo isset($post['blood_group']) && $post['blood_group'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                                </select>
                                            <div class="help-block"><?php echo form_error('blood_group'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                              <label for="religion"><?php echo $this->lang->line('religion'); ?></label>
                                              <input  class="form-control col-md-7 col-xs-12"  name="religion"  id="add_religion" value="<?php echo isset($post['religion']) ?  $post['religion'] : ''; ?>" placeholder="<?php echo $this->lang->line('religion'); ?>" type="text" autocomplete="off">
                                               <div class="help-block"><?php echo form_error('religion'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                              <label for="caste"><?php echo $this->lang->line('caste'); ?></label>
                                              <input  class="form-control col-md-7 col-xs-12"  name="caste"  id="caste" value="<?php echo isset($post['caste']) ?  $post['caste'] : ''; ?>" placeholder="<?php echo $this->lang->line('caste'); ?>" type="text" autocomplete="off">
                                               <div class="help-block"><?php echo form_error('caste'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                    
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="weight">Berat Badan</label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="weight"  id="weight" value="<?php echo isset($post['weight']) ?  $post['weight'] : ''; ?>" placeholder="<?php echo $this->lang->line('weight'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('weight'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                           <label for="height">Tinggi Badan </label>
                                           <input  class="form-control col-md-7 col-xs-12"  name="height"  id="height" value="<?php echo isset($post['height']) ?  $post['height'] : ''; ?>" placeholder="<?php echo $this->lang->line('height'); ?>" type="text" autocomplete="off">
                                           <div class="help-block"><?php echo form_error('height'); ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                         <div class="item form-group">
                                             <label for="child_no">Anak Ke</label>
                                             <input  class="form-control col-md-3 col-xs-6"  name="child_no"  id="child_no" value="<?php echo isset($post['child_no']) ?  $post['child_no'] : ''; ?>" placeholder="<?php echo $this->lang->line('child_no'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('child_no'); ?></div>
                                        </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-6">
                                         <div class="item form-group">
                                             <label for="child_from">Dari</label>
                                             <input  class="form-control col-md-3 col-xs-6"  name="child_from"  id="child_from" value="<?php echo isset($post['child_from']) ?  $post['child_from'] : ''; ?>" placeholder="<?php echo $this->lang->line('child_from'); ?>" type="text" autocomplete="off"> Bersaudara
                                             <div class="help-block"><?php echo form_error('child_from'); ?></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span></label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="phone"  id="add_phone" value="<?php echo isset($post['phone']) ?  $post['phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('phone'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                           <label for="email"><?php echo $this->lang->line('email'); ?> </label>
                                           <input  class="form-control col-md-7 col-xs-12"  name="email"  id="email" value="<?php echo isset($post['email']) ?  $post['email'] : ''; ?>" placeholder="<?php echo $this->lang->line('email'); ?>" type="email" autocomplete="off">
                                           <div class="help-block"><?php echo form_error('email'); ?></div>
                                        </div>
                                    </div>
                                    
                                    <!--div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="national_id"><?php echo $this->lang->line('national_id'); ?> </label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="national_id"  id="national_id" value="<?php echo isset($post['national_id']) ?  $post['national_id'] : ''; ?>" placeholder="<?php echo $this->lang->line('national_id'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('national_id'); ?></div>
                                         </div>
                                     </div-->

                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="nisn_no">No. NISN</label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="nisn_no"  id="nisn_no" value="<?php echo isset($post['nisn_no']) ?  $post['nisn_no'] : ''; ?>" placeholder="<?php echo $this->lang->line('nisn_no'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('nisn_no'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="skhun_no">No. SKHUN</label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="skhun_no"  id="skhun_no" value="<?php echo isset($post['skhun_no']) ?  $post['skhun_no'] : ''; ?>" placeholder="<?php echo $this->lang->line('skhun_no'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('skhun_no'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                  
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('academic_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                
                                <div class="row">  
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="type_id"><?php echo $this->lang->line('student_type'); ?></label>
                                                <select  class="form-control col-md-7 col-xs-12" name="type_id" id="add_type_id">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($types as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($post['type_id']) && $post['type_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->type; ?></option>
                                                <?php } ?>
                                                </select>
                                             <div class="help-block"><?php echo form_error('type_id'); ?></div>
                                         </div>
                                     </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="class_id" id="add_class_id" required="required" onchange="get_section_by_class(this.value, '');">
                                               <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                               <?php foreach($classes as $obj){ ?>
                                                   <option value="<?php echo $obj->id; ?>" <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                               <?php } ?>
                                           </select>
                                           <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                           <label for="section_id"><?php echo $this->lang->line('section'); ?> <span class="required">*</span></label>
                                           <select  class="form-control col-md-7 col-xs-12 quick-field" name="section_id" id="add_section_id" required="required">
                                               <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                           </select>
                                           <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="group"><?php echo $this->lang->line('group'); ?> </label>
                                            <select  class="form-control col-md-7 col-xs-12" name="group" id="group">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $groups = get_groups(); ?>
                                                <?php foreach($groups as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php echo isset($post['group']) && $post['group'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('group'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                <div class="row"> 
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="roll_no"><?php echo $this->lang->line('roll_no'); ?> <span class="required">*</span></label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="roll_no"  id="roll_no" value="<?php echo isset($post['roll_no']) ?  $post['roll_no'] : ''; ?>" placeholder="<?php echo $this->lang->line('roll_no'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('roll_no'); ?></div>
                                         </div>
                                     </div>                               
                               
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="registration_no"><?php echo $this->lang->line('registration_no'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="registration_no"  id="registration_no" value="<?php echo isset($post['registration_no']) ?  $post['registration_no'] : ''; ?>" placeholder="<?php echo $this->lang->line('registration_no'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('registration_no'); ?></div>
                                         </div>
                                     </div>
                                     
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="discount_id"><?php echo $this->lang->line('discount'); ?></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="discount_id" id="add_discount_id">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($discounts as $obj){ ?>                                                    
                                                    <option value="<?php echo $obj->id; ?>"><?php echo $obj->title; ?> [<?php echo $obj->amount; ?>%]</option>                                                   
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('discount_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="second_language"><?php echo $this->lang->line('second_language'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="second_language"  id="second_language" value="<?php echo isset($post['second_language']) ?  $post['second_language'] : ''; ?>" placeholder="<?php echo $this->lang->line('second_language'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('second_language'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                
                               
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('father_information'); ?>:</strong></h5>
                                    </div>
                                </div> 
                                <div class="row">  
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_name"><?php echo $this->lang->line('father_name'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_name"  id="father_name" value="<?php echo isset($post['father_name']) ?  $post['father_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('father_name'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_name'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_phone"><?php echo $this->lang->line('father_phone'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_phone"  id="father_phone" value="<?php echo isset($post['father_phone']) ?  $post['father_phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('father_phone'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_phone'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_education"><?php echo $this->lang->line('father_education'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_education"  id="father_education" value="<?php echo isset($post['father_education']) ?  $post['father_education'] : ''; ?>" placeholder="<?php echo $this->lang->line('father_education'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_education'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_profession"><?php echo $this->lang->line('father_profession'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_profession"  id="father_profession" value="<?php echo isset($post['father_profession']) ?  $post['father_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('father_profession'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_profession'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_designation"><?php echo $this->lang->line('father_designation'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_designation"  id="father_designation" value="<?php echo isset($post['father_designation']) ?  $post['father_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('father_designation'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_designation'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_religion">Agama</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_religion"  id="father_religion" value="<?php echo isset($post['father_religion']) ?  $post['father_religion'] : ''; ?>" placeholder="<?php echo $this->lang->line('father_religion'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_religion'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_pob">Tempat</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_pob"  id="father_pob" value="<?php echo isset($post['father_pob']) ?  $post['father_pob'] : ''; ?>" placeholder="Kota Lahir"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_pob'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label  for="father_dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_dob"  id="add_father_dob" value="<?php echo isset($post['father_dob']) ?  $post['father_dob'] : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_dob'); ?></div>
                                         </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('father_photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="father_photo"  id="father_photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('father_photo'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('mother_information'); ?>:</strong></h5>
                                    </div>
                                </div> 
                                <div class="row">  
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_name"><?php echo $this->lang->line('mother_name'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_name"  id="mother_name" value="<?php echo isset($post['mother_name']) ?  $post['mother_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother_name'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_name'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_phone"><?php echo $this->lang->line('mother_phone'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_phone"  id="mother_phone" value="<?php echo isset($post['mother_phone']) ?  $post['mother_phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother_phone'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_phone'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_education"><?php echo $this->lang->line('mother_education'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_education"  id="mother_education" value="<?php echo isset($post['mother_education']) ?  $post['mother_education'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother_education'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_education'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_profession"><?php echo $this->lang->line('mother_profession'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_profession"  id="mother_profession" value="<?php echo isset($post['mother_profession']) ?  $post['mother_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother_profession'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_profession'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_designation"><?php echo $this->lang->line('mother_designation'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_designation"  id="mother_designation" value="<?php echo isset($post['mother_designation']) ?  $post['mother_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother_designation'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_designation'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_religion">Agama</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_religion"  id="mother_religion" value="<?php echo isset($post['mother_religion']) ?  $post['mother_religion'] : ''; ?>" placeholder="<?php echo $this->lang->line('mother_religion'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_religion'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_pob">Tempat</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_pob"  id="mother_pob" value="<?php echo isset($post['mother_pob']) ?  $post['mother_pob'] : ''; ?>" placeholder="Kota Lahir"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_pob'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label  for="mother_dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_dob"  id="add_mother_dob" value="<?php echo isset($post['mother_dob']) ?  $post['mother_dob'] : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_dob'); ?></div>
                                         </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('mother_photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="mother_photo"  id="mother_photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('mother_photo'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('guardian_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="is_guardian"><?php echo $this->lang->line('is_guardian'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="is_guardian" id="is_guardian" required="required" onchange="check_guardian_type(this.value);">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <option value="father" <?php echo isset($post['is_guardian']) && $post['is_guardian'] == 'father' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('father'); ?></option>
                                                <option value="mother" <?php echo isset($post['is_guardian']) && $post['is_guardian'] == 'mother' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('mother'); ?></option>
                                                <option value="other" <?php echo isset($post['is_guardian']) && $post['is_guardian'] == 'other' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('other'); ?></option>
                                                <option value="exist_guardian" <?php echo isset($post['is_guardian']) && $post['is_guardian'] == 'exist_guardian' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('guardian_exist'); ?></option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('is_guardian'); ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="fn_existing_guardian <?php if(isset($post['is_guardian']) && $post['is_guardian'] == 'exist_guardian'){'';}else{ echo 'display'; } ?>">
                                        <div class="col-md-3 col-sm-3 col-xs-12"> 
                                            <div class="item form-group">
                                                <label for="guardian_id"><?php echo $this->lang->line('guardian'); ?> <span class="required">*</span></label>
                                                <select  class="form-control col-md-7 col-xs-12 quick-field" name="guardian_id" id="add_guardian_id" onchange="get_guardian_by_id(this.value);">
                                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                    <?php foreach($guardians as $obj){ ?>
                                                        <option value="<?php echo $obj->id; ?>" <?php echo isset($post['guardian_id']) && $post['guardian_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="help-block"><?php echo form_error('guardian_id'); ?></div>
                                            </div>
                                        </div>                                  
                                    </div>
                                                                        
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="relation_with"><?php echo $this->lang->line('relation_with_guardian'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="relation_with"  id="add_relation_with" value="<?php echo isset($post['relation_with']) ?  $post['relation_with'] : ''; ?>" placeholder="<?php echo $this->lang->line('relation_with_guardian'); ?>" type="text">
                                            <div class="help-block"><?php echo form_error('relation_with'); ?></div>
                                        </div>
                                    </div> 
                                </div> 
                                   
                                
                                <div class="<?php echo ($post['is_guardian']) && $post['is_guardian'] != 'exist_guardian' ? '' :'display'; ?> fn_except_exist"> 
                                    <div class="row"> 

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="gud_name"  id="add_gud_name" value="<?php echo isset($post['gud_name']) ?  $post['gud_name'] : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text">
                                                <div class="help-block"><?php echo form_error('gud_name'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="gud_phone"  id="add_gud_phone" value="<?php echo isset($post['gud_phone']) ?  $post['gud_phone'] : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?>" required="required" type="text">
                                                <div class="help-block"><?php echo form_error('phone'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_email"><?php echo $this->lang->line('email'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="gud_email"  id="add_gud_email" value="<?php echo isset($post['gud_email']) ?  $post['gud_email'] : ''; ?>" placeholder="<?php echo $this->lang->line('email'); ?>" required="email" type="email">
                                                <div class="help-block"><?php echo form_error('gud_email'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_profession"><?php echo $this->lang->line('profession'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="gud_profession"  id="add_gud_profession" value="<?php echo isset($post['gud_profession']) ?  $post['gud_profession'] : ''; ?>" placeholder="<?php echo $this->lang->line('profession'); ?>"  type="text">
                                                <div class="help-block"><?php echo form_error('gud_profession'); ?></div>
                                            </div>
                                        </div>                                   
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_religion"><?php echo $this->lang->line('religion'); ?> </label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="gud_religion"  id="add_gud_religion" value="<?php echo isset($post['gud_religion']) ?  $post['gud_religion'] : ''; ?>" placeholder="<?php echo $this->lang->line('religion'); ?>" type="text">
                                                <div class="help-block"><?php echo form_error('gud_religion'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_national_id"><?php echo $this->lang->line('national_id'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="gud_national_id"  id="add_gud_national_id" value="<?php echo isset($post['gud_national_id']) ?  $post['gud_national_id'] : ''; ?>" placeholder="<?php echo $this->lang->line('national_id'); ?>"  type="text">
                                                <div class="help-block"><?php echo form_error('gud_national_id'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_username"><?php echo $this->lang->line('username'); ?></label>
                                                <input  class="form-control col-md-7 col-xs-12"  name="gud_username"  id="add_gud_username" value="<?php echo isset($post['gud_username']) ?  $post['gud_username'] : ''; ?>" placeholder="<?php echo $this->lang->line('username'); ?>"  type="text" required="required">
                                                <div class="help-block"><?php echo form_error('gud_username'); ?></div>
                                            </div>
                                        </div>                                        

                                    </div>
                                    
                                    <div class="row">    
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_present_address"><?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?></label>
                                                <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="gud_present_address"  id="add_gud_present_address" placeholder="<?php echo $this->lang->line('present'); ?> <?php echo $this->lang->line('address'); ?>"><?php echo isset($post['gud_present_address']) ?  $post['gud_present_address'] : ''; ?></textarea>
                                                <div class="help-block"><?php echo form_error('gud_present_address'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="item form-group">
                                                <label for="gud_permanent_address"><?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?></label>
                                                <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="gud_permanent_address"  id="add_gud_permanent_address" placeholder="<?php echo $this->lang->line('permanent'); ?> <?php echo $this->lang->line('address'); ?>"><?php echo isset($post['gud_permanent_address']) ?  $post['gud_permanent_address'] : ''; ?></textarea>
                                                <div class="help-block"><?php echo form_error('gud_permanent_address'); ?></div>
                                            </div>
                                        </div>  
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="item form-group">
                                                <label for="other_info"><?php echo $this->lang->line('other_info'); ?> </label>
                                                <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="gud_other_info"  id="add_gud_other_info" placeholder="<?php echo $this->lang->line('other_info'); ?>"><?php echo isset($post['gud_other_info']) ?  $post['gud_other_info'] : ''; ?></textarea>
                                                <div class="help-block"><?php echo form_error('gud_other_info'); ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <div class="item form-group">
                                                <label for="other_info">Penghasilan Orang Tua/Wali Per Bulan </label>
                                                <!-- Default inline 1-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="earning" name="inlineDeA">
                                                <label class="custom-control-label" for="defaultInline1">< Rp. 2.500.000</label>
                                                </div>

                                                <!-- Default inline 2-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="defaultInline2" name="inlineDefaultRadiosExample">
                                                <label class="custom-control-label" for="defaultInline2">Rp. 2.500.000 - 5.000.000</label>
                                                </div>

                                                <!-- Default inline 3-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="defaultInline3" name="inlineDefaultRadiosExample">
                                                <label class="custom-control-label" for="defaultInline3">Rp. 5.000.000,- s/d 10.000.000</label>
                                                </div>

                                                <!-- Default inline 4-->
                                                <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="defaultInline3" name="inlineDefaultRadiosExample">
                                                <label class="custom-control-label" for="defaultInline3">> Rp. 10.000.000,-</label>
                                                </div>
                                                <div class="help-block"><?php echo form_error('gud_other_info'); ?></div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title">
                                            <strong>
                                            <?php echo $this->lang->line('address_information'); ?>: 
                                            </strong>
                                            <?php echo $this->lang->line('same_as_guarduan_address'); ?> <input  class=""  name="same_as_guardian"  id="same_as_guardian" value="1"  type="checkbox" <?php echo isset($post['same_as_guardian']) ?  'checked="checked"' : ''; ?>>
                                        </h5>
                                    </div>
                                </div>
                                <div class="row">   
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div class="item form-group">
                                             <label for="present_address"><?php echo $this->lang->line('present_address'); ?> </label>
                                              <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="present_address"  id="add_present_address"  placeholder="<?php echo $this->lang->line('present_address'); ?>"><?php echo isset($post['present_address']) ?  $post['present_address'] : ''; ?></textarea>
                                              <div class="help-block"><?php echo form_error('present_address'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div class="item form-group">
                                            <label for="permanent_address"><?php echo $this->lang->line('permanent_address'); ?></label>
                                            <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="permanent_address"  id="add_permanent_address"  placeholder="<?php echo $this->lang->line('permanent_address'); ?>"><?php echo isset($post['permanent_address']) ?  $post['permanent_address'] : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('permanent_address'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="prov">Provinsi <span class="required">*</span></label>
                                              <select  class="form-control col-md-12 col-xs-12"  name="province_id"  id="add_province_id" required="required" onchange="get_cities_by_prov(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($provinces as $prov){ ?>
                                                    <option value="<?php echo $prov->id; ?>" <?php echo isset($post['prov']) && $post['prov'] == $prov->id ?  'selected="selected"' : ''; ?>><?php echo $prov->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('prov'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="regency_id">Kota <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="regency_id" id="add_regency_id" required="required"  onchange="get_district_by_city(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('regency_id'); ?></div>
                                         </div>
                                     </div>

                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="district_id">Kecamatan <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="district_id" id="add_district_id" required="required"  onchange="get_villages_by_district(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('district_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="district_id">Kelurahan <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="villages_id" id="add_villages_id" required="required" onchange="get_postal_code(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('villages_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="post_code">Kode Pos <span class="required">*</span></label>
                                            <input name="postal_code" id="add_postal_code" value="">
                                            <div class="help-block"><?php echo form_error('post_code'); ?></div>
                                         </div>
                                     </div>                    
                                     
                                </div>
                           
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('previous_school'); ?>:</strong></h5>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_school"><?php echo $this->lang->line('school_name'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_school"  id="previous_school" value="<?php echo isset($post['previous_school']) ?  $post['previous_school'] : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_school'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_class"><?php echo $this->lang->line('class'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_class"  id="previous_class" value="<?php echo isset($post['previous_class']) ?  $post['previous_class'] : ''; ?>" placeholder="<?php echo $this->lang->line('previous_class'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_class'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_school_address"><?php echo $this->lang->line('school_address'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_school_address"  id="previous_school_address" value="<?php echo isset($post['previous_school_address']) ?  $post['previous_school_address'] : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_school_address'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_school_city">Kota Asal</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_school_city"  id="previous_school_city" value="<?php echo isset($post['previous_school_city']) ?  $post['previous_school_city'] : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_school_city'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="graduate_year">Tahun Kelulusan</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="graduate_year"  id="graduate_year" value="<?php echo isset($post['graduate_year']) ?  $post['graduate_year'] : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('graduate_year'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('transfer_certificate'); ?> </label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="transfer_certificate"  id="transfer_certificate" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('transfer_certificate'); ?></div>
                                         </div>
                                     </div>
                                    
                                </div>
                                   
                                
                               <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong> <?php echo $this->lang->line('other_information'); ?>:</strong></h5>
                                    </div>
                                </div>    
                                <div class="row">
                                 
                                 <div class="col-md-3 col-sm-3 col-xs-12">
                                     <div class="item form-group">
                                        <label for="username"><?php echo $this->lang->line('username'); ?> <span class="required">*</span></label>
                                        <input  class="form-control col-md-7 col-xs-12"  name="username"  id="username" value="<?php echo isset($post['username']) ?  $post['username'] : ''; ?>" placeholder="<?php echo $this->lang->line('username'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('username'); ?></div>
                                     </div>
                                 </div>
                                 <div class="col-md-3 col-sm-3 col-xs-12">
                                     <div class="item form-group">
                                        <label for="password"><?php echo $this->lang->line('password'); ?> <span class="required">*</span></label>
                                        <input  class="form-control col-md-7 col-xs-12"  name="password"  id="password" value="<?php echo isset($post['password']) ?  $post['password'] : ''; ?>" placeholder="<?php echo $this->lang->line('password'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('password'); ?></div>
                                     </div>
                                 </div>
                                 <div class="col-md-3 col-sm-3 col-xs-12">
                                     <div class="item form-group">
                                        <label for="health_condition"><?php echo $this->lang->line('health_condition'); ?> </label>
                                        <input  class="form-control col-md-7 col-xs-12"  name="health_condition"  id="health_condition" value="<?php echo isset($post['health_condition']) ?  $post['health_condition'] : ''; ?>" placeholder="<?php echo $this->lang->line('health_condition'); ?>" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('health_condition'); ?></div>
                                     </div>
                                 </div>
                            </div>
                             <div class="row">                                     
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div class="item form-group">
                                            <label for="other_info"><?php echo $this->lang->line('other_info'); ?></label> 
                                            <textarea  class="form-control col-md-6 col-xs-12 textarea-4column"  name="other_info"  id="other_info" placeholder="<?php echo $this->lang->line('other_info'); ?>"><?php echo isset($post['other_info']) ?  $post['other_info'] : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('other_info'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label ><?php echo $this->lang->line('photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="photo"  id="photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('photo'); ?></div>
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                         </div>
                                     </div>                                    
                                </div>
                                                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" id="role_id" name="role_id" value="<?php echo STUDENT; ?>" />
                                        <a  href="<?php echo site_url('student/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="instructions"><strong><?php echo $this->lang->line('instruction'); ?>: </strong> <?php echo $this->lang->line('add_student_instruction'); ?></div>
                                </div>
                                
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                        
                        <div class="tab-pane fade in active" id="tab_edit_student">
                            <div class="x_content"> 
                            <?php echo form_open_multipart(site_url('student/edit/'. $student->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                               
                                <?php $this->load->view('layout/school_list_edit_form'); ?>
                                
                               <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('basic_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="name"><?php echo $this->lang->line('name'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="name"  id="name" value="<?php echo isset($student->name) ?  $student->name : ''; ?>" placeholder="<?php echo $this->lang->line('name'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('name'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="admission_no"><?php echo $this->lang->line('admission_no'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="admission_no"  id="admission_no" value="<?php echo isset($student->admission_no) ?  $student->admission_no : ''; ?>" placeholder="<?php echo $this->lang->line('admission_no'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('admission_no'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <div class="item form-group">
                                            <label for="admission_date"><?php echo $this->lang->line('admission_date'); ?><span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="admission_date"  id="edit_admission_date" value="<?php echo isset($student->admission_date) ?   date('d-m-Y', strtotime($student->admission_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('admission_date'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('admission_date'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <div class="item form-group">
                                            <label for="pob">Tempat <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="pob"  id="pob" value="<?php echo isset($student->pob) ?  $student->pob : ''; ?>" placeholder="<?php echo $this->lang->line('pob'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('pob'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label  for="dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="dob"  id="edit_dob" value="<?php echo isset($student->dob) ?  date('d-m-Y', strtotime($student->dob)) : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('dob'); ?></div>
                                         </div>
                                    </div>
                                 </div>
                                    
                                <div class="row">    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="gender"><?php echo $this->lang->line('gender'); ?> <span class="required">*</span></label>
                                              <select  class="form-control col-md-7 col-xs-12"  name="gender"  id="gender" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $genders = get_genders(); ?>
                                                <?php foreach($genders as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($student->gender == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('gender'); ?></div>
                                         </div>
                                     </div>
                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="blood_group"><?php echo $this->lang->line('blood_group'); ?></label>
                                              <select  class="form-control col-md-7 col-xs-12" name="blood_group" id="blood_group">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $bloods = get_blood_group(); ?>
                                                <?php foreach($bloods as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($student->blood_group == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                                </select>
                                            <div class="help-block"><?php echo form_error('blood_group'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                              <label for="religion"><?php echo $this->lang->line('religion'); ?></label>
                                              <input  class="form-control col-md-7 col-xs-12"  name="religion"  id="add_religion" value="<?php echo isset($student->religion) ?  $student->religion : ''; ?>" placeholder="<?php echo $this->lang->line('religion'); ?>" type="text" autocomplete="off">
                                               <div class="help-block"><?php echo form_error('religion'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                              <label for="caste"><?php echo $this->lang->line('caste'); ?></label>
                                              <input  class="form-control col-md-7 col-xs-12"  name="caste"  id="caste" value="<?php echo isset($student->caste) ?  $student->caste : ''; ?>" placeholder="<?php echo $this->lang->line('caste'); ?>" type="text" autocomplete="off">
                                               <div class="help-block"><?php echo form_error('caste'); ?></div>
                                         </div>
                                     </div>
                                </div>

                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="weight">Berat Badan</label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="weight"  id="weight" value="<?php echo isset($student->weight) ?  $student->weight : ''; ?>" placeholder="<?php echo $this->lang->line('weight'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('weight'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                           <label for="height">Tinggi Badan </label>
                                           <input  class="form-control col-md-7 col-xs-12"  name="height"  id="height" value="<?php echo isset($student->height) ?  $student->height : ''; ?>" placeholder="<?php echo $this->lang->line('height'); ?>" type="text" autocomplete="off">
                                           <div class="help-block"><?php echo form_error('height'); ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                         <div class="item form-group">
                                             <label for="child_no">Anak Ke</label>
                                             <input  class="form-control col-md-3 col-xs-6"  name="child_no"  id="child_no" value="<?php echo isset($student->child_no) ?  $student->child_no : ''; ?>" placeholder="<?php echo $this->lang->line('child_no'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('child_no'); ?></div>
                                        </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-6">
                                         <div class="item form-group">
                                             <label for="child_from">Dari</label>
                                             <input  class="form-control col-md-3 col-xs-6"  name="child_from"  id="child_from" value="<?php echo isset($student->child_from) ?  $student->child_from : ''; ?>" placeholder="<?php echo $this->lang->line('child_from'); ?>" type="text" autocomplete="off"> Bersaudara
                                             <div class="help-block"><?php echo form_error('child_from'); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="phone"><?php echo $this->lang->line('phone'); ?> <span class="required">*</span></label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="phone"  id="add_phone" value="<?php echo isset($student->phone) ?  $student->phone : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('phone'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="email"><?php echo $this->lang->line('email'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="email"   id="email" value="<?php echo isset($student->email) ?  $student->email : ''; ?>" placeholder="<?php echo $this->lang->line('email'); ?>" type="email" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('email'); ?></div>
                                         </div>
                                     </div>
                                     <?php /*
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="national_id"><?php echo $this->lang->line('national_id'); ?> </label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="national_id"  id="national_id" value="<?php echo isset($student->national_id) ?  $student->national_id : ''; ?>" placeholder="<?php echo $this->lang->line('national_id'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('national_id'); ?></div>
                                         </div>
                                     </div> */ ?>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="nisn_no">No. NISN</label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="nisn_no"  id="nisn_no" value="<?php echo isset($student->nisn_no) ?  $student->nisn_no : ''; ?>" placeholder="<?php echo $this->lang->line('nisn_no'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('nisn_no'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="skhun_no">No. SKHUN</label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="skhun_no"  id="skhun_no" value="<?php echo isset($student->skhun_no) ?  $student->skhun_no : ''; ?>" placeholder="<?php echo $this->lang->line('skhun_no'); ?>" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('skhun_no'); ?></div>
                                         </div>
                                     </div>                                    
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('academic_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="type_id"><?php echo $this->lang->line('student_type'); ?></label>
                                                <select  class="form-control col-md-7 col-xs-12" name="type_id" id="edit_type_id">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($types as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($student) && $student->type_id == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->type; ?></option>
                                                <?php } ?>
                                                </select>
                                             <div class="help-block"><?php echo form_error('type_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="class_id" id="edit_class_id" required="required"  onchange="get_section_by_class(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($classes as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($student->class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="section_id"><?php echo $this->lang->line('section'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="section_id" id="edit_section_id" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="group"><?php echo $this->lang->line('group'); ?> </label>
                                            <select  class="form-control col-md-7 col-xs-12" name="group" id="group">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php $groups = get_groups(); ?>
                                                <?php foreach($groups as $key=>$value){ ?>
                                                    <option value="<?php echo $key; ?>" <?php if($student->group == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('group'); ?></div>
                                         </div>
                                     </div>                                     
                                </div>

                                <div class="row">
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="class_id">Guru Tahfizh <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="class_tahfizh_id" id="edit_class_tahfizh_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($teachers as $objt){ ?>
                                                    <option value="<?php echo $objt->id; ?>" <?php if($student->class_tahfizh_id == $objt->id){ echo 'selected="selected"';} ?>><?php echo $objt->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="class_id">Guru BPI <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="class_bpi_id" id="edit_class_bpi_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($teachers as $objb){ ?>
                                                    <option value="<?php echo $objb->id; ?>" <?php if($student->class_bpi_id == $objb->id){ echo 'selected="selected"';} ?>><?php echo $objb->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                         </div>
                                     </div>
                                                                          
                                </div>
                                    
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="roll_no"><?php echo $this->lang->line('roll_no'); ?> <span class="required">*</span></label>
                                             <input  class="form-control col-md-7 col-xs-12"  name="roll_no"  id="roll_no"  value="<?php echo isset($student->roll_no) ?  $student->roll_no : ''; ?>" placeholder="<?php echo $this->lang->line('roll_no'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('roll_no'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="registration_no"><?php echo $this->lang->line('registration_no'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="registration_no"  id="registration_no" value="<?php echo isset($student->registration_no) ?  $student->registration_no : ''; ?>" placeholder="<?php echo $this->lang->line('registration_no'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('registration_no'); ?></div>
                                         </div>
                                     </div>
                                     
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="discount_id"><?php echo $this->lang->line('discount'); ?></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="discount_id" id="edit_discount_id">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($discounts as $obj){ ?>                                                    
                                                    <option value="<?php echo $obj->id; ?>" <?php if($student->discount_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->title; ?> [<?php echo $obj->amount; ?>%]</option>                                                   
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('discount_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="second_language"><?php echo $this->lang->line('second_language'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="second_language"  id="second_language" value="<?php echo isset($student->second_language) ?  $student->second_language : ''; ?>" placeholder="<?php echo $this->lang->line('second_language'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('second_language'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                
                                  
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('father_information'); ?>:</strong></h5>
                                    </div>
                                </div> 
                                <div class="row">  
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_name"><?php echo $this->lang->line('father_name'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_name"  id="father_name" value="<?php echo isset($student->father_name) ?  $student->father_name : ''; ?>" placeholder="<?php echo $this->lang->line('father_name'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_name'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_phone"><?php echo $this->lang->line('father_phone'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_phone"  id="father_phone" value="<?php echo isset($student->father_phone) ?  $student->father_phone : ''; ?>" placeholder="<?php echo $this->lang->line('father_phone'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_phone'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_education"><?php echo $this->lang->line('father_education'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_education"  id="father_education" value="<?php echo isset($student->father_education) ?  $student->father_education : ''; ?>" placeholder="<?php echo $this->lang->line('father_education'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_education'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_profession"><?php echo $this->lang->line('father_profession'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_profession"  id="father_profession" value="<?php echo isset($student->father_profession) ?  $student->father_profession : ''; ?>" placeholder="<?php echo $this->lang->line('father_profession'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_profession'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_designation"><?php echo $this->lang->line('father_designation'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_designation"  id="father_designation" value="<?php echo isset($student->father_designation) ?  $student->father_designation : ''; ?>" placeholder="<?php echo $this->lang->line('father_designation'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_designation'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_religion">Agama</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_religion"  id="father_religion" value="<?php echo isset($student->father_religion) ?  $student->father_religion : ''; ?>" placeholder="<?php echo $this->lang->line('father_religion'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_religion'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="father_pob">Tempat</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_pob"  id="father_pob" value="<?php echo isset($student->father_pob) ?  $student->father_pob : ''; ?>" placeholder="Kota Lahir"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_pob'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label  for="father_dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="father_dob"  id="edit_father_dob" value="<?php echo isset($student->father_dob) ?  date('d-m-Y', strtotime($student->father_dob)) : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('father_dob'); ?></div>
                                         </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('father_photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="father_photo"  id="father_photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('father_photo'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <input type="hidden" name="prev_father_photo" id="prev_father_photo" value="<?php echo $student->father_photo; ?>" />
                                            <?php if($student->father_photo){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/father-photo/<?php echo $student->father_photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                         </div>
                                     </div> 
                                </div>
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('mother_information'); ?>:</strong></h5>
                                    </div>
                                </div> 
                                <div class="row">  
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_name"><?php echo $this->lang->line('mother_name'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_name"  id="mother_name" value="<?php echo isset($student->mother_name) ?  $student->mother_name : ''; ?>" placeholder="<?php echo $this->lang->line('mother_name'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_name'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_phone"><?php echo $this->lang->line('mother_phone'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_phone"  id="mother_phone" value="<?php echo isset($student->mother_phone) ?  $student->mother_phone : ''; ?>" placeholder="<?php echo $this->lang->line('mother_phone'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_phone'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_education"><?php echo $this->lang->line('mother_education'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_education"  id="mother_education" value="<?php echo isset($student->mother_education) ?  $student->mother_education : ''; ?>" placeholder="<?php echo $this->lang->line('mother_education'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_education'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_profession"><?php echo $this->lang->line('mother_profession'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_profession"  id="mother_profession" value="<?php echo isset($student->mother_profession) ?  $student->mother_profession : ''; ?>" placeholder="<?php echo $this->lang->line('mother_profession'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_profession'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_designation"><?php echo $this->lang->line('mother_designation'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_designation"  id="mother_designation" value="<?php echo isset($student->mother_designation) ?  $student->mother_designation : ''; ?>" placeholder="<?php echo $this->lang->line('mother_designation'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_designation'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_religion">Agama</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_religion"  id="mother_religion" value="<?php echo isset($student->mother_religion) ?  $student->mother_religion : ''; ?>" placeholder="<?php echo $this->lang->line('mother_religion'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_religion'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label for="mother_pob">Tempat</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_pob"  id="mother_pob" value="<?php echo isset($student->mother_pob) ?  $student->mother_pob : ''; ?>" placeholder="Kota Lahir"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_pob'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-2 col-sm-2 col-xs-12">
                                         <div class="item form-group">
                                            <label  for="mother_dob"><?php echo $this->lang->line('birth_date'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="mother_dob"  id="edit_mother_dob" value="<?php echo isset($student->mother_dob) ?  date('d-m-Y', strtotime($student->mother_dob)) : ''; ?>" placeholder="<?php echo $this->lang->line('birth_date'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('mother_dob'); ?></div>
                                         </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('mother_photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="mother_photo"  id="mother_photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('mother_photo'); ?></div>
                                         </div>
                                     </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <input type="hidden" name="prev_mother_photo" id="prev_mother_photo" value="<?php echo $student->mother_photo; ?>" />
                                            <?php if($student->mother_photo){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/mother-photo/<?php echo $student->mother_photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                         </div>
                                     </div>
                                </div>
                                
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('guardian_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                                               
                                <div class="row"> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="guardian_id"><?php echo $this->lang->line('guardian_name'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="guardian_id" id="edit_guardian_id" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($guardians as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if($student->guardian_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('guardian_id'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="relation_with"><?php echo $this->lang->line('relation_with_guardian'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="relation_with"  id="relation_with" value="<?php echo isset($student->relation_with) ?  $student->relation_with : ''; ?>" placeholder="<?php echo $this->lang->line('relation_with_guardian'); ?>"  type="text">
                                            <div class="help-block"><?php echo form_error('relation_with'); ?></div>
                                        </div>
                                    </div>                                       
                                </div>
                                
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('address_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                <div class="row">    
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div class="item form-group">
                                             <label for="present_address"><?php echo $this->lang->line('present_address'); ?></label>
                                              <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="present_address"  id="add_present_address"  placeholder="<?php echo $this->lang->line('present_address'); ?>"><?php echo isset($student->present_address) ?  $student->present_address : ''; ?></textarea>
                                              <div class="help-block"><?php echo form_error('present_address'); ?></div>
                                         </div>
                                     </div>                                    
                                     <div class="col-md-6 col-sm-6 col-xs-12">
                                         <div class="item form-group">
                                            <label for="permanent_address"><?php echo $this->lang->line('permanent_address'); ?></label>
                                            <textarea  class="form-control col-md-7 col-xs-12 textarea-4column"  name="permanent_address"  id="add_permanent_address"  placeholder="<?php echo $this->lang->line('permanent_address'); ?>"><?php echo isset($student->permanent_address) ?  $student->permanent_address : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('permanent_address'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <label for="prov">Provinsi <span class="required">*</span></label>
                                              <select  class="form-control col-md-7 col-xs-12"  name="province_id"  id="edit_province_id" required="required" onchange="get_cities_by_prov(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                                <?php foreach($provinces as $prov){ ?>
                                                    <option value="<?php echo $prov->id; ?>" <?php echo isset($student->province_id) && $student->province_id == $prov->id ?  'selected="selected"' : ''; ?>><?php echo $prov->name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('prov'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="regency_id">Kota <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="regency_id" id="edit_regency_id" required="required"  onchange="get_district_by_city(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('regency_id'); ?></div>
                                         </div>
                                     </div>

                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="district_id">Kecamatan <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="district_id" id="edit_district_id" required="required"  onchange="get_villages_by_district(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('district_id'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="district_id">Kelurahan <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12 quick-field" name="villages_id" id="edit_villages_id" required="required" onchange="get_postal_code(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('villages_id'); ?></div>
                                         </div>
                                     </div>

                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="postal_code">Kode Pos <span class="required">*</span></label>
                                            <input name="postal_code" id="edit_postal_code" value="<?php echo isset($student->postal_code) ?  $student->postal_code : ''; ?>">
                                            <div class="help-block"><?php echo form_error('postal_code'); ?></div>
                                         </div>
                                     </div>
                                </div>                                                             
                              
                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('previous_school'); ?>:</strong></h5>
                                    </div>
                                </div>
                                <div class="row">                 
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_school"><?php echo $this->lang->line('school_name'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_school"  id="previous_school" value="<?php echo isset($student->previous_school) ?  $student->previous_school : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_school'); ?></div>
                                         </div>
                                     </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_class"><?php echo $this->lang->line('previous_class'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_class"  id="previous_class" value="<?php echo isset($student->previous_class) ?  $student->previous_class : ''; ?>" placeholder="<?php echo $this->lang->line('previous_class'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_class'); ?></div>
                                         </div>
                                     </div>

                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_school_address"><?php echo $this->lang->line('school_address'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_school_address"  id="previous_school_address" value="<?php echo isset($student->previous_school_address) ?  $student->previous_school_address : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_school_address'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="previous_school_city">Kota Asal</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="previous_school_city"  id="previous_school_city" value="<?php echo isset($student->previous_school_city) ?  $student->previous_school_city : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('previous_school_city'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="graduate_year">Tahun Kelulusan</label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="graduate_year"  id="graduate_year" value="<?php echo isset($student->graduate_year) ?  $student->graduate_year : ''; ?>" placeholder="<?php echo $this->lang->line('school_name'); ?>"  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('graduate_year'); ?></div>
                                         </div>
                                     </div>
                                                    
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label ><?php echo $this->lang->line('transfer_certificate'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="transfer_certificate"  id="transfer_certificate" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('transfer_certificate'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <input type="hidden" name="prev_transfer_certificate" id="prev_transfer_certificate" value="<?php echo $student->transfer_certificate; ?>" />
                                            <?php if($student->transfer_certificate){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/transfer-certificate/<?php echo $student->transfer_certificate; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                         </div>
                                     </div>                                    
                                </div>
                              
                                                                
                               <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5 class="column-title"><strong><?php echo $this->lang->line('other_information'); ?>:</strong></h5>
                                    </div>
                                </div>    
                                <div class="row">                  
                                                                         
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="username"><?php echo $this->lang->line('username'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="username"  id="username" readonly="readonly" value="<?php echo isset($student->username) ?  $student->username : ''; ?>" placeholder="<?php echo $this->lang->line('username'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('username'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="health_condition"><?php echo $this->lang->line('health_condition'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="health_condition"  id="health_condition" value="<?php echo isset($student->health_condition) ?  $student->health_condition : ''; ?>" placeholder="<?php echo $this->lang->line('health_condition'); ?>" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('health_condition'); ?></div>
                                         </div>
                                     </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                            <label for="status_type"><?php echo $this->lang->line('status'); ?> </label>
                                            <select  class="form-control col-md-7 col-xs-12"  name="status_type"  id="status_type">
                                                <option value="regular" <?php echo $student->status_type == 'regular' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('regular'); ?></option>
                                                <option value="drop" <?php echo $student->status_type == 'drop' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('drop'); ?></option>
                                                <option value="transfer" <?php echo $student->status_type == 'transfer' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('transfer'); ?></option>
                                                <option value="passed" <?php echo $student->status_type == 'passed' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('passed'); ?></option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('status_type'); ?></div>
                                         </div>
                                     </div>
                                </div>
                                <div class="row">     
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item form-group">
                                           <label for="other_info"><?php echo $this->lang->line('other_info'); ?></label> 
                                           <textarea  class="form-control col-md-6 col-xs-12 textarea-4column"  name="other_info"  id="other_info" placeholder="<?php echo $this->lang->line('other_info'); ?>"><?php echo isset($student->other_info) ?  $student->other_info : ''; ?></textarea>
                                           <div class="help-block"><?php echo form_error('other_info'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label ><?php echo $this->lang->line('photo'); ?></label>
                                            <div class="btn btn-default btn-file">
                                                <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="photo"  id="photo" type="file">
                                            </div>
                                            <div class="text-info"><?php echo $this->lang->line('valid_file_format_img'); ?></div>
                                            <div class="help-block"><?php echo form_error('photo'); ?></div>
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                         <div class="item form-group">
                                             <input type="hidden" name="prev_photo" id="prev_photo" value="<?php echo $student->photo; ?>" />
                                            <?php if($student->photo){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $student->photo; ?>" alt="" width="70" /><br/><br/>
                                            <?php } ?>
                                         </div>
                                     </div>                                    
                                </div>
                                
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" name="id" id="id" value="<?php echo $student->id; ?>" />
                                        <a href="<?php echo site_url('student/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div> 
                        <?php } ?>
                        
                         <?php if(isset($detail)){ ?>
                             <div class="tab-pane fade in active" id="tab_view_student">
                                <div class="x_content"> 
                                  <?php $this->load->view('get-single-student'); ?>
                                </div>
                             </div>
                        <?php } ?>
                        
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bs-student-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_student_data">
            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_student_modal(student_id){
         
        $('.fn_student_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('student/get_single_student'); ?>",
          data   : {student_id : student_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_student_data').html(response);
             }
          }
       });
    }
</script>


<div class="modal fade bs-activity-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_activity_data">
            
        </div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_activity_modal(activity_id){
         
        $('.fn_activity_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('student/activity/get_single_activity'); ?>",
          data   : {activity_id : activity_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_activity_data').html(response);
             }
          }
       });
    }
</script>

<!-- FATHAN F SHOULD BE HERE -->
  
  <!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>

 
<!-- Super admin js START  -->
 <script type="text/javascript">
     
    var edit = false;
         
    $("document").ready(function() {
         <?php if(isset($student) && !empty($student)){ ?>
            $("#edit_school_id").trigger('change');   
         <?php }elseif($post && !empty ($post)){ ?> 
             $("#add_school_id").trigger('change');  
         <?php } ?>
    });
    
     <?php if(isset($student) && !empty($student)){ ?>
          edit = true; 
     <?php } ?>
         
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();        
        var class_id = '';
        var class_mahad_id = '';
        var guardian_id = '';       
        var discount_id = ''; 
        var type_id = ''; 
        
        <?php if(isset($edit) && !empty($edit)){ ?>
                class_id =  '<?php echo $student->class_id; ?>';
                class_mahad_id =  '<?php echo $student->class_mahad_id; ?>';
                guardian_id =  '<?php echo $student->guardian_id; ?>';
                discount_id =  '<?php echo $student->discount_id; ?>';
                type_id =  '<?php echo $student->type_id; ?>';
         <?php }elseif($post && !empty ($post)){ ?>
                class_id =  '<?php echo $post['class_id']; ?>';
                class_mahad_id =  '<?php echo $post['class_mahad_id']; ?>';
                guardian_id =  '<?php echo $post['guardian_id']; ?>';
                discount_id =  '<?php echo $post['discount_id']; ?>';
                type_id =  '<?php echo $post['type_id']; ?>';
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_id, group_id:1},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(edit){
                       $('#edit_class_id').html(response);   
                   }else{
                       $('#add_class_id').html(response);   
                   }
                                    
                   get_guardian_by_school(school_id, guardian_id);
                   get_discount_by_school(school_id, discount_id);
                   get_student_type_by_school(school_id, type_id);
               }
            }
        });

        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id, class_id:class_mahad_id, group_id:2},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                   if(edit){
                       $('#edit_class_mahad_id').html(response);   
                   }else{
                       $('#add_class_mahad_id').html(response);   
                   }
                                    
                   get_guardian_by_school(school_id, guardian_id);
                   get_discount_by_school(school_id, discount_id);
                   get_student_type_by_school(school_id, type_id);
               }
            }
        });
    }); 
    
    
    function get_guardian_by_school(school_id, guardian_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_guardian_by_school'); ?>",
            data   : { school_id:school_id, guardian_id: guardian_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {    
                   if(edit){
                       $('#edit_guardian_id').html(response);
                   }else{
                       $('#add_guardian_id').html(response); 
                   }
               }
            }
        });
    }
        
    function get_discount_by_school(school_id, discount_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_discount_by_school'); ?>",
            data   : { school_id:school_id, discount_id: discount_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {    
                   if(edit){
                       $('#edit_discount_id').html(response);
                   }else{
                       $('#add_discount_id').html(response); 
                   }
               }
            }
        });
    }
    
    function get_student_type_by_school(school_id, type_id){
    
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_student_type_by_school'); ?>",
            data   : { school_id:school_id, type_id: type_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {    
                   if(edit){
                       $('#edit_type_id').html(response);
                   }else{
                       $('#add_type_id').html(response); 
                   }
               }
            }
        });
    }
    
     
    $('#add_admission_date').datepicker();
    $('#edit_admission_date').datepicker();
    $('#add_dob').datepicker({ startView: 2 });
    $('#edit_dob').datepicker({ startView: 2 });
    $('#add_father_dob').datepicker({ startView: 2 });
    $('#edit_father_dob').datepicker({ startView: 2 });
    $('#add_mother_dob').datepicker({ startView: 2 });
    $('#edit_mother_dob').datepicker({ startView: 2 });

    <?php if(isset($edit)){ ?>
        get_section_by_class('<?php echo $student->class_id; ?>', '<?php echo $student->section_id; ?>');
        get_section_mahad_by_class('<?php echo $student->class_mahad_id; ?>', '<?php echo $student->section_mahad_id; ?>');
        get_cities_by_prov('<?php echo $student->province_id; ?>', '<?php echo $student->regency_id; ?>');
        get_district_by_city('<?php echo $student->regency_id; ?>', '<?php echo $student->district_id; ?>');
        get_villages_by_district('<?php echo $student->district_id; ?>', '<?php echo $student->villages_id; ?>');
    <?php }elseif($post && !empty ($post)){ ?>  
        get_section_by_class('<?php echo $post['class_id']; ?>', '<?php echo $post['section_id']; ?>');
        get_section_mahad_by_class('<?php echo $post['class_mahad_id']; ?>', '<?php echo $post['section_mahad_id']; ?>');
        get_cities_by_prov('<?php echo $post['province_id']; ?>', '<?php echo $post['regency_id']; ?>');
        get_district_by_city('<?php echo $post['regency_id']; ?>', '<?php echo $post['district_id']; ?>');
        get_villages_by_district('<?php echo $post['district_id']; ?>', '<?php echo $post['villages_id']; ?>');
    <?php } ?>
    
    function get_section_by_class(class_id, section_id){       
        
        var school_id = '';
        <?php if(isset($edit)){ ?>                
            school_id = $('#edit_school_id').val();
         <?php }else{ ?> 
            school_id = $('#add_school_id').val();
         <?php } ?> 
          
        
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
                   if(edit){
                       $('#edit_section_id').html(response);
                   }else{
                       $('#add_section_id').html(response);
                   }
               }
            }
        });  
                     
        
   }

   function get_section_mahad_by_class(class_mahad_id, section_mahad_id){       
        
        var school_id = '';
        <?php if(isset($edit)){ ?>                
            school_id = $('#edit_school_id').val();
         <?php }else{ ?> 
            school_id = $('#add_school_id').val();
         <?php } ?> 
          
        
       if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : { school_id:school_id, class_id : class_mahad_id , section_id: section_mahad_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   if(edit){
                       $('#edit_section_mahad_id').html(response);
                   }else{
                       $('#add_section_mahad_id').html(response);
                   }
               }
            }
        });  
                     
        
   }

   function get_cities_by_prov(province_id, regency_id){       
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_cities_by_prov'); ?>",
            data   : { province_id : province_id , regency_id: regency_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   if(edit){
                       $('#edit_regency_id').html(response);
                   }else{
                       $('#add_regency_id').html(response);
                   }
               }
            }
        });  
                     
        
   }

   function get_district_by_city(regency_id, district_id){       
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_district_by_city'); ?>",
            data   : { regency_id : regency_id , district_id: district_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   if(edit){
                       $('#edit_district_id').html(response);
                   }else{
                       $('#add_district_id').html(response);
                   }
               }
            }
        });  
                     
        
   }

   function get_villages_by_district(district_id, villages_id){       
            $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_villages_by_district'); ?>",
            data   : { district_id : district_id , villages_id: villages_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   if(edit){
                       $('#edit_villages_id').html(response);
                   }else{
                       $('#add_villages_id').html(response);
                   }
               }
            }
        });  
                     
        
   }

   function get_postal_code(){

        if(edit){
            var urban = $('#edit_villages_id option:selected').text();
            var sub_district = $('#edit_district_id option:selected').text();
            var city = $('#edit_regency_id option:selected').text();
            var province_code = $('#edit_province_id option:selected').val();

        } else {
            var urban = $('#add_villages_id option:selected').text();
            var sub_district = $('#add_district_id option:selected').text();
            var city = $('#add_regency_id option:selected').text();
            var province_code = $('#add_province_id option:selected').val();
        }
        
        var kab = city.startsWith("KABUPATEN");
        var kota = city.startsWith("KOTA");

        if(kab){
            city = city.slice(10);
        } else if(kota){
            city = city.slice(5);
        }


        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_postal_code'); ?>",
            data   : { urban : urban , sub_district : sub_district, city : city, province_code : province_code},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   if(edit){
                       $('#edit_postal_code').val(response);
                   }else{
                       $('#add_postal_code').val(response);
                   }
               } else {
                if(edit){
                $('#edit_postal_code').val("");
                } else {
                    $('#add_postal_code').val("");
                }
               }
            }
        }); 

        
   }
  </script>
  
  <!-- datatable with buttons -->
 <script type="text/javascript">
        $(document).ready(function() {
          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
        });
        
        
      
        function check_guardian_type(guardian_type){
           
            $('#add_relation_with').val('');  
            $('#add_gud_name').val('');  
            $('#add_gud_phone').val('');  
            $('#add_gud_present_address').val('');  
            $('#add_gud_permanent_address').val('');  
            $('#add_gud_religion').val(''); 
            $('#add_gud_profession').val(''); 
            $('#add_gud_national_id').val(''); 
            $('#add_gud_email').val(''); 
            $('#add_gud_other_info').val(''); 
                    
           if(guardian_type == 'father'){
               
               $('#add_relation_with').val('<?php echo $this->lang->line('father'); ?>'); 
               $('.fn_existing_guardian').hide();
               $('.fn_except_exist').show();
               $('#guardian_id').prop('required', false);               
               $('#add_gud_name').prop('required', true);               
               $('#add_gud_phone').prop('required', true);               
               $('#add_gud_email').prop('required', true);               
               
               var f_name = $('#add_father_name').val();
               var f_phone = $('#add_father_phone').val(); 
               var f_education = $('#add_father_education').val(); 
               var f_profession = $('#add_father_profession').val(); 
               var f_designation = $('#add_father_designation').val(); 
               
               $('#add_gud_name').val(f_name);  
               $('#add_gud_phone').val(f_phone); 
               $('#add_gud_profession').val(f_profession); 
               
           }else if(guardian_type == 'mother'){
               
               $('#add_relation_with').val('<?php echo $this->lang->line('mother'); ?>');   
               $('.fn_existing_guardian').hide();
               $('.fn_except_exist').show();
               $('#guardian_id').prop('required', false);
               $('#add_gud_name').prop('required', true);               
               $('#add_gud_phone').prop('required', true);               
               $('#add_gud_email').prop('required', true); 
               
               var m_name = $('#add_mother_name').val();
               var m_phone = $('#add_mother_phone').val(); 
               var m_education = $('#add_mother_education').val(); 
               var m_profession = $('#add_mother_profession').val(); 
               var m_designation = $('#add_mother_designation').val(); 
               
               $('#add_gud_name').val(m_name);  
               $('#add_gud_phone').val(m_phone); 
               $('#add_gud_profession').val(m_profession); 
               
           }else if(guardian_type == 'other'){
               $('#add_relation_with').val('<?php echo $this->lang->line('other'); ?>');    
               $('.fn_existing_guardian').hide();
               $('.fn_except_exist').show();
               $('#guardian_id').prop('required', false);
               $('#add_gud_name').prop('required', true);               
               $('#add_gud_phone').prop('required', true);               
               $('#add_gud_email').prop('required', true); 
                              
           }else if(guardian_type == 'exist_guardian'){
               $('.fn_existing_guardian').show();
               $('.fn_except_exist').hide();
               $('#guardian_id').prop('required', true);   
               $('#add_gud_name').prop('required', false);               
               $('#add_gud_phone').prop('required', false);               
               $('#add_gud_email').prop('required', false); 
               
           }else{
                $('#add_relation_with').val('');   
                $('.fn_existing_guardian').hide();
                $('.fn_except_exist').show();
                $('#guardian_id').prop('required', false);
                $('#add_gud_name').prop('required', true);               
                $('#add_gud_phone').prop('required', true);               
                $('#add_gud_email').prop('required', true); 
           }
        
        }
        
        function get_guardian_by_id(guardian_id){                       
            
            $.ajax({       
            type   : "POST",
            dataType: "json",
            url    : "<?php echo site_url('ajax/get_guardian_by_id'); ?>",
            data   : { guardian_id : guardian_id},               
            async  : true,
            success: function(response){ 
               if(response)
               {
                    $('#add_gud_name').val(response.name);  
                    $('#add_gud_phone').val(response.phone);  
                    $('#add_gud_present_address').val(response.present_address);  
                    $('#add_gud_permanent_address').val(response.permanent_address);  
                    $('#add_gud_religion').val(response.religion);  
                    $('#add_gud_profession').val(response.profession);  
                    $('#add_gud_national_id').val(response.national_id);  
                    $('#add_gud_email').val(response.email);  
                    $('#add_gud_other_info').val(response.other_info);  
               }
               else
               {
                    $('#add_relation_with').val('');  
                    $('#add_gud_name').val('');  
                    $('#add_gud_phone').val('');  
                    $('#add_gud_present_address').val('');  
                    $('#add_gud_permanent_address').val('');  
                    $('#add_gud_religion').val(''); 
                    $('#add_gud_profession').val(''); 
                    $('#add_gud_national_id').val(''); 
                    $('#add_gud_email').val(''); 
                    $('#add_gud_other_info').val(''); 
               }
            }
        });  
        
        }
        
             
    $('#same_as_guardian').on('click', function(){
        
        if($(this).is(":checked")) {
            var present =  $('#add_gud_present_address').val();  
            var permanent = $('#add_gud_permanent_address').val();  
            $('#add_present_address').val(present);  
            $('#add_permanent_address').val(permanent);  
        }else{
             $('#add_present_address').val('');  
             $('#add_permanent_address').val(''); 
        }
    });
        
        
     /* Menu Filter Start */   
    function get_student_by_class(url){          
        if(url){
            window.location.href = url; 
        }
    }         
       
        
    <?php if(isset($filter_class_id)){ ?>
        get_class_by_school('<?php echo $filter_school_id; ?>', '<?php echo $filter_class_id; ?>');
    <?php } ?>
    
    function get_class_by_school(school_id, class_id){
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#filter_class_id').html(response);                     
               }
            }
        });
    } 
    
    function update_status_type(student_id, status){
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/update_student_status_type'); ?>",
            data   : { student_id : student_id, status : status},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                   toastr.success('<?php echo $this->lang->line('update_success'); ?>');
                   location.reload();
                   return false;                    
               }
            }
        });
    }    
             
    $("#add").validate();     
    $("#edit").validate();   
    $('#edit_province_id, #add_province_id').select2({
	  	placeholder: 'Pilih Provinsi',
	  	language: "id"
    });
    $('#edit_regency_id, #add_regency_id').select2({
	  	placeholder: 'Pilih Kota/Kab',
	  	language: "id"
    });
    $('#edit_district_id, #add_district_id').select2({
	  	placeholder: 'Pilih Kecamatan',
	  	language: "id"
    });
    $('#edit_villages_id, #add_villages_id').select2({
	  	placeholder: 'Pilih Kelurahan',
	  	language: "id"
	});
    
</script>