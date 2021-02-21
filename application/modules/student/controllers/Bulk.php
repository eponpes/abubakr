<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Bulk.php**********************************
 * @product name    : Global School Management System Pro
 * @type            : Class
 * @class name      : Bulk
 * @description     : Manage bulk students imformation of the school.  
 * @author          : Codetroopers Team 	
 * @url             : https://themeforest.net/user/codetroopers      
 * @support         : yousuf361@gmail.com	
 * @copyright       : Codetroopers Team	 	
 * ********************************************************** */

class Bulk extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();      
        
        $this->load->model('Student_Model', 'student', true);          
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add Bulk Student" user interface                 
    *                    and process to store "Bulk Student" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {            
            $status = $this->_get_posted_student_data();
            if ($status) {                   

                create_log('Has been added Bulk Student');
                success($this->lang->line('insert_success'));
                redirect('student/index/'.$this->input->post('class_id'));
            } else {
                error($this->lang->line('insert_failed'));
                redirect('student/bulk/add/');
            }            
        } 
        
                    
        if($this->session->userdata('role_id') != SUPER_ADMIN){   
             $school_id = $this->session->userdata('school_id');
            $this->data['academic_years'] = $this->student->get_list('academic_years', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC'); 
            $this->data['classes'] = $this->student->get_list('classes', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        }else{ 
            $this->data['classes'] = array();   
        }
        
        $this->layout->title($this->lang->line('bulk_admission') . ' | ' . SMS);
        $this->layout->view('bulk', $this->data);
    }

   

    /*****************Function _get_posted_student_data**********************************
    * @type            : Function
    * @function name   : _get_posted_student_data
    * @description     : Prepare "Student" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_student_data() {

        $this->_upload_file();

        $destination = 'assets/csv/bulk_uploaded_student.csv';
        if (($handle = fopen($destination, "r")) !== FALSE) {

            $count = 1;            
            $school_id  = $this->input->post('school_id');           
            $academic_year_id = $this->input->post('academic_year_id');
            if(!$academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('student/bulk/add');
            }
            
           
            while (($arr = fgetcsv($handle, null, ';')) !== false) {

                if ($count == 1) { $count++;  continue; }

                // need atleast some mandatory data
                //0 = name, 1 = admission_no, 21 = roll_no
                if ($arr[0] != '' && $arr[1] != '' && $arr[5] != '' && $arr[21] != '') {

                   
                   
                    $user = array();
                    $data = array();
                    $enroll = array();
                    $guardian_user = array();
                    $guardian = array();
                    
                    // now creating guardian user
                    $guardian_user['role_id']  = GUARDIAN;
                    $guardian_user['name']     =  isset($arr[55]) ? $arr[55] : '';
                    $guardian_user['phone']    =  isset($arr[56]) ? $arr[56] : '';
                    $guardian_user['email']    =  isset($arr[57]) ? $arr[57] : '';
                    $guardian_user['username'] =  $this->student->get_custom_id('users', 'GUD');
                    $guardian_user['password'] =  get_random_tring(6);
                   
                    $guardian['user_id'] = $this->student->create_custom_user($guardian_user);  
                    
                    // now we have to create guardian
                    $guardian['name']    = isset($arr[55]) ? $arr[55] : '';
                    $guardian['phone']   = isset($arr[56]) ? $arr[56] : '';
                    $guardian['email']   = isset($arr[57]) ? $arr[57] : '';
                    $guardian['profession']   = isset($arr[58]) ? $arr[58] : '';
                    $guardian['religion']   = isset($arr[59]) ? $arr[59] : '';
                    $guardian['national_id'] = isset($arr[60]) ? $arr[60] : '';
                    $guardian['present_address']   = isset($arr[61]) ? $arr[61] : '';
                    $guardian['permanent_address']   = isset($arr[62]) ? $arr[62] : '';
                    $guardian['other_info']   = isset($arr[63]) ? $arr[63] : '';
                    $guardian['created_at'] = date('Y-m-d H:i:s');
                    $guardian['created_by'] = logged_in_user_id();
                    $guardian['modified_at'] = date('Y-m-d H:i:s');
                    $guardian['modified_by'] = logged_in_user_id();
                    $guardian['status'] = 1; 

                    $data['guardian_id'] = $this->student->insert('guardians', $guardian);
                    
                     // now we have to create student user
                    $user['role_id'] = STUDENT;                    
                    $user['name'] = isset($arr[0]) ? $arr[0] : '';
                    $user['phone'] = isset($arr[13]) ? $arr[13] : '';    
                    $user['email'] = isset($arr[14]) ? $arr[14] : '';
                    $user['username'] =  $this->student->get_custom_id('users', 'STD');
                    $user['password'] =  get_random_tring(6); 
                    
                    $data['user_id'] = $this->student->create_custom_user($user);   
                    
                    $data['school_id'] = $school_id;
                    $data['name'] = isset($arr[0]) ? $arr[0] : '';
                    $data['admission_no'] = isset($arr[1]) ? $arr[1] : '';
                    $data['admission_date'] = isset($arr[2]) ? date('Y-m-d', strtotime($arr[2])) : date('Y-m-d');
                    $data['pob'] = isset($arr[3]) ? $arr[3] : ''; // new record
                    $data['dob'] = isset($arr[4]) ? date('Y-m-d', strtotime($arr[4])) : date('Y-m-d');
                    $data['gender'] = isset($arr[5]) ? $arr[5] : '';                                     
                    $data['blood_group'] = isset($arr[6]) ? $arr[6] : '';
                    $data['religion'] = isset($arr[7]) ? $arr[7] : '';
                    $data['caste'] = isset($arr[8]) ? $arr[8] : '';
                    
                    $data['weight'] = isset($arr[9]) ? $arr[9] : '';    
                    $data['height'] = isset($arr[10]) ? $arr[10] : '';                    
                    $data['child_no'] = isset($arr[11]) ? $arr[11] : '';
                    $data['child_from'] = isset($arr[12]) ? $arr[12] : '';
                    
                    $data['phone'] = isset($arr[13]) ? $arr[13] : '';    
                    $data['email'] = isset($arr[14]) ? $arr[14] : '';                    
                    $data['national_id'] = isset($arr[15]) ? $arr[15] : '';

                    $data['nisn_no'] = isset($arr[16]) ? $arr[16] : '';    
                    $data['skhun_no'] = isset($arr[17]) ? $arr[17] : '';                    
                    $data['ijazah_no'] = isset($arr[18]) ? $arr[18] : '';

                    $data['type_id'] = isset($arr[19]) ? $arr[19] : '';
                    $data['group'] = isset($arr[20]) ? $arr[20] : '';
                    $data['registration_no'] = isset($arr[22]) ? $arr[22] : '';  
                    $data['discount_id'] = isset($arr[23]) ? $arr[23] : '';
                    $data['second_language'] = isset($arr[24]) ? $arr[24] : '';
                    $data['present_address'] = isset($arr[25]) ? $arr[25] : '';
                    $data['permanent_address'] = isset($arr[26]) ? $arr[26] : '';
                    
                    $data['province_id'] = isset($arr[27]) ? $arr[27] : '';  
                    $data['regency_id'] = isset($arr[28]) ? $arr[28] : '';
                    $data['district_id'] = isset($arr[29]) ? $arr[29] : '';
                    $data['villages_id'] = isset($arr[30]) ? $arr[30] : '';
                    $data['postal_code'] = isset($arr[31]) ? $arr[31] : '';
                    

                    $data['health_condition'] = isset($arr[32]) ? $arr[32] : '';                    
                    $data['previous_school'] = isset($arr[33]) ? $arr[33] : '';
                    $data['previous_class'] = isset($arr[34]) ? $arr[34] : '';
                    
                    $data['previous_school_address'] = isset($arr[35]) ? $arr[35] : '';                    
                    $data['previous_school_city'] = isset($arr[36]) ? $arr[36] : '';
                    $data['graduate_year'] = isset($arr[37]) ? $arr[37] : '';
                    
                    $data['other_info'] = isset($arr[38]) ? $arr[38] : '';
                    
                    $data['father_name'] = isset($arr[39]) ? $arr[39] : '';
                    $data['father_phone'] = isset($arr[40]) ? $arr[40] : '';
                    $data['father_education'] = isset($arr[41]) ? $arr[41] : '';
                    $data['father_profession'] = isset($arr[42]) ? $arr[42] : '';
                    $data['father_designation'] = isset($arr[43]) ? $arr[43] : '';
                    $data['father_religion'] = isset($arr[44]) ? $arr[44] : '';
                    $data['father_pob'] = isset($arr[45]) ? $arr[45] : '';
                    $data['father_dob'] = isset($arr[46]) ? date('Y-m-d', strtotime($arr[46])) : date('Y-m-d');

                    $data['mother_name'] = isset($arr[47]) ? $arr[47] : '';
                    $data['mother_phone'] = isset($arr[48]) ? $arr[48] : '';
                    $data['mother_education'] = isset($arr[49]) ? $arr[49] : '';
                    $data['mother_profession'] = isset($arr[50]) ? $arr[50] : '';
                    $data['mother_designation'] = isset($arr[51]) ? $arr[51] : ''; 
                    $data['mother_religion'] = isset($arr[52]) ? $arr[52] : '';
                    $data['mother_pob'] = isset($arr[53]) ? $arr[53] : '';
                    $data['mother_dob'] = isset($arr[54]) ? date('Y-m-d', strtotime($arr[54])) : date('Y-m-d');

                    $data['relation_with'] = isset($arr[64]) ? $arr[64] : '';
                    $data['gud_earning_id'] = isset($arr[65]) ? $arr[65] : '';
               
                    $data['age'] = $data['dob'] ? floor((time() - strtotime($data['dob'])) / 31556926) : 0;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    $data['created_by'] = logged_in_user_id();
                    $data['modified_at'] = date('Y-m-d H:i:s');
                    $data['modified_by'] = logged_in_user_id();
                    $data['status'] = 1;

                    
                     // now need to create student

                    $enroll['student_id'] = $this->student->insert('students', $data);
                    $enroll['roll_no'] = isset($arr[21]) ? $arr[21] : '';

                    // now need to create enroll
                    $this->_insert_enrollment($enroll);
                }
            }
        }

        return TRUE;
    }
    
    
    
    /***************** Function _upload_file **********************************
    * @type            : Function
    * @function name   : _upload_file
    * @description     : upload bulk studebt csv file                  
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _upload_file() {

        $file = $_FILES['bulk_students']['name'];

        if ($file != "") {

            $destination = 'assets/csv/bulk_uploaded_student.csv';          
            $ext = strtolower(end(explode('.', $file)));
            if ($ext == 'csv') {                 
                move_uploaded_file($_FILES['bulk_students']['tmp_name'], $destination);  
            }
        } else {
            error($this->lang->line('insert_failed'));
            redirect('student/bulk/add/');
        }       
    }

    
    /*****************Function _insert_enrollment**********************************
    * @type            : Function
    * @function name   : _insert_enrollment
    * @description     : save student info to enrollment while create a new student                  
    * @param           : $insert_id integer value
    * @return          : null 
    * ********************************************************** */
    private function _insert_enrollment($enroll) {
        
        $data = array();
        $data['student_id'] = $enroll['student_id'];
        $data['school_id']   = $this->input->post('school_id');
        $data['class_id']   = $this->input->post('class_id');
        $data['section_id'] = $this->input->post('section_id');  
        $data['academic_year_id'] = $this->input->post('academic_year_id');        
        $data['roll_no'] = $enroll['roll_no'];
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $data['status'] = 1;
        $this->student->insert('enrollments', $data);
    }
}