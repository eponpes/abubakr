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

    public function view($school_id = null, $academic_year_id = null, $class_id = null, $section_id = null, $student_id = null) {

        //check_permission(VIEW);

        $levelchar = $_GET['l'];

        $data_character = get_character_indicator($levelchar);

        $this->data['characters'] = $data_character;
        
        if (!empty($school_id) && !empty($class_id) && !empty($section_id) && !empty($student_id) && !empty($academic_year_id)) {

            if($this->session->userdata('role_id') == STUDENT){
                
                $student = get_user_by_role($this->session->userdata('role_id'), $this->session->userdata('id'));
                $school_id = $student->school_id;
                $class_id = $student->class_id;
                $section_id = $student->section_id;
                $student_id = $student->id;
                
            }else{
                
                $school_id = $school_id;
                $class_id = $class_id;
                $section_id = $section_id;
                $student_id = $student_id;
                
                $std = $this->resultcardform->get_single('students', array('id'=>$student_id));
                $student = get_user_by_role(STUDENT, $std->user_id);
            }
            
            $school = $this->resultcardform->get_school_by_id($school_id);
            $exam = get_mark_form_results($school_id, $academic_year_id, $class_id, $section_id, $student_id, $levelchar); 
            $totalsm1_1 = 0;
            $totalsm2_1 = 0;
            foreach($exam as $mex){
                $add1 = $add2 = $add3 = $add4 = $add5 = $add6 = $add7 = 0;
                $mark1 = $mark2 = $mark3 = $mark4 = $mark5 = $mark6 = $mark7 =  0;
                $values = json_decode($mex->value, true);
                
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
                if($mex->quarter == 'Q1' || $mex->quarter == 'Q2'){
                    $totalsm1_1 += $mark1/$add1;
                    $totalsm1_2 += $mark2/$add2;
                    $totalsm1_3 += $mark3/$add3;
                    $totalsm1_4 += $mark4/$add4;
                    $totalsm1_5 += $mark5/$add5;
                    $totalsm1_6 += $mark6/$add6;
                    $totalsm1_7 += $mark7/$add7;
                } else if($mex->quarter == 'Q3' || $mex->quarter == 'Q4'){
                    $totalsm2_1 += $mark1/$add1;
                    $totalsm2_2 += $mark2/$add2;
                    $totalsm2_3 += $mark3/$add3;
                    $totalsm2_4 += $mark4/$add4;
                    $totalsm2_5 += $mark5/$add5;
                    $totalsm2_6 += $mark6/$add6;
                    $totalsm2_7 += $mark7/$add7;
                }
            }

            $semester = isset($_GET['s'])?$_GET['s']:1;

            // NILAI SEMESTER 1
            $levelof = array('1'=>'Dasar', '2'=>'Lanjut');
            $table_character .= '<h4>Tingkat '.$levelof[$levelchar].'</h4>';
            $table_character .= '<h1>SEMESTER '.$semester.'</h1>';
            $table_character .= 
            '<table id="datatable-responsive" class="table table-striped_ table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead><tr><th>No</th><th>Karakter</th><th>Nilai</th></tr></thead>
                <tbody>
            ';
            $number = 1;
            foreach($data_character as $char7){
                $totalmarksm = number_format(${"totalsm". $semester."_".$number}/2, 1);
                $table_character .= '<tr><td>'.$number.'</td><td>'.$char7['name'].'</td><td>'.get_markform_score($totalmarksm).'</td></tr>';
                $number++;
            }
            $table_character .= '</tbody></table>';

            $this->data['html_table_character'] = $table_character;
            
            $this->data['school'] = $school;
            $this->data['school_id'] = $school_id;
            $this->data['academic_year_id'] = $academic_year_id;
            $this->data['student'] = $student;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['student_id'] = $student_id;
            
            $class = $this->resultcardform->get_single('classes', array('id'=>$class_id));
            create_log('Has been filter result card for class: '. $class->name. ', '. $this->data['student']->name );
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
