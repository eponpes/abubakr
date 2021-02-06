<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Marksheet.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Marksheet
 * @description     : Manage exam resultcard sheet.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Resultcardform extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Resultcard_Model', 'resultcardform', true);
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "result card" user interface                 
    *                    with data filter option
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        //check_permission(VIEW);

        if ($_POST) {

            if($this->session->userdata('role_id') == STUDENT){
                
                $student = get_user_by_role($this->session->userdata('role_id'), $this->session->userdata('id'));
                
                $school_id = $student->school_id;
                $class_id = $student->class_id;
                $section_id = $student->section_id;
                $student_id = $student->id;
                
            }else{
                
                $school_id = $this->input->post('school_id');
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_id = $this->input->post('student_id');
                
                $std = $this->resultcardmahad->get_single('students', array('id'=>$student_id));
                $student = get_user_by_role(STUDENT, $std->user_id);
            }
            
            $school = $this->resultcardmahad->get_school_by_id($school_id);
            $academic_year_id = $this->input->post('academic_year_id');
            $this->data['exams'] = $this->resultcardmahad->get_list('exams', array('school_id'=>$school_id, 'status' => 1, 'academic_year_id' => $academic_year_id, 'group_id' => 2), '', '', '', 'id', 'ASC');
            $this->data['exams_tahfizh'] = $this->resultcardmahad->get_list('exams', array('school_id'=>$school_id, 'status' => 1, 'academic_year_id' => $academic_year_id, 'group_id' => 1), '', '', '', 'id', 'ASC');
           
            $this->data['school'] = $school;
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['student'] = $student;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['student_id'] = $student_id;
            $this->data['final_result'] = $this->resultcardmahad->get_final_result($school_id, $academic_year_id, $class_id, $section_id, $student_id);
            
            $class = $this->resultcardmahad->get_single('classes', array('id'=>$class_id));
            create_log('Has been filter result card for class: '. $class->name. ', '. $this->data['student']->name );
        }
        
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');            
            $this->data['classes'] = $this->resultcardmahad->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['academic_years'] = $this->resultcardmahad->get_list('academic_years', $condition, '', '', '', 'id', 'ASC');
        }

        $this->layout->title($this->lang->line('manage_result_card') . ' | ' . SMS);
        $this->layout->view('result_card_mahad/index', $this->data);
    }
    
    public function all() {
        check_permission(VIEW);

        if ($_POST) {

                
            $school_id = $this->input->post('school_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
                        
            $school = $this->resultcardmahad->get_school_by_id($school_id);
            $academic_year_id = $this->input->post('academic_year_id');
            
            $students = $this->resultcardmahad->get_student_list($school_id, $class_id, $section_id, $academic_year_id);
            $this->data['exams']    = $this->resultcardmahad->get_list('exams', array('school_id'=>$school_id, 'status' => 1, 'academic_year_id' => $academic_year_id), '', '', '', 'id', 'ASC');
           
            $this->data['school'] = $school;
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['students'] = $students;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            
            $class = $this->resultcardmahad->get_single('classes', array('id'=>$class_id));
            create_log('Has been filter result card for class: '. $class->name );
        }
        
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');            
            $this->data['classes'] = $this->resultcardmahad->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['academic_years'] = $this->resultcardmahad->get_list('academic_years', $condition, '', '', '', 'id', 'ASC');
        }

        $this->layout->title($this->lang->line('manage_all_result_card') . ' | ' . SMS);
        $this->layout->view('result_card/all', $this->data);
        
    }

    public function view($type = null, $school_id = null, $academic_year_id = null, $class_id = null, $student_id = null) {
        $this->data['clientcode'] = $this->global_setting->client_code;
        //check_permission(VIEW);

        $levelchar = $_GET['l'];
        $semesterchar = $_GET['s'];
        $periodchar = $_GET['p'];

        $this->data['formtype'] = $type;

        $data_character = get_character_indicator($levelchar);

        $mutaarray = array('pray', 'dhuha', 'tilawah', 'qiyam', 'rawatib', 'dzikir', 'present', 'sick', 'permit', 'alpha');
        $mutabaah = array('pray', 'duhua', 'tilawah', 'qiyam', 'rawatib', 'dzikir');
        $targetmutabaah = array(
            'pray' => '5x per hari',
            'dhuha' => '7x per pekan',
            'tilawah' => '7 juz per pekan',
            'qiyam' => '7x per pekan',
            'rawatib' => '4x per hari',
            'dzikir' => '2x per hari',
            'book' => '10hal per pekan',
            'infaq' => '1x per pekan'
        );
        $presence = array('present', 'permit', 'sick', 'alpha');

        $this->data['characters'] = $data_character;
        
        if (!empty($school_id) && !empty($class_id) && !empty($student_id) && !empty($academic_year_id)) {

            if($this->session->userdata('role_id') == STUDENT){
                
                $student = get_user_by_role($this->session->userdata('role_id'), $this->session->userdata('id'));
                $school_id = $student->school_id;
                $class_id = $student->class_id;
                //$section_id = $student->section_id;
                $student_id = $student->id;
                
            }else{
                
                $school_id = $school_id;
                $class_id = $class_id;
                //$section_id = $section_id;
                $student_id = $student_id;
                
                $std = $this->resultcardform->get_single('students', array('id'=>$student_id));
                $student = get_user_by_role(STUDENT, $std->user_id);
            }

            $teacher_id = '';
            if($type == 'tahfizh' || $type == 'tahsin'){
                $teacher_id = $student->class_tahfizh_id;
            } else if($type == 'bpi' || $type == 'character'){
                $teacher_id = $student->class_bpi_id;
            }
            $this->data['myteacher'] = '..............';
            $myteacher = $this->resultcardform->get_single('teachers', array('id'=>$teacher_id));
            if(!empty($myteacher)){
                $this->data['myteacher'] = $myteacher;
            }

            $school = $this->resultcardform->get_school_by_id($school_id);
            $exam = get_mark_form_results($school_id, $academic_year_id, $class_id, $student_id, $levelchar, $periodchar); 

            if($type == 'bpi'){
                $totalsm1_1 = 0;
                $totalsm2_1 = 0;
                foreach($mutaarray as $mut){ 
                    $total[1][$mut] = 0;
                    $total[2][$mut] = 0;
                }

                foreach($exam as $mex){
                    
                    $add1 = $add2 = $add3 = $add4 = $add5 = $add6 = $add7 = 0;
                    foreach($mutaarray as $muto){ 
                        ${"m" . $muto} = 0;
                    }
                    
                    $mark1 = $mark2 = $mark3 = $mark4 = $mark5 = $mark6 = $mark7 =  0;
                    $values = json_decode($mex->value, true);
                    $values2 = json_decode($mex->value2, true);
                    
                    foreach($values as $eval){
                        $get_first = substr($eval['id'], 0, 1);
                        switch($get_first){
                            case 1:
                            $mark1 += $eval['mark'];
                            $add1++;
                            break;
                            case 2:
                            $mark2 += $eval['mark'];
                            $add2++;
                            break;
                            case 3:
                            $mark3 += $eval['mark'];
                            $add3++;
                            break;
                            case 4:
                            $mark4 += $eval['mark'];
                            $add4++;
                            break;
                            case 5:
                            $mark5 += $eval['mark'];
                            $add5++;
                            break;
                            case 6:
                            $mark6 += $eval['mark'];
                            $add6++;
                            break;
                            case 7:
                            $mark7 += $eval['mark'];
                            $add7++;
                            break;
                        }     
                    }

                    foreach($values2 as $eval2){
                            foreach($mutaarray as $mute){ 
                                if($eval2['name'] == $mute) {
                                    ${"m" . $mute} = $eval2['mark'];
                                }
                            }
                    }
                    

                    // Semester Data
                    if($mex->period == 'Q1' || $mex->period == 'Q2'){
                        $totalsm1_1 += $mark1/$add1;
                        $totalsm1_2 += $mark2/$add2;
                        $totalsm1_3 += $mark3/$add3;
                        $totalsm1_4 += $mark4/$add4;
                        $totalsm1_5 += $mark5/$add5;
                        $totalsm1_6 += $mark6/$add6;
                        $totalsm1_7 += $mark7/$add7;
                        foreach($mutaarray as $muti){ 
                            $total[1][$muti] += ${"m" . $muti};
                        }
                        
                    } else if($mex->period == 'Q3' || $mex->period == 'Q4'){
                        $totalsm2_1 += $mark1/$add1;
                        $totalsm2_2 += $mark2/$add2;
                        $totalsm2_3 += $mark3/$add3;
                        $totalsm2_4 += $mark4/$add4;
                        $totalsm2_5 += $mark5/$add5;
                        $totalsm2_6 += $mark6/$add6;
                        $totalsm2_7 += $mark7/$add7;
                        foreach($mutaarray as $muti){ 
                            $total[2][$muti] += ${"m" . $muti};
                        }
                    }
                }
                
                $semester = isset($_GET['s'])?$_GET['s']:1;

                // NILAI SEMESTER 1
                $levelof = array('1'=>'Dasar', '2'=>'Lanjut');
                
                $table_character .= 
                '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead><tr><th>No</th><th>Karakter</th><th>Nilai</th></tr></thead>
                    <tbody>
                ';
                $number = 1;
                foreach($data_character as $char7){
                    if(empty($periodchar)){
                        $totalsmmark = number_format(${"totalsm". $semester."_".$number}, 1);
                    } else {
                        $totalsmmark = number_format(${"totalsm". $semester."_".$number}, 1);
                    }

                    $table_character .= '<tr><td>'.$number.'</td><td>'.$char7['name'].'</td><td>'.get_markform_score($totalsmmark).'</td></tr>';
                    $number++;
                }
                $table_character .= '</tbody></table>';

                $this->data['html_table_character'] = $table_character;

                $thadd = '';
                if(!empty($periodchar)){
                    $thadd = '<th>Pencapaian</th>';
                }
                $table_character2 = 
                '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead><tr><th>No</th><th>Aktivitas Amal</th><th>Target</th>'.$thadd.'<th>Capaian</th></tr></thead>
                    <tbody>
                ';
                $table_character3 = 
                '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead><tr><th>No</th><th>Ketidakhadiran</th><th>Deskripsi</th><th rowspan="4" style="text-align: center; vertical-align: middle; width: 40%">Jumlah pertemuan pembinaan dalam 1 semester ini</th></tr></thead>
                    <tbody>
                ';

                $number2 = 1;
                $number3 = 1;
                
                foreach($mutaarray as $muta){
                    $tdadd = '';
                    $tdtarget = '';
                    $tdtarget = '<td>'.$targetmutabaah[$muta].'</td>';
                    if(in_array($muta, $mutabaah)){
                        if(empty($periodchar)){
                            $totalsm = $total[$semester][$muta];
                        } else {
                            $totalsm = $total[$semester][$muta];
                            $tdadd = '<td>'.${"m" . $muta}.'</td>';
                        }
                        
                        $table_character2 .= '<tr><td>'.$number2.'</td><td>'.translate($muta).'</td>'.$tdtarget.$tdadd.'<td>'.get_muta_score($muta, $totalsm).'</td></tr>';
                        $number2++;
                    } else if(in_array($muta, $presence)){
                        $totalsm = $total[$semester][$muta];
                        if($muta != "present") {
                            $gettd = '';
                            if($number3 == 1) {
                                $gettd = '<td rowspan="0" style="text-align: center; vertical-align: middle;">'.$total[$semester]['present'].' kali</td>';
                            }
                            $table_character3 .= '<tr><td>'.$number3.'</td><td>'.translate($muta).'</td><td>'.get_muta_score($muta, $totalsm).'</td>'.$gettd.'</tr>';
                            $number3++;
                        }
                        
                        
                    }
                    
                }

                $table_character2 .= '</tbody></table>';
                $table_character3 .= '</tbody></table>';

                $this->data['html_table_character2'] = $table_character2;
                $this->data['html_table_character3'] = $table_character3;
            } else if($type == 'character'){
                $markvalues2 = array();
                $gamma = array();
                foreach($exam as $mex){
                    $values = json_decode($mex->value, true);
                    $values2 = json_decode($mex->value2, true);

                    foreach($values as $eval){
                        $gamma[$eval['id']] = $eval['mark'];
                    }

                    foreach($values2 as $eval2){
                        if($eval2['name'] == 'charnote'){
                            $markvalues2['charnote'] = $eval2['mark'];
                        }
                    }

                    
                }

                $table_character .= 
                '<table id="datatable-responsive" style="border:1px solid black" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="7">No</th>
                            <th rowspan="7">Karakter</th>
                            <th rowspan="7">Indikator</th>
                            <th colspan=3>Penilaian</th>
                        </tr>
                        <tr>
                            <th>Masih Perlu dikembangkan</th>
                            <th>Mulai berkembang</th>
                            <th>Sudah berkembang dengan baik</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                $numb = 1;
                foreach($data_character as $charid => $charval){
                    $charname = $charval['name'];
                    $indicators = $charval['indicator']; // array
                    $countind = count($charval['indicator'])+1;
                    $table_character .= '<tr><td rowspan="'.$countind.'">'.$numb.'</td><td rowspan="'.$countind.'">'.$charname.'</td></tr>';
                    foreach($indicators as $ind => $inval){
                        $nilai = $gamma[$ind];
                        $nilai1 = ($nilai == 2)?'&#10004;':'';
                        $nilai2 = ($nilai == 3)?'&#10004;':'';
                        $nilai3 = ($nilai == 4)?'&#10004;':'';
                        $table_character .= '<tr><td>'.$inval.'</td><td>'.$nilai1.'</td><td>'.$nilai2.'</td><td>'.$nilai3.'</td></tr>';
                    }
                    $numb++;
                }

                $table_character .= '<tr><td colspan="6"><b>Saran Pengembang</b><br/>'.$markvalues2['charnote'].'</td></tr>';

                $table_character .= '</tbody></table>';

                $this->data['html_table_character'] = $table_character;

                $this->data['markvalues2'] = $markvalues2;

            } else if ($type == 'tahfizh') {
                if($this->data['clientcode'] == 'ymk' || $this->data['clientcode'] == 'ymn'){
                    $penilaian = [
                        'adab' => ['Adab', 'adabnote'],
                        'murajaah' => ['Murajaah', 'murajaahnote'],
                        'tahsin' => ['Tahsin', 'tahsindesk'],
                        'target' => ['Pencapaian Target Hafalan', 'targetnote'],
                    ];
                    
                    foreach($exam as $mex){
                        $totalmarkjuz = 0;
                        $totaladd = 0;
                        $gamma = array();
                        $gamma2 = array();
                        $values = json_decode($mex->value, true);
                        $values2 = json_decode($mex->value2, true);
                        $class_name = $mex->class_name;
                        $class_no = $mex->class_no;

    
                        foreach($values as $eval){
                            $totalmarkjuz += $eval['mark'];
                            $totaladd++;
                            $gamma2[$eval['surat']] = array('ayat' => $eval['ayat'], 'mark' => $eval['mark']);
                        }

                        foreach($values2 as $eval2){
                            if($eval2['name'] == 'targettahfizh'){
                                $gamma[$eval2['name']] = json_decode($eval2['mark']);
                            } else {
                                $gamma[$eval2['name']] = $eval2['mark'];
                            }
                            
                        }
                    }
    
                    $pembagi = 0;
                    if(!empty($gamma['tapan'])){
                        $totalnilaimark += $gamma['tapan'];
                        $pembagi++;
                    }
                    if(!empty($gamma['gunnah'])){
                        $totalnilaimark += $gamma['gunnah'];
                        $pembagi++;
                    }
                    if(!empty($gamma['vokal'])){
                        $totalnilaimark += $gamma['vokal'];
                        $pembagi++;
                    }
                    if(!empty($markvalues2['sukun'])){
                        $totalnilaimark += $gamma['sukun'];
                        $pembagi++;
                    }
                    $totaltahsin = round($totalnilaimark / $pembagi, 1);
                    
                    $totaltahfizh = round($totalmarkjuz / $totaladd, 1);
    
                    //print_r($gamma);die();
                    
                    $table_ziyadah .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Aspek</th>
                                <th>Predikat</th>
                                <th>Deskripsi Kemajuan Belajar</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $a=1;
                    foreach($penilaian as $pen => $getpen){
                        $labelin = $getpen[0];
                        $labelval = get_predicate($pen, $gamma[$pen]);
                        $labeldesk = $gamma[$getpen[1]];
                        $table_ziyadah .= '<tr><td class="text-left">'.$a.'. '.$labelin.'</td><td>'.$labelval.'</td><td>'.$labeldesk.'</td></tr>';
                        $a++;
                    }
    
                    $table_ziyadah .= '</tbody></table>';
    
                    $table_character .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th colspan="2">Pencapaian Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $table_character .= '<thead><tr><th>Juz</th><th>Surat dan Ayat</th></tr></thead>';
                    $table_character .= '<tr><td>'.$gamma['lastjuz'].'</td><td>'.$gamma['lastsuratayat'].'</td></tr>';
                    $table_character .= '<tr><td colspan="2" style="background:#f5f5f5;font-weight:bold">Total Hafalan</td></tr>';
                    $table_character .= '<tr><td colspan="2">'.$gamma['totaljuz'].' juz</td></tr>';
                    $table_character .= '</tbody></table>';
    
                    $table_tahfizh .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th colspan="3">Nilai Akhir Semester Tahfizh dan Tahsin</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $table_tahfizh .= '<tr><th>Ujian</th><th>Nilai</th><th>Predikat</th></tr>';
                    $table_tahfizh .= '<tr><td>Tahfizh</td><td>'.$totaltahfizh.'</td><td>'.get_grade_tahfizh($totaltahfizh).'</td></tr>';
                    $table_tahfizh .= '<tr><td>Tahsin</td><td>'.$totaltahsin.'</td><td>'.get_grade_tahfizh($totaltahsin).'</td></tr>';
    
                    $table_tahfizh .= '</tbody></table>';

                    $table_tahfizh2 .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Surat/Ayat</th>
                                <th>Nilai</th>
                                <th>Huruf</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';

                    $b=1;
                    $mysurat = get_quran_chapter_list();
                    foreach($gamma2 as $gam => $det){
                        $labelayat = '';
                        if(!empty($det['ayat'])){
                            $labelayat = ' (' . $det['ayat'] . ')';
                        }
                        $labelsrt = $mysurat[$gam][0] . $labelayat;
                        $marksrt = $det['mark'];
                        $table_tahfizh2 .= '<tr><td class="text-left">'.$b.'. '.$labelsrt.'</td><td>'.$marksrt.'</td><td>'.get_grades($marksrt).'</td></tr>';
                        $b++;
                    }

                    $table_tahfizh2 .= '</tbody></table>';

                    $table_present .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Ketidakhadiran</th>
                                <th>Deskripsi</th>
                            </thead>
                        <tbody>
                    ';
                    
                    $table_present .= '<tr><td>Sakit</td><td>'.get_muta_score('sick', $gamma['sick']).'</td></tr>';
                    $table_present .= '<tr><td>Izin</td><td>'.get_muta_score('permit', $gamma['permit']).'</td></tr>';
                    $table_present .= '<tr><td>Alpha</td><td>'.get_muta_score('alpha', $gamma['alpha']).'</td></tr>';
                    $table_present .= '<tr><td style="vertical-align: middle" colspan="2">Jumlah Pertemuan <br/>'.get_muta_score('present', $gamma['present']).'</td></tr>';
    
                    $table_present .= '</tbody></table>';

                    $table_tahsin_note .= '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Catatan Tahsin</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $table_tahsin_note .= '<tr><td style="vertical-align: middle;height: 90px">'.$gamma['tahsinnote'].'</td></tr>';
                    $table_tahsin_note .= '</tbody></table>';

                    $table_tahfizh_note .= '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Catatan Tahfizh</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $table_tahfizh_note .= '<tr><td style="vertical-align: middle;height: 90px">'.$gamma['tfnote'].'</td></tr>';
                    $table_tahfizh_note .= '</tbody></table>';

    
                    $target_tahfizh .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th colspan="4">Target Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $target_tahfizh .= '<thead><tr><th colspan="2">Tahfidzul Quran</th><th colspan="2">Tahsinul Quran</th></tr></thead>';
                    $totaltarget = count($gamma['targettahfizh']) + 1;
                    $gradetahsin = array(
                        '1' => 'Tahsin 1',
                        '2' => 'Tahsin 2',
                        '3' => 'Tahsin 3'
                    );
                    $tahsintargetdetail = '';
                    switch($gamma['tahsintarget']){
                        case '1':
                            $tahsintargetdetail = 'Kriteria Bacaan Masih Terbata-bata<br>Predikat Belum Terlampaui';
                        break;

                        case '2':
                            $tahsintargetdetail = 'Kriteria Belum Sempurna di Salah Satu Kriteria<br> meliputi (Konsistensi Tanda Panjang, Keseimbangan Tanda Gunnah,<br> Pengucapan Huruf Sukun dan Tuntutan Kesempurnaan Vokal)';
                        break;

                        case '3':
                            $tahsintargetdetail = 'Tepat dalam konsistensi tanda panjang<br>
                            Tepat dalam keseimbangan tanda gunnah<br>
                            Tepat dalam pengucapan huruf sukun<br>
                            Tepat dalam tuntutan kesempurnaan vokal<br>';
                        break; 
                    }
                    $tahsintargetdetail = '';
                    $table_tahsin .= '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%"><tbody>';
                    $table_tahsin .= '<tr><td>Grade</td><td>Keterangan</td></tr>';
                    $table_tahsin .= '<tr><td rowspan="5">'.$gradetahsin[$gamma['tahsintarget']].'</td></tr>';
                    $table_tahsin .= '<tr><td rowspan="4">
                    '.$tahsintargetdetail.'
                    </td></tr>';
                    $table_tahsin .= '</tbody></table>';
                    
                    $target_tahfizh .= '<tr><td>Juz</td><td>Surat</td><td colspan="2" rowspan="'.$totaltarget.'">'.$table_tahsin.'</td></tr>';
                    $get_juz = get_quran_juz_list();
                    if(!empty($gamma['targettahfizh'])) {
                        foreach($gamma['targettahfizh'] as $gam){
                            $target_tahfizh .= '<tr><td>'.$gam.'</td><td class="text-left">'.$get_juz[$gam][0].'</td></tr>';
                        }
                    }
    
                    $target_tahfizh .= '</tbody></table>';

                    $table_character = '
                    <div class="row">
                        <div class="col-md-7" style="width: 60%">
                            <h4>Evaluasi Ziyadah</h3>
                            <div class="mod-ziyadah">
                                '.$table_ziyadah.'
                            </div>
                            <div class="mod-character">
                                 '.$table_character.'
                            </div>
                            <div class="mod-ziyadah">
                                '.$table_tahfizh.'
                                <p><i>Catatan: <b>Mumtaz</b> (Sempurna), <b>Jayyid Jiddan</b> (Baik Sekali), <b>Jayyid</b> (Baik)</i></p>
                            </div>
                        </div>
                        <div class="col-md-4" style="width: 40%">
                            <h4>&nbsp;</h3>
                            <div class="mod-note-ziyadah">
                                '.$table_tahsin_note.'
                            </div>
                            <div class="mod-note-ziyadah">
                                '.$table_tahfizh_note.'
                            </div>
                            <div class="widget mod-present">
                                '.$table_present.'
                            </div>
                        </div>
                    </div>
                    ';
                } else {
                    $penilaian = [
                        'adab' => ['Adab di Dalam Halaqoh', 'adabnote'],
                        'murajaah' => ['Murajaah Mengulang Hafalan', 'murajaahnote'],
                        'tahsin' => ['Tahsin', 'tahsindesk'],
                        'target' => ['Pencapaian Target Hafalan', 'targetnote'],
                    ];
                    
                    foreach($exam as $mex){
                        $totalmarkjuz = 0;
                        $totaladd = 0;
                        $gamma = array();
                        $values = json_decode($mex->value, true);
                        $values2 = json_decode($mex->value2, true);
                        $period = $mex->period;
                        $class_name = $mex->class_name;
                        $class_no = $mex->class_no;
    
                        foreach($values as $eval){
                            $totalmarkjuz += $eval['mark'];
                            $totaladd++;
                        }
    
                        foreach($values2 as $eval2){
                            if($eval2['name'] == 'targettahfizh'){
                                $gamma[$eval2['name']] = json_decode($eval2['mark']);
                            } else {
                                $gamma[$eval2['name']] = $eval2['mark'];
                            }
                            
                        }
                    }
    
                    $pembagi = 0;
                    if(!empty($gamma['tapan'])){
                        $totalnilaimark += $gamma['tapan'];
                        $pembagi++;
                    }
                    if(!empty($gamma['gunnah'])){
                        $totalnilaimark += $gamma['gunnah'];
                        $pembagi++;
                    }
                    if(!empty($gamma['vokal'])){
                        $totalnilaimark += $gamma['vokal'];
                        $pembagi++;
                    }
                    if(!empty($markvalues2['sukun'])){
                        $totalnilaimark += $gamma['sukun'];
                        $pembagi++;
                    }
                    $totaltahsin = round($totalnilaimark / $pembagi, 1);
                    
                    $totaltahfizh = round($totalmarkjuz / $totaladd, 1);
    
                    //print_r($gamma);die();
                    
                    $table_character .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Aspek</th>
                                <th>Predikat</th>
                                <th>Deskripsi Kemajuan Belajar</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $a=1;
                    foreach($penilaian as $pen => $getpen){
                        $labelin = $getpen[0];
                        $labelval = get_predicate($pen, $gamma[$pen]);
                        $labeldesk = $gamma[$getpen[1]];
                        $table_character .= '<tr><td class="text-left">'.$a.'. '.$labelin.'</td><td>'.$labelval.'</td><td>'.$labeldesk.'</td></tr>';
                        $a++;
                    }
    
                    $table_character .= '</tbody></table>';
    
                    $table_achievement .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th colspan="2">Pencapaian Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $table_achievement .= '<thead><tr><th>Juz</th><th>Surat dan Ayat</th></tr></thead>';
                    $table_achievement .= '<tr><td>'.$gamma['lastjuz'].'</td><td>'.$gamma['lastsuratayat'].'</td></tr>';
                    $table_achievement .= '<tr><td colspan="2" style="background:#f5f5f5;font-weight:bold">Total Hafalan</td></tr>';
                    $table_achievement .= '<tr><td colspan="2">'.$gamma['totaljuz'].' juz</td></tr>';
                    $table_achievement .= '</tbody></table>';
    
                    $table_mark_final .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th colspan="3">Nilai Akhir Semester Tahfizh dan Tahsin</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $class = $student->class_name;
                    $table_mark_final .= '<tr><th>Ujian</th><th>Nilai</th><th>Predikat</th></tr>';
                    $table_mark_final .= '<tr><td>Tahfizh</td><td>'.$totaltahfizh.'</td><td>'.get_grade_tahfizh($totaltahfizh, $class).'</td></tr>';
                    $table_mark_final .= '<tr><td>Tahsin</td><td>'.$totaltahsin.'</td><td>'.get_grade_tahfizh($totaltahsin, $class).'</td></tr>';
    
                    $table_mark_final .= '</tbody></table>';

                    $table_character .= '<table id="datatable-responsive" class="table dt-responsive nowrap" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-top: none" width="60%">'.$table_mark_final.'</td>
                                <td style="border-top: none" >'.$table_achievement.'</td>
                            </tr>
                        </thead>
                        <tbody>
                    ';

                    $table_character .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead><tr><th>No</th><th>Ketidakhadiran</th><th>Deskripsi</th><th rowspan="4" style="text-align: center; vertical-align: middle; width: 40%">Jumlah pertemuan</th></tr></thead>
                        <tbody>
                    ';
                    
                    $table_character .= '<tr><td>1</td><td>Sakit</td><td>'.get_muta_score('sick', $gamma['sick']).'</td><td rowspan="3" style="vertical-align: middle">'.$gamma['present'].' kali pertemuan</td></tr>';
                    $table_character .= '<tr><td>2</td><td>Izin</td><td>'.get_muta_score('permit', $gamma['permit']).'</td></tr>';
                    $table_character .= '<tr><td>3</td><td>Alpha</td><td>'.get_muta_score('alpha', $gamma['alpha']).'</td></tr>';
    
                    $table_character .= '</tbody></table>';
    
                    $table_character .= 
                    '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th colspan="2">Target Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $table_character .= '<thead><tr><th width="50%">Tahfidzul Quran</th><th width="50%">Tahsinul Quran</th></tr></thead>';
                    $totaltarget = count($gamma['targettahfizh']) + 1;
                    
                    $tahsin_target_grade = get_tahsin_target_grade($class_name, $period);
                    $tahsin_target_detail = get_tahsin_target_detail($tahsin_target_grade);
                    $tahfizh_target = get_tahfizh_target($class_name, $period);
                    $table_target_tahsin = 'Grade: <br>'.$tahsin_target_grade;
                    $table_target_tahfizh = 'Target: <br>'.$tahfizh_target;
                    
                    $table_character .= '<tr><td>'.$table_target_tahfizh.'<td>'.$table_target_tahsin.'</td></tr>';
                    $table_character .= '</tbody></table>';
                }
                

                $this->data['html_table_tahfizh'] = $table_character;

                $this->data['markvalues2'] = $markvalues2;
            } else if ($type == 'tahsin') {
                
                $penilaian = [
                    'tapan' => ['Konsistensi Tanda Panjang', 'tapanskill'],
                    'gunnah' => ['Keseimbangan Tanda Gunnah', 'gunnahskill'],
                    'vokal' => ['Tuntutan Kesempurnaan vokal', 'vokalskill'],
                    'sukun' => ['Pengucapan Huruf Sukun', 'sukunskill'],
                ];
                
                foreach($exam as $mex){
                    $totalmarkjuz = 0;
                    $totaladd = 0;
                    $gamma = array();
                    $values = json_decode($mex->value, true);
                    $values2 = json_decode($mex->value2, true);

                    foreach($values as $eval){
                        $totalmarkjuz += $eval['mark'];
                        $totaladd++;
                    }

                    foreach($values2 as $eval2){
                        if($eval2['name'] == 'targettahfizh'){
                            $gamma[$eval2['name']] = json_decode($eval2['mark']);
                        } else {
                            $gamma[$eval2['name']] = $eval2['mark'];
                        }
                        
                    }
                }

                $pembagi = 0;
                if(!empty($gamma['tapan'])){
                    $totalnilaimark += $gamma['tapan'];
                    $pembagi++;
                }
                if(!empty($gamma['gunnah'])){
                    $totalnilaimark += $gamma['gunnah'];
                    $pembagi++;
                }
                if(!empty($gamma['vokal'])){
                    $totalnilaimark += $gamma['vokal'];
                    $pembagi++;
                }
                if(!empty($markvalues2['sukun'])){
                    $totalnilaimark += $gamma['sukun'];
                    $pembagi++;
                }
                
                $totaltahfizh = round($totalmarkjuz / $totaladd, 1);

                //print_r($gamma);die();
                
                $table_character .= 
                '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">KD/Materi</th>
                            <th colspan="2">Nilai</th>
                        </tr>
                        <tr>
                            <th>Pengetahuan</th>
                            <th>Keterampilan</th>
                    </thead>
                    <tbody>
                ';
                $a=1;

                $pembagi = 4;
                $totalnilaitahsin = 0;
                foreach($penilaian as $pen => $getpen){
                    $labelin = $getpen[0];
                    $labelval = $gamma[$pen];
                    $labeldesk = get_predicate('skill',$gamma[$getpen[1]]);
                    $table_character .= '<tr><td>'.$a.'</td><td class="text-left">'.$labelin.'</td><td>'.$labelval.'</td><td>'.$labeldesk.'</td></tr>';
                    $a++;
                    $totalnilaitahsin += $labelval;
                    $totalnilaiskill += $gamma[$getpen[1]];
                }
                $totalskill = round($totalnilaiskill, 1);
                $totaltahsin = round($totalnilaitahsin / $pembagi, 1);

                $labelpredikat = "Belum Terlampaui";
                if ($totaltahsin > 80){
                    $labelpredikat = "Terlampaui";
                }

                // Nilai Keterampilan
                $labelpredikat2 = "Belum Terlampaui";
                if ($totalskill == 8){
                    $labelpredikat2 = "Basic 3";
                } else if($totalskill > 4){
                    $labelpredikat2 = "Basic 2";
                }  else if($totalskill < 5){
                    $labelpredikat2 = "Basic 1";
                }

                $table_character .= '</tbody></table>';

                $table_character .= 
                '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th colspan="2">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                $table_character .= '<tr><td>Pengetahuan</td><td>'.$labelpredikat.'</td></tr>';
                $table_character .= '<tr><td>Keterampilan</td><td>'.$labelpredikat2.'</td></tr>';
                $table_character .= '</tbody></table>';

                $table_character .= 
                '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Ketidakhadiran</th>
                            <th>Deskripsi</th>
                        </thead>
                    <tbody>
                ';
                
                $table_character .= '<tr><td>Sakit</td><td>'.get_muta_score('sick', $gamma['sick']).'</td></tr>';
                $table_character .= '<tr><td>Izin</td><td>'.get_muta_score('permit', $gamma['permit']).'</td></tr>';
                $table_character .= '<tr><td>Alpha</td><td>'.get_muta_score('alpha', $gamma['alpha']).'</td></tr>';
                $table_character .= '<tr><td style="vertical-align: middle" colspan="2">Jumlah Pertemuan <br/>'.get_muta_score('present', $gamma['present']).'</td></tr>';

                $table_character .= '</tbody></table>';

                
                $table_character .= 
                '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Keterangan Tambahan</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                
                $table_character .= '<tr><td>'.$gamma['tahsinnote'].'</td></tr>';
                $table_character .= '</tbody></table>';

                $this->data['html_table_tahfizh'] = $table_character;

                $this->data['markvalues2'] = $markvalues2;
            }
            
            $this->data['school'] = $school;
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['student'] = $student;
            $this->data['class_id'] = $class_id;
            //  $this->data['section_id'] = $section_id;
            $this->data['student_id'] = $student_id;
            
            $session = $this->resultcardform->get_single('academic_years', array('id' => $academic_year_id));
            $this->data['session'] = (isset($session->start_year)?$session->start_year:'') . '/' . (isset($session->end_year)?$session->end_year:'');
            $class = $this->resultcardform->get_single('classes', array('id'=>$class_id));
            create_log('Has been filter result card for class: '. $class->name. ', '. $this->data['student']->name );
        }
        
        if(empty($school_id)){
            $school_id = $this->session->userdata('school_id'); 
            $this->data['school_id'] = $school_id;
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] = $this->session->userdata('school_id');            
            $this->data['classes'] = $this->resultcardform->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['academic_years'] = $this->resultcardform->get_list('academic_years', $condition, '', '', '', 'id', 'ASC');
        }

        $this->layout->title($this->lang->line('manage_result_card') . ' | ' . SMS);
        $this->layout->view('result_card_form/index', $this->data);
    }

}
