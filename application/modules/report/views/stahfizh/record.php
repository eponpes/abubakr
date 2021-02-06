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
            <?php /*<div class="x_content">             
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
                            <?php echo $this->lang->line('roll_no'); ?> : <?php echo !empty($student->roll_no)?$student->roll_no:''; ?>
                        </p>
                    </div>
                </div>            
            </div> */ ?>

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
                            <h5><strong>LAPORAN PENCAPAIAN TAHFIDZ AL-QUR’AN DAN MUTABAAH YAUMIYAH</strong></h5>
                                                        
                        </div>
                        <table id="datatable-responsive" class="table dt-responsive nowrap noborder" cellspacing="0" width="100%">
                            <tr>
                                <td style="text-align:left; width: 150px">Nama</td>
                                <td style="text-align:left; width: 30%">: <?php echo $student->name; ?> ( <?php echo $student->roll_no; ?> )</td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Kelas/Semester</td>
                                <td style="text-align:left; width: 150px"><?php echo $student->class_name . ' ' . $student->section; ?> </td>
                            </tr>
                            <tr>
                                <td style="text-align:left; width: 150px">Periode</td>
                                <td style="text-align:left; width: 30%">: <?php echo get_sign_date($month); ?></td>
                                <td style="text-align:left; width: 10%"></td>
                                <td style="text-align:left; width: 20%">Tahun Pelajaran</td>
                                <td style="text-align:left; width: 150px"><?php echo $session; ?></td>
                            </tr>
                        </table>
                        
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
                        <?php $no=1; foreach($student_record as $st){ ?>
                        <?php $gd = json_decode($st);
                            if(!empty($gd)){
                              $filltable = '';
                              foreach ($gd as $gda) {
                                $date = $gda->date;
                                $type = $gda->type;
                                $val = !empty($gda->val)?$gda->val:'';
                                $myday = date("l",$date);
                                $mydate = date("d-m-Y", $date);
                                $fz_catatan = ""; 
                                $fm_caatan = "";
                                $fz_val = "";
                                $fm_val = "";
                                                                  
                                 if($type == 'Z'){
                                      $totalziyadah = $gda->shaff . $gda->shaffo . ' hal / ' . $gda->shaffn;
                                      $fz_catatan = $totalziyadah;
                                      $fz_val     = $gda->shaffs . ' (' .get_predicate($type, $gda->shaffs) . ')';
                                  }

                                  if($type == 'M'){
                                    $totalmurajaah = $gda->shaff . $gda->shaffo . ' hal / ' . $gda->shaffn;
                                    $fm_catatan = $totalmurajaah;
                                    $fm_val     = $gda->shaffs . ' (' .get_predicate($type, $gda->shaffs) . ')';
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
                                    <td><?php echo $no; ?></td>
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
                                $no++;
                            }
                        }
                    } ?>
                            
                                           
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
                        <div class="knowing">
                            <p>Orang Tua / Wali Santri</p>
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
                            $imagepath = IMG_URL . 'signature/1.png';
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
                        <p>Mudir PPTQ</p>
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

<link href="<?php echo CSS_URL; ?>print.css" rel="stylesheet">