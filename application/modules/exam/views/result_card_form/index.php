<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
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
            <?php if($formtype == 'bpi' || $formtype == 'character') { ?>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="item form-group">
                            <label for="level-choice">Pilih Level</label>
                            <select class="form-control" id="level" name="level">
                                <option value="0">-------</option>
                                <option <?php if(isset($_GET['l']) && $_GET['l'] == '1'){echo 'selected';} ?> value="1">Tingkat Dasar</option>
                                <option <?php if(isset($_GET['l']) && $_GET['l'] == '2'){echo 'selected';} ?> value="2">Tingkat Lanjut</option>
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
                <div class="row">
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
                </div>
            <?php } ?>
            </div>

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

             <?php  if ($formtype == 'tahfizh') { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="text-center align-middle">
                            <div class="row">
                                <div class="school-logo col-md-1">
                                    <?php if($school->logo){ ?>
                                        <img class="logo-report" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="80" />
                                    <?php } ?>
                                </div>
                                <div class="school-info col-md-11">
                                    <div class="top-school"><?php echo $school->school_parent; ?></div>
                                    <?php if(isset($school)){ ?>
                                    <div class="name-school"><?php echo $school->school_name; ?></div>
                                    <p> <?php echo $school->address; ?></p>
                                <?php } ?>
                                </div>
                            </div>

                            <hr class="style8" />

                            <h4><strong>تقريروتائج االمتحان الىهائي في تحسيه القرآن و تحفيظه</strong><h4>
                            <h5><strong>LAPORAN PENILAIAN UJIAN AKHIR SEMESTER TAHSIN DAN TAHFIDZ AL-QUR’AN</strong></h5>
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
                                <td style="text-align:left; width: 150px"><?php echo $student->class_name . ' ' . $student->section; ?> </td>
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
                                <div class="school-logo col-md-1">
                                    <?php if($school->logo){ ?>
                                        <img class="logo-report" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="80" />
                                    <?php } ?>
                                </div>
                                <div class="school-info col-md-11">
                                    <div class="top-school">Yayasan Ibadurrohman</div>
                                    <?php if(isset($school)){ ?>
                                    <div class="name-school"><?php echo $school->school_name; ?></div>
                                    <p> <?php echo $school->address; ?></p>
                                <?php } ?>
                                </div>
                            </div>

                            <hr class="style8" />

                            <h5><strong>LAPORAN PENCAPAIAN BPI (BINA PRIBADI ISLAM)</strong></h5>
                        </div>
                        <table id="datatable-responsive" class="table dt-responsive nowrap noborder" cellspacing="0" width="100%">
                            <tr>
                                <td style="text-align:left; width: 150px">Nama</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->name; ?></td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Tahun Pelajaran</td>
                                <td>2020/2021</td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width: 150px">NIS/NISN</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->roll_no; ?></td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Kelas/Semester</td>
                                <td><?php echo $student->class_name . ' ' . $student->section; ?> </td>
                            </tr>
                        </table>
                        
                    </div>
                </div>            
            </div>
             <?php } ?>

            <div class="x_content">
                <div class="row justify-content-center">

                <?php echo $html_table_character; ?>

                <?php echo $html_table_character3; ?>

                <?php echo $html_table_character2; ?>

                <?php echo $html_table_tahfizh; ?>

                </div>
    
            </div>
          
            <?php if($formtype == 'bpi' || $formtype == 'character') { ?>
                <div class="rowt"><div class="col-lg-12">&nbsp;</div></div>
                <div class="rowt">
                    <div class="col-xs-3 text-center">
                        <div class="knowing">
                            <p><br>Mengetahui<p>
                            <p>Mudir <?php echo $school->school_name; ?></p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_principal)) {
                                echo $school->adm_principal;
                            } ?>
                        </div>
                    </div>
                    <div class="col-xs-1 text-center">
                        &nbsp;
                    </div>
                    <div class="col-xs-3 text-center">
                        <div class="knowing">
                            <p><br/><br>Ketua BPI</p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_siebpi)) {
                                echo $school->adm_siebpi;
                            } ?>
                        </div>
                    </div>
                    <div class="col-xs-1 text-center">
                        &nbsp;
                    </div>
                    <div class="col-xs-4 text-center">
                        <div class="knowing">
                            <?php
                            $day = date("d");
                            $month = get_sign_date(date("m"));
                            $year = date("Y");
                            $signdate = $day . ' ' . $month . ' ' . $year;
                            ?>
                            <p><span class="date-sign">Tasikmalaya, <?php echo $signdate; ?></span><p>
                            <p>Guru Pembina BPI</p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_siebpi)) {
                                    echo $school->adm_siebpi;
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else if($formtype == 'tahfizh') { ?>
            <div class="rowt"><div class="col-lg-12">&nbsp;</div></div>
                <div class="rowt">
                    <div class="col-xs-3 text-center">
                        <div class="knowing">
                            <p>Orang Tua / Wali Santri</p>
                        </div>
                        <div class="signature">
                            ( .............................. )
                        </div>
                    </div>
                    <div class="col-xs-1 text-center">
                        &nbsp;
                    </div>
                    <div class="col-xs-3 text-center">
                        <div class="knowing">
                        <p><br>Mudir <?php echo $school->school_name; ?></p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_principal)) {
                                echo $school->adm_principal;
                            } ?>
                        </div>
                    </div>
                    <div class="col-xs-1 text-center">
                        &nbsp;
                    </div>
                    <div class="col-xs-4 text-center">
                        <div class="knowing">
                            <?php
                            $day = date("d");
                            $month = get_sign_date(date("m"));
                            $year = date("Y");
                            $signdate = $day . ' ' . $month . ' ' . $year;
                            ?>
                            <p><span class="date-sign">Tasikmalaya, <?php echo $signdate; ?></span><p>
                            <p>Muhafizh</p>
                        </div>
                        <div class="signature">
                            <?php if(isset($school->adm_sietahfizh)) {
                                    echo $school->adm_sietahfizh;
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
            <div class="row no-print">
                <div class="col-xs-12 text-right">
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
    if(s == "1" || s == "2") {
        <?php if($formtype == 'tahfizh') { ?>
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
<style>
.table>thead>tr>th,.table>tbody>tr>td {
    padding: 2px;
}
.mgtop100 {
    margin-top: 100px;
    float: left; 
    width: 100%;
}
hr.style8 {
    height: auto;
	border-top: 5px solid #000;
	border-bottom: 1px solid #fff;
}
hr.style8:after {
	content: '';
	display: block;
	margin-top: 2px;
	border-top: 2px solid #000;
	border-bottom: 1px solid #fff;
}
.name-school,
.top-school {
    font-weight: bold;
}
.name-school {
    text-transform: uppercase;
    font-size: 18px;
}
.top-school {
    font-size: 14px;
}
.noborder td {
    border: 0px !important;
}
table tr td,
table th {
    text-align: center;
}
@media print {
  @page { margin: 0; }
  body { margin: 0cm; }
}
.knowing p {
    margin: 0;
}
.knowing {
    margin-bottom: 50px;
}

</style>