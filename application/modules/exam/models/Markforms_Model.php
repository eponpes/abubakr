<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Markforms_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_mark_forms_list_by_student($school_id, $class_id, $student_id, $academic_year_id, $period){
        
        $this->db->select('M.value, M.period');
        $this->db->from('mark_forms AS M'); 
        $this->db->where('M.school_id', $school_id);
        $this->db->where('M.class_id', $class_id);
        $this->db->where('M.student_id', $student_id);
        $this->db->where('M.academic_year_id', $academic_year_id); 
        $this->db->where('M.period', $period);
        return $this->db->get()->result(); 
    }
    
}
