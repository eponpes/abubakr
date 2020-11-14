<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Mark.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Mark
 * @description     : Manage exam mark for student whose are attend in the exam.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Mark extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Mark_Model', 'mark', true);  
        $this->load->model('Markforms_Model', 'markforms', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Exam Mark List" user interface                 
    *                    with filter option  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');

            $school = $this->mark->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/mark');
            }
            
            $this->data['students'] = $this->mark->get_student_list($school_id, $exam_id, $class_id, $section_id, $subject_id, $school->academic_year_id);

            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }

            $data = $condition;
            
            if (!empty($this->data['students'])) {

                foreach ($this->data['students'] as $obj) {

                    $condition['student_id'] = $obj->student_id;
                    $mark = $this->mark->get_single('marks', $condition);

                    if (empty($mark)) {
                        
                        $data['section_id'] = $obj->section_id;
                        $data['student_id'] = $obj->student_id;
                        $data['status'] = 1;
                        $data['created_at'] = date('Y-m-d H:i:s');
                        $data['created_by'] = logged_in_user_id();
                        $this->mark->insert('marks', $data);
                    }
                }
            }

            $this->data['grades'] = $this->mark->get_list('grades', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
            
            $this->data['school_id'] = $school_id;
            $this->data['exam_id'] = $exam_id;
            $this->data['class_id'] = $class_id;
            $this->data['section_id'] = $section_id;
            $this->data['subject_id'] = $subject_id;
            $this->data['academic_year_id'] = $school->academic_year_id;
                        
            $class = $this->mark->get_single('classes', array('id'=>$class_id));
            create_log('Has been process exam mark for class: '. $class->name);
            
        }
        
        
        $condition = array();
        $condition['status'] = 1;  
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school = $this->mark->get_school_by_id($this->session->userdata('school_id'));
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->mark->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $condition['academic_year_id'] = $school->academic_year_id;
            $this->data['exams'] = $this->mark->get_list('exams', $condition, '', '', '', 'id', 'ASC');
        }  

        $this->layout->title($this->lang->line('manage_mark') . ' | ' . SMS);
        if($subject_id == 1) {
            $this->layout->view('mark/tahsin', $this->data);
        } else if($subject_id == 2) {
            $this->layout->view('mark/tahfizh', $this->data);
        } else {
            $this->layout->view('mark/default', $this->data);
        }
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Process to store "Exam Mark" into database                
    *                     
    * @param           : null
    * @return          : null 
     * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {

            $school_id = $this->input->post('school_id');
            $exam_id = $this->input->post('exam_id');
            $class_id = $this->input->post('class_id');
            $section_id = $this->input->post('section_id');
            $subject_id = $this->input->post('subject_id');

            $school = $this->mark->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('exam/mark');
            }
            
            $condition = array(
                'school_id' => $school_id,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'academic_year_id' => $school->academic_year_id,
                'subject_id' => $subject_id
            );
            
            if($section_id){
                $condition['section_id'] = $section_id;
            }            

            $data = $condition;

            if (!empty($_POST['students'])) {

                foreach ($_POST['students'] as $key => $value) {

                    $condition['student_id'] = $value;
                    $data['written_mark'] = $_POST['written_mark'][$value];
                    $data['written_obtain'] = $_POST['written_obtain'][$value];
                    
                    $data['tutorial_mark'] = $_POST['tutorial_mark'][$value];
                    $data['tutorial_obtain'] = $_POST['tutorial_obtain'][$value];
                    
                    $data['practical_mark'] = $_POST['practical_mark'][$value];
                    $data['practical_obtain'] = $_POST['practical_obtain'][$value];
                    
                    $data['viva_mark'] = $_POST['viva_mark'][$value];
                    $data['viva_obtain'] = $_POST['viva_obtain'][$value];
                    
                    $data['exam_total_mark'] = $_POST['exam_total_mark'][$value];
                    $data['obtain_total_mark'] = $_POST['obtain_total_mark'][$value];
                    
                    $data['grade_id'] = $_POST['grade_id'][$value];                    
                    $data['remark'] = $_POST['remark'][$value];

                    $data['knowledge_mark'] = $_POST['knowledge_mark'][$value];
                    $data['knowledge_obtain'] = $_POST['knowledge_obtain'][$value];
                    $data['knowledge_note'] = $_POST['knowledge_note'][$value];

                    $data['skill_mark'] = $_POST['skill_mark'][$value];
                    $data['skill_obtain'] = $_POST['skill_obtain'][$value];
                    $data['skill_note'] = $_POST['skill_note'][$value];

                    $data['fashohah'] = $_POST['fashohah'][$value];
                    $data['tajwid'] = $_POST['tajwid'][$value];
                    $data['fluency'] = $_POST['fluency'][$value];
                    $data['tahfizh_note'] = $_POST['tahfizh_note'][$value];

                    $data['status'] = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id();
                    $this->mark->update('marks', $data, $condition);
                }
            }
            
            $class = $this->mark->get_single('classes', array('id'=>$class_id));
            create_log('Has been process exam mark and save for class: '. $class->name);
            
            success($this->lang->line('insert_success'));
            redirect('exam/mark');
        }

        $this->layout->title($this->lang->line('add')  . ' | ' . SMS);
        $this->layout->view('mark/index', $this->data);
    }

    public function form($type = null, $school_id = null, $academic_year_id = null, $class_id = null, $section_id = null, $student_id = null) {

        //check_permission(ADD);
        $levelchar = $_GET['l'];

        $data_character = get_character_indicator($levelchar);

        $this->data['characters'] = $data_character;

        $condition = array(
            'school_id' => $school_id,
            'academic_year_id' => $academic_year_id,
            'class_id' => $class_id,
            'section_id' => $section_id,
            'student_id' => $student_id
        );
        $this->data['school_id'] = $school_id;
        $this->data['academic_year_id'] = $academic_year_id;
        $this->data['class_id'] = $class_id;
        $this->data['section_id'] = $section_id;
        $this->data['student_id'] = $student_id;

        $this->data['students'] = $data = $condition;

        if(!empty($_GET['q']) && !empty($_GET['l'])){
            $quarterlist = array('Q1','Q2','Q3','Q4');
            if(!in_array($_GET['q'], $quarterlist)){
                redirect('dashboard');
            }
            $condition['quarter'] = $_GET['q'];

            $levellist = array('1','2');
            if(!in_array($_GET['l'], $levellist)){
                redirect('dashboard');
            }
            $condition['level'] = $_GET['l'];
            
            $markforms = $this->markforms->get_single('mark_forms', $condition);
            if (empty($markforms)) {
                $data['value'] = '';
                $data['quarter'] = $_GET['q'];
                $data['level'] = $_GET['l'];
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();
                $this->markforms->insert('mark_forms', $data);
            } else {
                $markvalues = json_decode($markforms->value, true);
                $vlabo = array();
                foreach ($markvalues as $lo){
                    $mark = $lo['mark'];
                    $id = $lo['id'];
                    $vlabo[$id] = $mark;                    
                }
                $this->data['markvalues'] = $vlabo; 
                
                $markvalues2 = json_decode($markforms->value2, true);
                $vlabo2 = array();
                foreach ($markvalues2 as $lo2){
                    $mark2 = $lo2['mark'];
                    $id2 = $lo2['name'];
                    $vlabo2[$id2] = $mark2;                    
                }
                $this->data['markvalues2'] = $vlabo2; 
            }

            
        }
        

        if (!empty($_POST)) {
                $data = array();
                $school_id = $this->input->post('school_id');
                $academic_year_id = $this->input->post('academic_year_id');
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $student_id = $this->input->post('student_id');
                $level = $this->input->post('level');
                $quarter = $this->input->post('quarter');
                
                $condition = array(
                    'school_id' => $school_id,
                    'academic_year_id' => $academic_year_id,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'student_id' => $student_id,
                    'level' => $level,
                    'quarter' => $quarter
                );

                $data = $condition;

                if(!empty($_POST['indicator'])){
                    $vla = array();
                    foreach ($_POST['indicator'] as $ind => $val){
                        $valin = array(
                            'id' => $ind,
                            'mark' => $val
                        );
                        array_push($vla, $valin);
                    }
                    $vlas = json_encode($vla);
                    $data['value'] = $vlas;
                }

                if(!empty($_POST['indicator2'])){
                    $vla2 = array();
                    foreach ($_POST['indicator2'] as $ind2 => $val2){
                        $valin2 = array(
                            'name' => $ind2,
                            'mark' => $val2
                        );
                        array_push($vla2, $valin2);
                    }
                    $vlas2 = json_encode($vla2);
                    $data['value2'] = $vlas2;
                }

                $condition['school_id'] = $school_id;
                $condition['academic_year_id'] = $academic_year_id;
                $condition['class_id'] = $class_id;
                $condition['section_id'] = $section_id;
                $condition['student_id'] = $student_id;
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();
                //echo '-----';
                //print_r($data);
                //die();
                $this->markforms->update('mark_forms', $data, $condition);
        
            

            //print_r($_POST);die();

            /*if (!empty($_POST['students'])) {

                foreach ($_POST['students'] as $key => $value) {

                    $condition['student_id'] = $value;
                    
                    $data['status'] = 1;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id();
                    $this->mark->updateform('markforms', $data, $condition);
                }
            }
            
            create_log('Has been process exam mark and save for class: '. $class->name);
            
            success($this->lang->line('insert_success'));
            redirect('exam/mark');
            */
        }

        $this->layout->title($this->lang->line('add')  . ' | ' . SMS);
        $this->layout->view('mark/indexform', $this->data);
    }

}
