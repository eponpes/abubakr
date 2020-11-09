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
                $form_url = site_url('exam/mark/form/bpi/'.$url_bind);
                $form_url_s = substr(site_url('exam/mark/form/bpi/'.$url_bind_s), 0, -5);
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
            $form_url = site_url('exam/mark/form/bpi/'.$url_bind);
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
                <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="item form-group">
                        <select id="level" name="level">
                            <option>Pilih Level</option>
                            <option <?php if(isset($_GET['l']) && $_GET['l'] == '1'){echo 'selected';} ?> value="1">Tingkat Dasar</option>
                            <option <?php if(isset($_GET['l']) && $_GET['l'] == '2'){echo 'selected';} ?> value="2">Tingkat Lanjut</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <div class="item form-group">
                        <select id="quarter" name="quarter">
                            <option>Pilih Quarter</option>
                            <option <?php if(isset($_GET['q']) && $_GET['q'] == 'Q1'){echo 'selected';} ?> value="Q1">Q1</option>
                            <option <?php if(isset($_GET['q']) && $_GET['q'] == 'Q2'){echo 'selected';} ?> value="Q2">Q2</option>
                            <option <?php if(isset($_GET['q']) && $_GET['q'] == 'Q3'){echo 'selected';} ?> value="Q3">Q3</option>
                            <option <?php if(isset($_GET['q']) && $_GET['q'] == 'Q4'){echo 'selected';} ?> value="Q4">Q4</option>
                        </select>
                        </div>
                    </div>
                </div>
                <?php 
                if(!empty($_GET['q'])){
                    if(!empty($characters)) {
                        foreach ($characters as $chara){
                            echo '<h4><strong>'.$chara['name'].'</strong></h4>';
                            if(!empty($chara['indicator'])){
                                $number = 1;
                                foreach($chara['indicator'] as $indicator => $value){
                                    echo '<div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">';
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
                                    '<input type="radio" '.$onevalue.' name="indicator['.$indicator.']" value="1"> 1
                                    <input type="radio" '.$twovalue.' name="indicator['.$indicator.']" value="2"> 2
                                    <input type="radio" '.$threevalue.' name="indicator['.$indicator.']" value="3"> 3
                                    <input type="radio" '.$fourvalue.' name="indicator['.$indicator.']" value="4"> 4
                                    ';
                                    echo '</div></div></div>';
                                    $number++;
                                }
                            }
                        }
                    }
                    ?>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="submit" id="submit" class="btn btn-custom" name="submit" value="Kirim Nilai">
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

<!-- Super admin js START  -->
<script type="text/javascript">
        
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
    $('#level').change(function(){
        var l = this.value;
        window.location = "<?php echo $form_url; ?>?q=Q1&l="+l;
        /*$('#addmarkform').submit();*/
    });
    $('#quarter').change(function(){
        var l = $("#level option:selected").val();
        var q = this.value;
        window.location = "<?php echo $form_url; ?>?q="+q+"&l="+l;
        /*$('#addmarkform').submit();*/
    });
    $("#send").on("click", function(e){
        e.preventDefault();
        var student_id = $("#student_id option:selected").val();
        var fullurl = "<?php echo $form_url_s; ?>/"+student_id+".html?q=Q1&l=1";
        $('#resultcard').attr('action', fullurl).submit();
    });
</script>
