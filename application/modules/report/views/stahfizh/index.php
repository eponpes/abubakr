<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('student_tahfizh_report'); ?></small></h3>                
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
             <div class="x_content filter-box no-print"> 
                <?php echo form_open_multipart(site_url('report/stahfizh'), array('name' => 'stahfizh', 'id' => 'stahfizh', 'class' => 'form-horizontal form-label-left'), ''); ?>
                <div class="row">                    
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        
                        <?php $this->load->view('layout/school_list_filter'); ?>
                        
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group"> 
                                <?php echo $this->lang->line('academic_year'); ?> <span class="required">*</span>
                                <select  class="form-control col-md-7 col-xs-12" name="academic_year_id" id="academic_year_id" required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php foreach ($academic_years as $obj) { ?>
                                    <?php $running = $obj->is_running ? ' ['.$this->lang->line('running_year').']' : ''; ?>
                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($academic_year_id) && $academic_year_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->session_year; echo $running; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group"> 
                                <div><?php echo $this->lang->line('class'); ?> <span class="required">*</span></div>
                                <select  class="form-control col-md-7 col-xs-12" name="class_id" id="class_id"  required="required" onchange="get_section_by_class('', this.value,'');">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php if(isset($classes) && !empty($classes)) { ?>
                                        <?php foreach ($classes as $obj) { ?>
                                        <option value="<?php echo $obj->id; ?>" <?php if(isset($class_id) && $class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php /*
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="item form-group"> 
                                <div><?php echo $this->lang->line('section'); ?> </div>
                                <select  class="form-control col-md-7 col-xs-12" name="section_id" id="section_id"  >
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                    
                                </select>
                            </div>
                        </div> */ ?>

                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="item form-group"> 
                                <div><?php echo $this->lang->line('month'); ?> <span class="required">*</span></div>
                                <select  class="form-control col-md-7 col-xs-12" name="month" id="month"  required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>--</option>
                                    <?php $months = get_months(); ?>
                                    <?php foreach ($months as $key=>$value) { ?>
                                    <option value="<?php echo $key; ?>" <?php if(isset($month) && $month == $key){ echo 'selected="selected"';} ?>><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
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

            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <?php if(isset($school) && !empty($school)){ ?>
                    <?php /*<div class="x_content">             
                       <div class="row">
                           <div class="col-sm-3  col-xs-3">&nbsp;</div>
                           <div class="col-sm-6  col-xs-6 layout-box">
                               <div>
                                  <?php if($school->logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" /> 
                                 <?php }else if($school->frontend_logo){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt="" /> 
                                 <?php }else{ ?>                                                        
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->brand_logo; ?>" alt=""  />
                                 <?php } ?>
                                   <h4><?php echo $school->school_name; ?></h4>
                                   <p><?php echo $school->address; ?></p>
                                   <p><?php echo $this->lang->line('month'); ?> : <?php echo $this->lang->line($month); ?></p> 
                                   <h3 class="head-title ptint-title" style="width: 100%;"><i class="fa fa-bar-chart"></i><small> <?php echo $this->lang->line('student_tahfizh_report'); ?></small></h3>                
                                   <div class="clearfix">&nbsp;</div>
                               </div>
                           </div>
                            <div class="col-sm-3  col-xs-3">&nbsp;</div>
                       </div>            
                    </div> */ ?>

                    <div class="x_content">             
                        <div class="row">
                            <div class="col-sm-3  col-xs-3">&nbsp;</div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="text-center align-middle">
                                    <div class="row">
                                        <div class="school-logo col-sm-1 col-xs-2">
                                            <?php if($school->logo){ ?>
                                                <img class="logo-report" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt="" width="80" />
                                            <?php } ?>
                                        </div>
                                        <div class="school-info col-sm-10 col-xs-9">
                                            <div class="top-school"><?php echo $school->school_parent; ?></div>
                                            <?php if(isset($school)){ ?>
                                            <div class="name-school"><?php echo $school->school_name; ?></div>
                                            <p> <?php echo $school->address; ?></p>
                                        <?php } ?>
                                        </div>
                                        <div class="col-sm-1 col-xs-1">&nbsp;</div>
                                    </div>

                                    <hr class="style8" />
                                    <h4><strong>تقرير نتائج الامتحان النهائي في تحسين القرآن وتحفيظه</strong><h4>
                                    <h5><strong>LAPORAN ABSENSI & PENCAPAIAN TAHFIDZ</strong></h5>
                                                                
                                </div>
                                <table id="datatable-responsive" class="table dt-responsive nowrap noborder" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="text-align:left; width: 100px">Periode</td>
                                        <td style="text-align:left; width: 10%">: <?php echo $this->lang->line($month); ?></td>
                                        <td style="text-align:left; width: 10%"></td>
                                        <td style="text-align:left; width: 150px">Tahun Akademik</td>
                                        <td style="text-align:left; width: 10%">: <?php echo $session ?></td>
                                        <td style="text-align:left; width: 10%"></td>
                                        <td style="text-align:left; width: 150px">Kelas / Bagian</td>
                                        <td style="text-align:left; width: 15%">: <?php echo $class_section_name; ?></td>
                                    </tr>
                                </table>
                                
                            </div>
                        </div>            
                    </div>
                    <?php } ?>
                    
                    <ul  class="nav nav-tabs bordered no-print">
                        <li class="active"><a href="#tab_tabular"   role="tab" data-toggle="tab"   aria-expanded="true"><i class="fa fa-list-ol"></i> <?php echo $this->lang->line('tabular_report'); ?></a> </li>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in active" id="tab_tabular" >
                            <div class="x_content table-responsive">
                                                            
                            <table class="datatable-responsive table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <td><?php echo $this->lang->line('student'); ?> <i class="fa fa-long-arrow-down"></i> - <?php echo $this->lang->line('date'); ?> <i class="fa fa-long-arrow-right"></i></td>
                                        <?php for($i = 1; $i<=$days; $i++ ){ ?>
                                            <td><?php echo $i; ?></td>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>   
                                    <?php  $count = 1; if(isset($students) && !empty($students)){ ?>
                                        <?php foreach($students as $obj){ 
                                        $buildid = 'report/srecord/'.$obj->id.'/'.$school_id.'/'.$academic_year_id.'/'.$class_id.'/'.$month_number;
                                            ?>
                                        <tr>
                                            <td class="text-left">
                                                <?php echo $obj->name; ?> <a class="no-print btn btn-xs btn-success" href="<?php echo site_url($buildid); ?>">View</a>
                                            </td>
                                            <?php $attendance = get_student_monthly_tahfizh($school_id, $obj->id, $academic_year_id, $class_id, $section_id, $month_number ,$days); ?>
                                            <?php if(!empty($attendance)){ ?>
                                                <?php foreach($attendance AS $key ){ ?>
                                                    <?php 
                                                        $getdata = json_decode($key);
                                                        $label = '';
                                                        $datatitlez = '';
                                                        $datatitlem = '';
                                                        foreach ($getdata as $gda) {
                                                            if($gda->type == "A"){
                                                                $label = "A";
                                                            } else {
                                                                if($gda->type == "M"){
                                                                    $tahfizhm_type = !empty($gda->type) ? $gda->type : "";
                                                                    $tahfizhm_shaff = !empty($gda->shaff) ? $gda->shaff : "";
                                                                    $tahfizhm_shaff_o = !empty($gda->shaffo) ? $gda->shaffo : "";
                                                                    $tahfizhm_shaff_note = !empty($gda->shaffn) ? $gda->shaffn : "";
                                                                    $tahfizhm_shaff_score = !empty($gda->shaffs) ? $gda->shaffs : "";
                                                                    $labelm = "Murojaah";
                                                                    $label .= $tahfizhm_type;
                                                                    $labelshaffm = $tahfizhm_shaff . ' hal';
                                                                    if(!empty($tahfizhm_shaff_o)){
                                                                        $labelshaffm = $tahfizhm_shaff_o . ' hal';
                                                                    }
                                                                    $datatitlem = $labelm." ".$labelshaffm." / ".$tahfizhm_shaff_note." (".$tahfizhm_shaff_score . ")";
                                                                }
                                                                if($gda->type == "Z"){
                                                                    $tahfizhz_type = !empty($gda->type) ? $gda->type : "";
                                                                    $tahfizhz_shaff = !empty($gda->shaff) ? $gda->shaff : "";
                                                                    $tahfizhz_shaff_o = !empty($gda->shaffo) ? $gda->shaffo : "";
                                                                    $tahfizhz_shaff_note = !empty($gda->shaffn) ? $gda->shaffn : "";
                                                                    $tahfizhz_shaff_score = !empty($gda->shaffs) ? $gda->shaffs : "";
                                                                    $labelz = "Ziyadah";
                                                                    $label .= $tahfizhz_type;
                                                                    $labelshaffz = $tahfizhz_shaff . ' hal';
                                                                    if(!empty($tahfizhz_shaff_o)){
                                                                        $labelshaffz = $tahfizhz_shaff_o . ' hal';
                                                                    }
                                                                    $datatitlez = $labelz." ".$labelshaffz." / ".$tahfizhz_shaff_note." (".$tahfizhz_shaff_score .")";
                                                                }

                                                            }
                                                            
                                                        }
                                                        if(!empty($datatitlem) || !empty($datatitlez)){
                                                            $datatitle = $datatitlem . "<br/>" . $datatitlez;
                                                        } else {
                                                            $datatitle = "";
                                                        }
                                                        
                                                    ?>

                                                    <td data-toggle="tooltip" data-html="true" title="<?php echo $datatitle; ?>"> <?php echo $label ? $label : '<i style="color:red;">--</i>'; ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?>                                     
                                    <?php }else{ ?>
                                        <tr><td colspan="32" class="text-center"><?php echo $this->lang->line('no_data_found'); ?></td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>

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
                                       &nbsp;
                                    </div>
                                    <div class="col-xs-1 text-center" style="width: 5.15%">
                                        &nbsp;
                                    </div>
                                    <div class="col-xs-3 text-center" style="width: 28%">
                                        &nbsp;
                                    </div>
                                    <div class="col-xs-1 text-center" style="width: 5.15%">
                                        &nbsp;
                                    </div>
                                    <div class="col-xs-3 text-center" style="width: 28%">
                                        <div class="knowing">
                                            <?php if($clientcode == 'ymk' || $clientcode == 'ymn') { ?>
                                            <?php
                                            $imagepath1 = IMG_URL . 'signature/'.$myteacher->id.'.png';
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
                                            <p>Muhafizh/ah</p>
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
                                            <p>Kasie Tahfidz</p>
                                            <?php } ?>
                                        </div>
                                        <div class="signature">
                                            <?php 
                                            if($clientcode == 'ymk' || $clientcode == 'ymn') {
                                                if(isset($myteacher)) {
                                                    echo ucwords(strtolower($myteacher->name));
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
                            </div>
                        </div>                        
                      
                    </div>
                </div>
            </div>
            
             <div class="row no-print">
                <div class="col-xs-12 text-right">
                    <button class="btn btn-default " onclick="window.print();"><i class="fa fa-print"></i> <?php echo $this->lang->line('print'); ?></button>
                </div>
            </div>
            
        </div>
    </div>
</div>
 <script type="text/javascript">
    
    $("document").ready(function() {
         <?php if(isset($school_id) && !empty($school_id)){ ?>
            $(".fn_school_id").trigger('change');
         <?php } ?>
    });
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();
        var class_id = '';
        var section_id = '';
        var academic_year_id = '';
        
        <?php if(isset($school_id) && !empty($school_id)){ ?>
            class_id =  '<?php echo $class_id; ?>';
            section_id =  '<?php echo $section_id; ?>';
            academic_year_id =  '<?php echo $academic_year_id; ?>'; 
         <?php } ?>          
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line('select_school'); ?>');
           return false;
        }
        
        get_academic_year_by_school(school_id, academic_year_id);
        get_class_by_school(school_id, class_id, section_id);
       
    });
    
    
        
    function get_academic_year_by_school(school_id, academic_year_id){       
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_academic_year_by_school'); ?>",
            data   : { school_id:school_id, academic_year_id :academic_year_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                    $('#academic_year_id').html(response); 
               }
            }
        });
   }  
    
    
    
    function get_class_by_school(school_id, class_id, section_id){       
        
        if(!school_id){
            school_id = $('#school_id').val();
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
                   get_section_by_class(school_id, class_id, section_id);
               }
            }
        });         
    }
    
    function get_section_by_class(school_id, class_id, section_id){       
        
        if(!school_id){
            school_id = $('#school_id').val();
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
    
    $("#sattendance").validate();  
</script>
<link href="<?php echo CSS_URL; ?>print.css" rel="stylesheet">