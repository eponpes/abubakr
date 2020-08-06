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
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="item form-group"> 
                            <div><?php echo $this->lang->line('section'); ?></div>
                            <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id">                                
                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                            </select>
                            <div class="help-block"><?php echo form_error('section_id'); ?></div>
                        </div>
                    </div>
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
                            <?php echo $this->lang->line('date'); ?> : <?php echo date($this->gsms_setting->sms_date_format, strtotime($date)); ?>
                        </p>
                    </div>
                </div>            
            </div>
             <?php } ?>
            
            <div class="x_content">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('sl_no'); ?></th>
                            <th><?php echo $this->lang->line('photo'); ?></th>
                            <th><?php echo $this->lang->line('name'); ?></th>
                            <th><?php echo $this->lang->line('email'); ?></th>
                            <th><?php echo $this->lang->line('phone'); ?></th>
                            <th><?php echo $this->lang->line('roll_no'); ?></th>
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

                            $tahfizh_type = ""; $tahfizh_shaff = ""; $tahfizh_shaff_o = ""; $tahfizh_shaff_note = "";
                            if(!empty($getdata->type)){ // Type
                                $tahfizh_type = $getdata->type;
                            } if(!empty($getdata->shaff)){ // Shaff
                                $tahfizh_shaff = $getdata->shaff;
                            } if(!empty($getdata->shaffo)){ // Shaff other
                                $tahfizh_shaff_o = $getdata->shaffo;
                            } if(!empty($getdata->shaffn)){ // Shaff note
                                $tahfizh_shaff_note = $getdata->shaffn;
                            }

                            
                            ?>
                                <tr>
                                    <td><?php echo $count++;  ?></td>
                                    <td>
                                        <?php if ($obj->photo != '') { ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/student-photo/<?php echo $obj->photo; ?>" alt="" width="60" /> 
                                        <?php } else { ?>
                                            <img src="<?php echo IMG_URL; ?>/default-user.png" alt="" width="60" /> 
                                        <?php } ?>
                                    </td>  
                                    <td><?php echo ucfirst($obj->name); ?></td>
                                    <td><?php echo $obj->email; ?></td>
                                    <td><?php echo $obj->phone; ?></td>
                                    <td><?php echo $obj->roll_no; ?></td>
                                    <td>
                                    <div id="shaff_type_<?php echo $obj->id; ?>" style="display: block; width: 100%">
                                        <input type="radio" value="M" itemid="<?php echo $obj->id; ?>" name="student_<?php echo $obj->id; ?>" id="student_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($tahfizh_type == 'M'){ echo 'checked="checked"'; } ?> /> Murajaah
                                        <input type="radio" value="Z" itemid="<?php echo $obj->id; ?>" name="student_<?php echo $obj->id; ?>" id="student_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($tahfizh_type == 'Z'){ echo 'checked="checked"'; } ?> /> Ziyadah
                                        <input type="radio" value="A" itemid="<?php echo $obj->id; ?>" name="student_<?php echo $obj->id; ?>" id="student_<?php echo $obj->id; ?>" class="present fn_single_attendnce" <?php if($tahfizh_type == 'A'){ echo 'checked="checked"'; } ?> /> Tidak ada
                                    </div>
                                    <div id="detail_shaff_<?php echo $obj->id; ?>" style="<?php if($tahfizh_type == 'Z' || $tahfizh_type == 'M') echo 'display:block'; else echo 'display:none' ?>">
                                        <select itemid="<?php echo $obj->id; ?>" id="shaff_<?php echo $obj->id; ?>" name="shaff_<?php echo $obj->id; ?>">
                                        <option>Jumlah Halaman</option>
                                        <option value="0.3" <?php if($tahfizh_shaff == '0.3') echo 'selected';?>>1/3 Halaman</option>
                                        <option value="0.5" <?php if($tahfizh_shaff == '0.5') echo 'selected';?>>1/2 Halaman</option>
                                        <option value="1" <?php if($tahfizh_shaff == '1') echo 'selected';?>>1 Halaman</option>
                                        <option value="1.3" <?php if($tahfizh_shaff == '1.3') echo 'selected';?>>1 1/3 Halaman</option>
                                        <option value="1.5" <?php if($tahfizh_shaff == '1.5') echo 'selected';?>>1 1/2 Halaman</option>
                                        <option value="2" <?php if($tahfizh_shaff == '2') echo 'selected';?>>2 Halaman</option>
                                        <option value="O" <?php if($tahfizh_shaff == 'O') echo 'selected';?>>Lainnya</option>
                                        </select>
                                        <div id="shaff_other_<?php echo $obj->id; ?>" style="<?php if($tahfizh_shaff == 'O') echo 'display:block'; else echo 'display:none'?>">
                                            <input type="text" id="shaff_o_<?php echo $obj->id; ?>" name="shaff_o_<?php echo $obj->id; ?>" value="<?php if(!empty($tahfizh_shaff_o)) echo $tahfizh_shaff_o;?>" style='width:45px'/> Halaman
                                        </div>
                                        <div class="shaff_note">
                                        <label for="shaff_note_<?php echo $obj->id; ?>">Catatan:</label>  
                                        <textarea class="shaff_note_textarea" id="shaff_note_<?php echo $obj->id; ?>" name="shaff_note_<?php echo $obj->id; ?>" /><?php if(!empty($tahfizh_shaff_note)) echo $tahfizh_shaff_note;?></textarea>
                                        </div>
                                    </div>
                                    </td>
                                    <td><input type="submit" itemid="<?php echo $obj->id; ?>" name="submit_tahfizh_<?php echo $obj->id; ?>"></td>
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
           } else {
            $("#detail_shaff_"+student_id).show();
           }
           
    }); 

    $("[name^='shaff']").on('change', function() {
        var val = $(this).val();
        var itemid = $(this).attr('itemid');
        $("#shaff_other_"+itemid).hide();
        if (val === "O"){
            $("#shaff_other_"+itemid).show();
        }
    });

    $("[name^='submit_tahfizh_']").on('click', function() {
        var itemid = student_id = $(this).attr('itemid');
        let type;
        let status;

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

        var shaff = $("#shaff_"+itemid).val();
        var shaff_other = $("#shaff_o_"+itemid).val();
        var shaff_note = $("#shaff_note_"+itemid).val();
        var tahfizhdate = Math.floor(datefix / 1000);

        if(type == 'A'){
            status = { type: type, date: tahfizhdate };
        } else {
            status = { type: type, date: tahfizhdate, shaff: shaff, shaffo : shaff_other, shaffn : shaff_note };
        }

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



