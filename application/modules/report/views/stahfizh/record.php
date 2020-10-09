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
               
            <?php  if (isset($student) && !empty($student)) { ?>
            <div class="x_content">             
                <div class="row">
                    <div class="col-sm-6 col-xs-6  col-sm-offset-3 col-xs-offset-3  layout-box">
                        <p>
                            <?php if(isset($school)){ ?>
                            <h4><?php echo $school->school_name; ?></h4>
                            <p> <?php echo $school->address; ?></p>
                            <?php } ?>
                            <h4>KARTU PENCAPAIAN TAHFIZH</h4> 
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
            
            <div class="x_content">
                <table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2" width="8%">Hari Tanggal</th>
                            <th colspan="2">Hafalan Baru</th>                                            
                            <th colspan="2">Muroja'ah</th>                                            
                            <th rowspan="2">Rawatib</th>                                            
                            <th rowspan="2">Dhuha</th>                                            
                            <th rowspan="2">Qiyam</th>                                            
                            <th rowspan="2">Puasa</th>                                            
                            <th rowspan="2">Infaq (Rp.)</th>                                            
                            <th rowspan="2">Nabung (Rp.)</th>                                            
                        </tr>
                        <tr>                           
                            <th width="16%">Catatan</th>                                            
                            <th width="8%">Nilai</th>                                            
                            <th width="16%">Catatan</th>                                            
                            <th width="8%">Nilai</th>                                            
                        </tr>
                    </thead>
                    <tbody id="fn_mark"> 
                       
                        <?php if (isset($student_record) && !empty($student_record)) { ?>
                        <?php foreach($student_record as $st){ ?>
                        <?php $gd = json_decode($st);
                            if(!empty($gd)){
                              $filltable = '';
                              foreach ($gd as $gda) {
                                $date = $gda->date;
                                $type = $gda->type;
                                $val = $gda->val;
                                $myday = date("l",$date);
                                $mydate = date("d-m-Y", $date);
                                $fz_catatan = ""; 
                                $fm_caatan = "";
                                $fz_val = "";
                                $fm_val = "";
                                                                  
                                 if($type == 'Z'){
                                      $valZ = $gda->shaff . $gda->shaffo . ' hal / ' . $gda->shaffn;
                                      $fz_catatan = $valZ;
                                      $fz_val     = $gda->shaffs . ' (' .get_predicate($gda->shaffs) . ')';
                                  }

                                  if($type == 'M'){
                                    $valM = $gda->shaff . $gda->shaffo . ' hal / ' . $gda->shaffn;
                                    $fm_catatan = $valM;
                                    $fm_val     = $gda->shaffs . ' (' .get_predicate($gda->shaffs) . ')';
                                  }

                                  if($type == 'raw'){
                                    $raw_val = "";
                                    $raw_val = $gda->val;  
                                  }

                                  if($type == 'dhu'){
                                    $dhu_val = "";
                                    $dhu_val = $gda->val;  
                                  }

                                  if($type == 'qiy'){
                                    $qiy_val = "";
                                    $qiy_val = $gda->val;  
                                  }

                                  if($type == 'siy'){
                                    $siy_val = "";
                                    $siy_val = $gda->val;  
                                  }

                                  if($type == 'inf'){
                                    $inf_val = "";
                                    $inf_val = $gda->val;  
                                  }

                                  if($type == 'nab'){
                                    $nab_val = "";
                                    $nab_val = $gda->val;  
                                  }
                                }
                                ?>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $myday; ?></td>
                                    <td><?php echo $fz_catatan; ?></td>
                                    <td><?php echo $fz_val; ?></td>
                                    <td><?php echo $fm_catatan; ?></td>
                                    <td><?php echo $fm_val; ?></td>
                                    <td><?php echo $raw_val; ?></td>
                                    <td><?php echo $dhu_val; ?></td>
                                    <td><?php echo $qiy_val; ?></td>
                                    <td><?php echo $siy_val; ?></td>
                                    <td><?php echo $inf_val; ?></td>
                                    <td><?php echo $nab_val; ?></td>
                                </tr>
                                <?php
                            }
                        }
                    } ?>
                            
                                           
                    </tbody>
                </table> 
                
           <div class="rowt"><div class="col-lg-12">&nbsp;</div></div>
            <div class="rowt">
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('principal'); ?>
                </div>
                <div class="col-xs-2 text-center">
                    &nbsp;
                </div>
                <div class="col-xs-4 text-center signature">
                    <?php echo $this->lang->line('class_teacher'); ?>
                </div>
            </div>
            
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

<style>
.table>thead>tr>th,.table>tbody>tr>td {
    padding: 2px;
}

</style>