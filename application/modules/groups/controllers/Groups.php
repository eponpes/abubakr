<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Invoice.php**********************************
 * @product name    : Global Multi School Management System Express
 * @type            : Class
 * @class name      : Invoice
 * @description     : Manage invoice for all type of student payment.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Groups extends MY_Controller {

    public $data = array();    
    
    function __construct() {
        
        parent::__construct();
         $this->load->model('Groups_Model', 'groups', true);
    }

    
    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Invoice List" user interface                 
    *                        
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        
        check_permission(VIEW);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->invoice->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['income_heads'] = $this->invoice->get_fee_type($condition['school_id']);
        }
        
         // default global income head       
        $this->data['invoices'] = $this->invoice->get_invoice_list($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
         
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_invoice'). ' | ' . SMS);
        $this->layout->view('manage/index', $this->data);            
       
    }

    public function get_teachers() {

        $school_id = $this->input->post('school_id');
        $teacher_id = $this->input->post('teacher_id');
         
        $school = $this->groups->get_school_by_id($school_id);
        $teachers = $this->groups->get_teachers($school_id, $teacher_id, 'regular');

        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        
        $select = 'selected="selected"';
        if (!empty($teachers)) {
            foreach ($teachers as $obj) {
                $selected = $teacher_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . ' [' . $obj->id . ']</option>';
            }
        }

        echo $str;
    }
    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Create new Invoice" user interface                 
    *                    and store "Invoice" data into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add($school_id = null) {

        //check_permission(ADD);
        
        
        if ($_POST) {
            $this->_prepare_invoice_validation();
            if ($this->form_validation->run() === FALSE) {
                $invoice_id = $this->_get_posted_invoice_data();
               
                if ($invoice_id) {                  
                    success($this->lang->line('insert_success'));
                    redirect('groups/groups/add');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('groups/groups/add');
                }
            } else {
                echo 'cool';die();
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
            
            $school_id = $this->input->post('school_id');
        }

        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->groups->get_list('classes', $condition, '','', '', 'id', 'ASC');
            $this->data['income_heads'] = $this->groups->get_fee_type($condition['school_id']);
        }
        
        // default global income head
        $this->data['invoices'] = $this->groups->get_invoice_list($school_id); 
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;  
        //$this->data['teachers'] = $this->get_teachers();
                
        $this->data['single'] = TRUE;
        $this->layout->title($this->lang->line('create_invoice'). ' | ' . SMS);
        $this->layout->view('manage/index', $this->data);
    }
    
    
    /*****************Function _prepare_invoice_validation**********************************
    * @type            : Function
    * @function name   : _prepare_invoice_validation
    * @description     : Process "Invoice" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_invoice_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school'), 'trim|required');               
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('paid_status', $this->lang->line('paid_status'), 'trim|required'); 
        
        if($this->input->post('type')== 'single'){
            $this->form_validation->set_rules('student_id', $this->lang->line('student'), 'trim|required'); 
            $this->form_validation->set_rules('amount', $this->lang->line('fee_amount'), 'trim|required'); 
                       
        }
        
        $this->form_validation->set_rules('is_applicable_discount', $this->lang->line('is_applicable_discount'), 'trim|required');   
        $this->form_validation->set_rules('month', $this->lang->line('month'), 'trim|required');   
        $this->form_validation->set_rules('paid_status', $this->lang->line('paid_status'), 'trim|required');   
        
        if($this->input->post('paid_status')== 'paid'){
           $this->form_validation->set_rules('payment_method', $this->lang->line('payment_method'), 'trim|required');   
        }
        
    }


    // for single invoice
    /*****************Function _get_posted_invoice_data**********************************
     * @type            : Function
     * @function name   : _get_posted_invoice_data
     * @description     : Prepare "Invoice" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_invoice_data() {

        $group_add = 1;

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'student_id';
        $items[] = 'teacher_id';

        $data = elements($items, $_POST);          
                            
        $data['updatetype'] = $this->input->post('updatetype');
            
        $data['status'] = 1;

        $school = $this->groups->get_school_by_id($data['school_id']);

        if(!$school->academic_year_id){
            error($this->lang->line('set_academic_year_for_school'));
            redirect('accounting/invoice/index');
        }             

        $data['academic_year_id'] = $school->academic_year_id;

        $conditions = array(
            'school_id' => $data['school_id'],
            'class_id' => $data['class_id'],
            'academic_year_id' => $data['academic_year_id']
        );

        $updatedata = array();
        if($data['updatetype'] == 'bpi'){
            $updatedata['class_bpi_id'] = $data['teacher_id'];
            
        } else if($data['updatetype'] == 'tahfidz'){
            $updatedata['class_tahfizh_id'] = $data['teacher_id'];
        }
        $datap = array();
        foreach($data['student_id'] as $dob){
            $datap[] = $dob;
        }

        $condition = array();
        $condition['school_id'] = $data['school_id'];
        $condition['class_id'] = $data['class_id'];
        $condition['academic_year_id'] = $data['academic_year_id'];
        
        $this->db->where_in('student_id', $datap);
        $this->db->update('enrollments', $updatedata, $condition);
        
        return $group_add;
    }
    
    
    
    public function get_student_by_class() {

        $school_id = $this->input->post('school_id');
        $class_id = $this->input->post('class_id');
        $student_id = $this->input->post('student_id');
        $is_bulk = $this->input->post('is_bulk');
         
        $school = $this->invoice->get_school_by_id($school_id);
        $students = $this->invoice->get_student_list($school_id, $school->academic_year_id, $class_id, $student_id, 'regular');

        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        if($is_bulk){
             $str .= '<option value="all">' . $this->lang->line('all') . '</option>';
        }
        
        $select = 'selected="selected"';
        if (!empty($students)) {
            foreach ($students as $obj) {
                $selected = $student_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . ' [' . $obj->roll_no . ']</option>';
            }
        }

        echo $str;
    }
   
}
