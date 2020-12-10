<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('_d')) {

    function _d($data, $exit = TRUE) {
        print '<pre>';
        print_r($data);
        print '</pre>';
        if ($exit)
            exit;
    }
}

if (!function_exists('logged_in_user_id')) {

    function logged_in_user_id() {
        $logged_in_id = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('id') && $CI->session->userdata('role_id')):
            $logged_in_id = $CI->session->userdata('id');
        endif;
        return $logged_in_id;
    }

}

if (!function_exists('logged_in_role_id')) {

    function logged_in_role_id() {
        $logged_in_role_id = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('role_id')):
            $logged_in_role_id = $CI->session->userdata('role_id');
        endif;
        return $logged_in_role_id;
    }

}

if (!function_exists('logged_in_user_type')) {

    function logged_in_user_type() {
        $logged_in_type = 0;
        $CI = & get_instance();
        if ($CI->session->userdata('user_type')):
            $logged_in_id = $CI->session->userdata('user_type');
        endif;
        return $logged_in_type;
    }

}




if (!function_exists('success')) {

    function success($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('success', $message);
        return true;
    }
}

if (!function_exists('error')) {

    function error($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('error', $message);
        return true;
    }

}

if (!function_exists('warning')) {

    function warning($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('warning', $message);
        return true;
    }

}

if (!function_exists('info')) {

    function info($message) {
        $CI = & get_instance();
        $CI->session->set_userdata('info', $message);
        return true;
    }

}

if (!function_exists('get_slug')) {

    function get_slug($slug) {
        if (!$slug) {
            return;
        }

        $char = array("!", "â€™", "'", ":", ",", "_", "`", "~", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "=", "{", "}", "[", "]", "/", ";", '"', '<', '>', '?', "'\'",);
        $slug = str_replace($char, "", $slug);
        return $str = strtolower(str_replace(' ', "-", $slug));
    }

}

if (!function_exists('get_status')) {

    function get_status($status) {
        $ci = & get_instance();
        if ($status == 1) {
            return $ci->lang->line('active');
        } elseif ($status == 2) {
            return $ci->lang->line('in_active');
        } elseif ($status == 3) {
            return $ci->lang->line('trash');
        }
    }

}


if (!function_exists('verify_email_format')) {

    function verify_email_format($email) {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return '';
        } else {
            return $email;
        }
    }

}


if (!function_exists('get_classes')) {

    function get_classes($school_id = null) {
        $ci = & get_instance();
        $ci->db->select('C.*');
        $ci->db->from('classes AS C');
        if($school_id){
            $ci->db->where('C.school_id', $school_id);
        }
         return $ci->db->get()->result();
    }

}

if (!function_exists('get_vehicles')) {

    function get_vehicle_by_ids($ids) {
        $str = '';
        if ($ids) {
            $ci = & get_instance();
            $sql = "SELECT * FROM `vehicles` WHERE `id` IN($ids)";
            $result = $ci->db->query($sql)->result();
            if (!empty($result)) {
                foreach ($result as $obj) {
                    $str .= $obj->number . ',';
                }
            }
        }
        return rtrim($str, ',');
    }

}

if (!function_exists('get_routines_by_day')) {

    function get_routines_by_day($day, $class_id = null, $section_id =null) {
        $ci = & get_instance();
        
        $ci->db->select('R.*, S.name AS subject, T.name AS teacher, C.name AS class_name');
        $ci->db->from('routines AS R');
        $ci->db->join('subjects AS S', 'S.id = R.subject_id', 'left');
        $ci->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
        $ci->db->join('classes AS C', 'C.id = R.class_id', 'left');
        $ci->db->where('R.day', $day);
               
        if(logged_in_role_id() == TEACHER){
            $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id'));
        }else{
            $ci->db->where('R.class_id', $class_id);
            $ci->db->where('R.section_id', $section_id);
        }
        
        $ci->db->order_by("R.id", "ASC");
       return $ci->db->get()->result();
       
        
    }

}

if (!function_exists('get_student_attendance')) {

    function get_student_attendance($student_id, $school_id, $academic_year_id, $class_id, $section_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('SA.' . $field);
        $ci->db->from('student_attendances AS SA');
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.class_id', $class_id);
        
        if($section_id){
            $ci->db->where('SA.section_id', $section_id);
        }
        
        $ci->db->where('SA.year', $year);
        $ci->db->where('SA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}

if (!function_exists('get_teacher_attendance')) {

    function get_teacher_attendance($teacher_id, $school_id, $academic_year_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('TA.' . $field);
        $ci->db->from('teacher_attendances AS TA');
        $ci->db->where('TA.teacher_id', $teacher_id);
        $ci->db->where('TA.school_id', $school_id);
        $ci->db->where('TA.academic_year_id', $academic_year_id);
        $ci->db->where('TA.year', $year);
        $ci->db->where('TA.month', $month);
       return $ci->db->get()->row()->$field;
      // echo $ci->db->last_query();
    }

}

if (!function_exists('get_employee_attendance')) {

    function get_employee_attendance($teacher_id, $school_id, $academic_year_id, $year, $month, $day) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('EA.' . $field);
        $ci->db->from('employee_attendances AS EA');
        $ci->db->where('EA.school_id', $school_id);
        $ci->db->where('EA.employee_id', $teacher_id);
        $ci->db->where('EA.academic_year_id', $academic_year_id);
        $ci->db->where('EA.year', $year);
        $ci->db->where('EA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}

if (!function_exists('get_exam_attendance')) {

    function get_exam_attendance($school_id, $student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('EA.is_attend');
        $ci->db->from('exam_attendances AS EA');
        $ci->db->where('EA.school_id', $school_id);
        $ci->db->where('EA.academic_year_id', $academic_year_id);
        $ci->db->where('EA.exam_id', $exam_id);
        $ci->db->where('EA.class_id', $class_id);
        if($section_id){
            $ci->db->where('EA.section_id', $section_id);
        }
        $ci->db->where('EA.student_id', $student_id);
        $ci->db->where('EA.subject_id', $subject_id);
        return @$ci->db->get()->row()->is_attend;
        
    }

}

if (!function_exists('get_exam_mark')) {

    function get_exam_mark($school_id, $student_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('M.*');
        $ci->db->from('marks AS M');
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.subject_id', $subject_id);
        return $ci->db->get()->row();
    }

}



if (!function_exists('get_exam_total_mark')) {

    function get_exam_total_mark($school_id, $exam_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        
        $ci = & get_instance();
        $ci->db->select('COUNT(M.id) AS total_subject, SUM(G.point) AS total_point, SUM(M.exam_total_mark) AS exam_mark, SUM(M.obtain_total_mark) AS obtain_mark');
        $ci->db->from('marks AS M');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');      
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.exam_id', $exam_id);
        if ($section_id) {
            $ci->db->where('M.section_id', $section_id);
        }
        
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}


if (!function_exists('get_exam_result')) {

    function get_exam_result($school_id, $exim_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        $ci = & get_instance();
        $ci->db->select('ER.*, G.name');
        $ci->db->from('exam_results AS ER');  
        $ci->db->join('grades AS G', 'G.id = ER.grade_id', 'left');  
        $ci->db->where('ER.school_id', $school_id);
        $ci->db->where('ER.exam_id', $exim_id);
        $ci->db->where('ER.class_id', $class_id);
        
        if ($section_id) {
            $ci->db->where('ER.section_id', $section_id);
        }
        
        $ci->db->where('ER.student_id', $student_id);
        $ci->db->where('ER.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}

if (!function_exists('get_mark_form_results')) {

    function get_mark_form_results($school_id, $academic_year_id, $class_id, $student_id, $level = null, $period = null) {
        $ci = & get_instance();
        $ci->db->select('MF.*');
        $ci->db->from('mark_forms AS MF');  
        $ci->db->where('MF.school_id', $school_id);
        $ci->db->where('MF.academic_year_id', $academic_year_id);
        $ci->db->where('MF.student_id', $student_id);
        $ci->db->where('MF.class_id', $class_id);
       // $ci->db->where('MF.section_id', $section_id);
        if(!empty($level)){
            $ci->db->where('MF.level', $level);
        }
        
        if(!empty($period)){
            $ci->db->where('MF.period', $period);
        }
        
        return  $ci->db->get()->result();
    }
}

function get_predicate($type = null, $score) {
    $clientcode = 'ymk';
    if($type == 'adab' || $type == 'murajaah'){
        switch($score){
            case '1':
                $label = 'Jayyid Jiddan';
            break;
            case '2':
                $label = 'Jayyid';
            break;
            case '3':
                $label = 'Maqbul';
            break;
        }
    } else if($type == 'tahsin'){
        if($clientcode == 'ymk'){
            switch($score){
                case '1':
                    $label = 'Maqbul';
                break;
                case '2':
                    $label = 'Jayyid';
                break;
                case '3':
                    $label = 'Jayyid Jiddan';
                break;
            }
        } else {
            switch($score){
                case '1':
                    $label = 'Basic 1';
                break;
                case '2':
                    $label = 'Basic 2';
                break;
                case '3':
                    $label = 'Basic 3';
                break;
            }
        }
        
    } else if($type == 'target'){
        switch($score){
            case '1':
                $label = '25%';
            break;
            case '2':
                $label = '50%';
            break;
            case '3':
                $label = '75%';
            break;
            case '4':
                $label = '100%';
            break;
        }
    } else if($type == 'skill'){
        switch($score){
            case '1':
                $label = 'Belum Terlampaui';
            break;
            case '2':
                $label = 'Terlampaui';
            break;
        }
    }
    
    return $label;
}

function get_markform_score($score = null){
    $grade = '';
    if($score >= 3.5){
        $grade = 'A';
    } else if($score >= 3){
        $grade = 'B';
    } else if($score >=2.5){
        $grade = 'C';
    } else if($score >=1){
        $grade = 'D';
    } else {
        $grade = 'E';
    }
    return $grade;
}


if (!function_exists('get_exam_final_result')) {

    function get_exam_final_result($school_id, $student_id, $academic_year_id, $class_id, $section_id = null) {
        $ci = & get_instance();
        $ci->db->select('FR.*');
        $ci->db->from('final_results AS FR');
        $ci->db->where('FR.class_id', $class_id);
        if ($section_id) {
            $ci->db->where('FR.section_id', $section_id);
        }
        $ci->db->where('FR.school_id', $school_id);
        $ci->db->where('FR.student_id', $student_id);
        $ci->db->where('FR.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }
}



if (!function_exists('get_student_position')) {

    function get_student_position($school_id, $academic_year_id, $class_id, $student_id, $section_id = null) {
        
        $cond = "";
        $condition = " academic_year_id = $academic_year_id ";
        $condition .= " AND school_id = $school_id";
        $condition .= " AND class_id = $class_id";        
        if($section_id){
           $condition .= " AND section_id = $section_id";
        }
        
        $cond = $condition;
        $condition .= " AND student_id = $student_id";
        
       
        
        $ci = & get_instance();              
        $sql = "SELECT id, avg_grade_point, FIND_IN_SET( (avg_grade_point), 
                ( SELECT GROUP_CONCAT( (avg_grade_point) ORDER BY avg_grade_point DESC )
                FROM final_results WHERE $cond  )) AS rank 
                FROM final_results 
                WHERE $condition";
        
        $result =  $ci->db->query($sql)->row(); 
      
        $rank = '';
        if(!empty($result)){
            $rank = $result->rank;
        }
                       
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}



if (!function_exists('get_lowet_height_mark')) {

    function get_lowet_height_mark($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id) {
        $ci = & get_instance();
        $ci->db->select('MIN(M.obtain_total_mark) AS lowest, MAX(M.obtain_total_mark) AS height');
        $ci->db->from('marks AS M');       
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.exam_id', $exam_id);
        $ci->db->where('M.class_id', $class_id);
        $ci->db->where('M.section_id', $section_id);
        $ci->db->where('M.subject_id', $subject_id);  
        return  $ci->db->get()->row();
     // echo $ci->db->last_query();
    }
}


if (!function_exists('get_position_in_subject')) {

    function get_position_in_subject($school_id, $academic_year_id, $exam_id, $class_id, $section_id, $subject_id, $mark) {
        
        
        $ci = & get_instance();
        $sec = "";
        if($section_id){
           $sec = " AND section_id = $section_id"; 
        }
        
        $sql = "SELECT id, obtain_total_mark, FIND_IN_SET( obtain_total_mark,(
                SELECT GROUP_CONCAT( obtain_total_mark  ORDER BY obtain_total_mark DESC ) 
                FROM marks WHERE  
                school_id = $school_id
                AND academic_year_id = $academic_year_id
                AND exam_id = $exam_id
                AND class_id = $class_id
                $sec
                AND subject_id = $subject_id))
                AS rank 
                FROM marks
                WHERE school_id = $school_id
                   AND academic_year_id = $academic_year_id  
                   AND exam_id = $exam_id
                   AND class_id = $class_id 
                   $sec 
                   AND subject_id = $subject_id 
                   AND  obtain_total_mark = $mark"; 
        
        $rank =  $ci->db->query($sql)->row()->rank; 
        
        if($mark == 0){
            return '--'; 
        }
        
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}


if (!function_exists('get_subject_list')) {

    function get_subject_list($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null, $group_id = null) {
        $ci = & get_instance();
        $ci->db->select('M.*,S.name AS subject, S.mark AS subjectmark, G.point, G.name');
        $ci->db->from('marks AS M');        
        $ci->db->join('subjects AS S', 'S.id = M.subject_id', 'left');
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.class_id', $class_id);
        if($group_id){
            $ci->db->where('S.group_id', $group_id);
        }
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);
        return  $ci->db->get()->result();     
    }

}



if (!function_exists('get_exam_wise_markt')) {

    function get_exam_wise_markt($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();
        
        $select = 'SUM(M.written_mark) AS written_mark,
                   SUM(M.written_obtain) AS written_obtain,
                   SUM(M.tutorial_mark) AS tutorial_mark,
                   SUM(M.tutorial_obtain) AS tutorial_obtain,
                   SUM(M.practical_mark) AS practical_mark,
                   SUM(M.practical_obtain) AS practical_obtain,
                   SUM(M.viva_mark) AS viva_mark,
                   SUM(M.viva_obtain) AS viva_obtain,
                   COUNT(M.id) AS total_subject,
                   SUM(G.point) AS point               
                   ';
        
        $ci->db->select($select);
        $ci->db->from('marks AS M');        
        $ci->db->join('grades AS G', 'G.id = M.grade_id', 'left');          
        $ci->db->where('M.school_id', $school_id);
        $ci->db->where('M.academic_year_id', $academic_year_id);
        $ci->db->where('M.class_id', $class_id);
        if($section_id){
            $ci->db->where('M.section_id', $section_id);
        }
        $ci->db->where('M.student_id', $student_id);
        $ci->db->where('M.exam_id', $exam_id);        
        return $ci->db->get()->row();  
        // $ci->db->last_query();
    }
}


if (!function_exists('get_position_in_exam')) {

    function get_position_in_exam($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $mark = null) {
                
        $ci = & get_instance();
        
        $sec = "";
        if($section_id){
           $sec = " AND section_id = $section_id"; 
        }
        
        $sql = "SELECT id, total_obtain_mark, FIND_IN_SET( total_obtain_mark,(
                SELECT GROUP_CONCAT( total_obtain_mark  ORDER BY total_obtain_mark DESC ) 
                FROM exam_results WHERE 
                school_id = $school_id 
                AND academic_year_id = $academic_year_id 
                AND exam_id = $exam_id 
                AND class_id = $class_id 
                $sec ))
                AS rank 
                FROM exam_results
                WHERE school_id = $school_id 
                AND academic_year_id = $academic_year_id
                AND exam_id = $exam_id 
                AND class_id = $class_id 
                $sec 
                AND total_obtain_mark = $mark"; 
        
        $rank =  @$ci->db->query($sql)->row()->rank; 
        
        if($mark == 0){
            return '--'; 
        }
        
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}


if (!function_exists('get_lowet_height_result')) {

    function get_lowet_height_result($school_id, $academic_year_id, $exam_id, $class_id, $section_id = null, $student_id = null) {
        $ci = & get_instance();
        $ci->db->select('MIN(ER.total_obtain_mark) AS lowest, MAX(ER.total_obtain_mark) AS height');
        $ci->db->from('exam_results AS ER');       
        $ci->db->where('ER.school_id', $school_id);
        $ci->db->where('ER.academic_year_id', $academic_year_id);
        $ci->db->where('ER.exam_id', $exam_id);
        $ci->db->where('ER.class_id', $class_id);
        if($section_id){
           $ci->db->where('ER.section_id', $section_id);
        }
        
        return  $ci->db->get()->row();
    }

}



if (!function_exists('get_final_result')) {
    
    function get_final_result($school_id, $academic_year_id, $class_id, $section_id, $student_id){
        
        $ci = & get_instance();
        $ci->db->select('FR.*, G.name AS grade');
        $ci->db->from('final_results AS FR');        
        $ci->db->join('grades AS G', 'G.id = FR.grade_id', 'left');
        $ci->db->where('FR.academic_year_id', $academic_year_id);
        $ci->db->where('FR.school_id', $school_id);
        $ci->db->where('FR.class_id', $class_id);
        if($section_id){
          $ci->db->where('FR.section_id', $section_id);
        }
        $ci->db->where('FR.student_id', $student_id);
        return $ci->db->get()->row();       
    }
}


if (!function_exists('get_position_in_class')) {

    function get_position_in_class($school_id, $academic_year_id, $class_id, $student_id) {
       
        
        $condition = " school_id = $school_id";
        $condition .= " AND academic_year_id = $academic_year_id";
        $condition .= " AND class_id = $class_id";
        $condition .= " AND student_id = $student_id";       
        
        $ci = & get_instance();              
        $sql = "SELECT id, avg_grade_point, FIND_IN_SET( (avg_grade_point+total_obtain_mark), 
                ( SELECT GROUP_CONCAT( (avg_grade_point+total_obtain_mark) ORDER BY avg_grade_point DESC )
                FROM final_results ) ) AS rank 
                FROM final_results 
                WHERE $condition";
        
        $rank =  @$ci->db->query($sql)->row()->rank; 
         
        if($rank == 1){
            return $rank.'st';
        }elseif($rank == 2){
           return $rank.'nd'; 
        }elseif($rank == 3){
           return $rank.'rd'; 
        }elseif($rank > 3 ){
            return $rank.'th';         
        }else{
            return '--'; 
        }
    }

}




if (!function_exists('get_enrollment')) {

    function get_enrollment($student_id, $academic_year_id, $school_id = null) {
        $ci = & get_instance();
        $ci->db->select('E.*');
        $ci->db->from('enrollments AS E');
        $ci->db->where('E.student_id', $student_id);
        $ci->db->where('E.academic_year_id', $academic_year_id);
        if($school_id){
            $ci->db->where('E.school_id', $school_id);
        }
        return $ci->db->get()->row();
    }

}

if (!function_exists('get_user_by_role')) {

    function get_user_by_role($role_id, $user_id, $academic_year_id = null) {

        $ci = & get_instance();

        if ($role_id == SUPER_ADMIN) {
            
            $ci->db->select('SA.*, U.username, U.role_id');
            $ci->db->from('system_admin AS SA');
            $ci->db->join('users AS U', 'U.id = SA.user_id', 'left');
            $ci->db->where('SA.user_id', $user_id);
            return $ci->db->get()->row();

        }elseif ($role_id == STUDENT) {

            $ci->db->select('S.*, T.type,  D.amount, D.title AS discount, G.name AS guardian, E.roll_no, E.section_id, E.class_id, E.class_tahfizh_id, E.class_bpi_id, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $ci->db->from('enrollments AS E');
            $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
            $ci->db->join('student_types AS T', 'T.id = S.type_id', 'left');
            $ci->db->join('guardians AS G', 'G.id = S.guardian_id', 'left');
            $ci->db->join('users AS U', 'U.id = S.user_id', 'left');
            $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $ci->db->join('discounts AS D', 'D.id = S.discount_id', 'left');
            if($academic_year_id){
                $ci->db->where('E.academic_year_id', $academic_year_id);
            }
            $ci->db->where('S.user_id', $user_id);
            
            return $ci->db->get()->row();
            
        } elseif ($role_id == TEACHER) {
            
            $ci->db->select('T.*, U.username, U.role_id');
            $ci->db->from('teachers AS T');
            $ci->db->join('users AS U', 'U.id = T.user_id', 'left');
            $ci->db->where('T.user_id', $user_id);
            return $ci->db->get()->row();
            
        } elseif ($role_id == GUARDIAN) {
            
            $ci->db->select('G.*, U.username, U.role_id');
            $ci->db->from('guardians AS G');
            $ci->db->join('users AS U', 'U.id = G.user_id', 'left');
            $ci->db->where('G.user_id', $user_id);
            return $ci->db->get()->row();
                
        } else {
            
            $ci->db->select('E.*, SG.grade_name, U.username, U.role_id, D.name AS designation');
            $ci->db->from('employees AS E');
            $ci->db->join('users AS U', 'U.id = E.user_id', 'left');
            $ci->db->join('designations AS D', 'D.id = E.designation_id', 'left');
            $ci->db->join('salary_grades AS SG', 'SG.id = E.salary_grade_id', 'left');
            $ci->db->where('E.user_id', $user_id);
            return $ci->db->get()->row();
        }

        $ci->db->last_query();
    }

}


if (!function_exists('get_user_by_id')) {

    function get_user_by_id($user_id) {

        $ci = & get_instance();

        $ci->db->select('U.id, U.role_id');
        $ci->db->from('users AS U');
        $ci->db->where('U.id', $user_id);
        $user = $ci->db->get()->row();

        if ($user->role_id == SUPER_ADMIN) {
            
            $ci->db->select('SA.*, U.username, U.role_id');
            $ci->db->from('system_admin AS SA');
            $ci->db->join('users AS U', 'U.id = SA.user_id', 'left');
            $ci->db->where('SA.user_id', $user_id);
            return $ci->db->get()->row();
            
        }else if ($user->role_id == STUDENT) {

            $ci->db->select('S.*, E.roll_no, U.username, U.role_id,  C.name AS class_name, SE.name AS section');
            $ci->db->from('enrollments AS E');
            $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
            $ci->db->join('users AS U', 'U.id = S.user_id', 'left');
            $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
            $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
            $ci->db->where('S.user_id', $user_id);            
            return $ci->db->get()->row();
            
        } elseif ($user->role_id == TEACHER) {
            
            $ci->db->select('T.*, U.username, U.role_id');
            $ci->db->from('teachers AS T');
            $ci->db->join('users AS U', 'U.id = T.user_id', 'left');
            $ci->db->where('T.user_id', $user_id);
            return $ci->db->get()->row();
            
        } elseif ($user->role_id == GUARDIAN) {
            
            $ci->db->select('G.*, U.username, U.role_id');
            $ci->db->from('guardians AS G');
            $ci->db->join('users AS U', 'U.id = G.user_id', 'left');
            $ci->db->where('G.user_id', $user_id);
            return $ci->db->get()->row();        
            
        } else {
            
            $ci->db->select('E.*, U.username, U.role_id, D.name AS designation');
            $ci->db->from('employees AS E');
            $ci->db->join('users AS U', 'U.id = E.user_id', 'left');
            $ci->db->join('designations AS D', 'D.id = E.designation_id', 'left');
            $ci->db->where('E.user_id', $user_id);
            return  $ci->db->get()->row();
        }

        // $ci->db->last_query();
    }

}


if (!function_exists('get_total_used_leave')) {

    function get_total_used_leave($academic_year_id, $role_id, $type_id, $user_id) {
        $ci = & get_instance();
        
        $ci->db->select('sum(A.leave_day) AS total');
        $ci->db->from('leave_applications AS A');
        $ci->db->where('A.role_id', $role_id);
        $ci->db->where('A.type_id', $type_id);
        $ci->db->where('A.user_id', $user_id);
        $ci->db->where('A.academic_year_id', $academic_year_id);
        $ci->db->where('A.leave_status', 2);
        $result = $ci->db->get()->row();
      
        if(!empty($result)){
            return $result->total;
        }else{
            return 0;
        }
    }
}


if (!function_exists('get_blood_group')) {

    function get_blood_group() {
        $ci = & get_instance();
        return array(
            'a_positive' => $ci->lang->line('a_positive'),
            'a_negative' => $ci->lang->line('a_negative'),
            'b_positive' => $ci->lang->line('b_positive'),
            'b_negative' => $ci->lang->line('b_negative'),
            'o_positive' => $ci->lang->line('o_positive'),
            'o_negative' => $ci->lang->line('o_negative'),
            'ab_positive' => $ci->lang->line('ab_positive'),
            'ab_negative' => $ci->lang->line('ab_negative')
        );
    }

}

if (!function_exists('get_subject_type')) {

    function get_subject_type() {
        $ci = & get_instance();
        return array(
            'mandatory' => $ci->lang->line('mandatory'),
            'optional' => $ci->lang->line('optional')
        );
    }

}

if (!function_exists('get_groups')) {

    function get_groups() {
        $ci = & get_instance();
        return array(
            'science' => $ci->lang->line('science'),
            'socialstudies' => "IPS"
            //'science' => $ci->lang->line('science'),
            //'arts' => $ci->lang->line('arts'),
            //'commerce' => $ci->lang->line('commerce')
        );
    }

}


if (!function_exists('get_week_days')) {

    function get_week_days() {
        $ci = & get_instance();
        return array(           
            'monday' => $ci->lang->line('monday'),
            'tuesday' => $ci->lang->line('tuesday'),
            'wednesday' => $ci->lang->line('wednesday'),
            'thursday' => $ci->lang->line('thursday'),
            'friday' => $ci->lang->line('friday'),
             'saturday' => $ci->lang->line('saturday'),
            'sunday' => $ci->lang->line('sunday')
        );
    }

}

if (!function_exists('get_months')) {

    function get_months() {
        $ci = & get_instance();
        return array(
            'january' => $ci->lang->line('january'),
            'february' => $ci->lang->line('february'),
            'march' => $ci->lang->line('march'),
            'april' => $ci->lang->line('april'),
            'may' => $ci->lang->line('may'),
            'june' => $ci->lang->line('june'),
            'july' => $ci->lang->line('july'),
            'august' => $ci->lang->line('august'),
            'september' => $ci->lang->line('september'),
            'october' => $ci->lang->line('october'),
            'november' => $ci->lang->line('november'),
            'december' => $ci->lang->line('december')
        );
    }

}

if (!function_exists('get_hostel_types')) {

    function get_hostel_types() {
        $ci = & get_instance();
        return array(
            'boys' => $ci->lang->line('boys'),
            'girls' => $ci->lang->line('girls'),
            'combine' => $ci->lang->line('combine')
        );
    }
}

if (!function_exists('get_page_location')) {

    function get_page_location() {
        $ci = & get_instance();
        return array(
            'header' => $ci->lang->line('header'),
            'footer' => $ci->lang->line('footer'),
        );
    }
}

if (!function_exists('get_room_types')) {

    function get_room_types() {
        $ci = & get_instance();
        return array(
            'ac' => $ci->lang->line('ac'),
            'non_ac' => $ci->lang->line('non_ac')
        );
    }

}


if (!function_exists('get_genders')) {

    function get_genders() {
        $ci = & get_instance();
        return array(
            'male' => $ci->lang->line('male'),
            'female' => $ci->lang->line('female')
        );
    }

}

if (!function_exists('get_paid_types')) {

    function get_paid_status($status) {
        $ci = & get_instance();
        $data = array(
            'paid' => $ci->lang->line('paid'),
            'unpaid' => $ci->lang->line('unpaid'),
            'partial' => $ci->lang->line('partial')
        );
        return $data[$status];
    }

}
/*
if (!function_exists('get_relation_types')) {

    function get_relation_types() {
        $ci = & get_instance();
        return array(
            'father' => $ci->lang->line('father'),
            'mother' => $ci->lang->line('mother'),
            'sister' => $ci->lang->line('sister'),
            'brother' => $ci->lang->line('brother'),
            'uncle' => $ci->lang->line('uncle'),
            'maternal_uncle' => $ci->lang->line('maternal_uncle'),
            'other_relative' => $ci->lang->line('other_relative')
        );
    }
}
*/


if (!function_exists('get_video_types')) {

    function get_video_types() {
        $ci = & get_instance();
        return array(
            'youtube' => $ci->lang->line('youtube'),
            'vimeo' => $ci->lang->line('vimeo'),
            'ppt' => $ci->lang->line('power_point')
        );
    }
}

if (!function_exists('get_payment_methods')) {

    function get_payment_methods($school_id = null) {
        $ci = & get_instance();

        $methods = array('cash' => $ci->lang->line('cash'), 'cheque' => $ci->lang->line('cheque'), 'receipt' => $ci->lang->line('bank_receipt'));
          
        if($ci->session->userdata('role_id') != SUPER_ADMIN){
            $school_id =  $ci->session->userdata('school_id');
        }
        
        $ci->db->select('PS.*');
        $ci->db->from('payment_settings AS PS');  
        if($school_id){
            $ci->db->where('PS.school_id', $school_id);
        }
        
        $data = $ci->db->get()->row();
        if(!empty($data)){ 
            if ($data->paypal_status) {
                $methods['paypal'] = $ci->lang->line('paypal');
            }
            if ($data->payumoney_status) {
                $methods['payumoney'] = $ci->lang->line('payumoney');
            }
            /*if ($data->stripe_status) {
                $methods['stripe'] = $ci->lang->line('stripe');
            }
            if ($data->ccavenue_status) {
                $methods['ccavenue'] = $ci->lang->line('ccavenue');
            }*/
            if ($data->paytm_status) {
                $methods['paytm'] = $ci->lang->line('paytm');
            }            
            if ($data->stack_status) {
                $methods['paystack'] = $ci->lang->line('pay_stack');
            }
        }

        return $methods;
    }

}

if (!function_exists('get_sms_gateways')) {

    function get_sms_gateways( $school_id ) {
        
        $ci = & get_instance();
        $gateways = array();
       
        $ci->db->select('SS.*');
        $ci->db->from('sms_settings AS SS');
        $ci->db->where('SS.school_id', $school_id);
        $data = $ci->db->get()->row();

        if(!empty($data)){
            
            if ($data->clickatell_status) {
                $gateways['clicktell'] = $ci->lang->line('clicktell');
            }
            if ($data->twilio_status) {
                $gateways['twilio'] = $ci->lang->line('twilio');
            }
            if ($data->bulk_status) {
                $gateways['bulk'] = $ci->lang->line('bulk');
            }
            if ($data->msg91_status) {
                $gateways['msg91'] = $ci->lang->line('msg91');
            }
            if ($data->plivo_status) {
                $gateways['plivo'] = $ci->lang->line('plivo');
            }
            if ($data->textlocal_status) {
                $gateways['text_local'] = $ci->lang->line('text_local');
            }
            if ($data->smscountry_status) {
                $gateways['sms_country'] = $ci->lang->line('sms_country');
            }
            if ($data->betasms_status) {
                $gateways['beta_sms'] = $ci->lang->line('beta_sms');
            }
            if ($data->bulk_pk_status) {
                $gateways['bulk_pk'] = $ci->lang->line('bulk_pk');
            }
            if ($data->cluster_status) {
                $gateways['sms_custer'] = $ci->lang->line('sms_custer');
            }
            if ($data->alpha_status) {
                $gateways['alpha_net'] = $ci->lang->line('alpha_net');
            }
            if ($data->bdbulk_status) {
                $gateways['bd_bulk'] = $ci->lang->line('bd_bulk');
            }
            if ($data->mim_status) {
                $gateways['mim_sms'] = $ci->lang->line('mim_sms');
            }
         }
        return $gateways;
    }

}


if (!function_exists('get_group_by_type')) {

    function get_group_by_type() {
        $ci = & get_instance();
        return array(
            'daily' => $ci->lang->line('daily'),
            'monthly' => $ci->lang->line('monthly'),
            'yearly' => $ci->lang->line('yearly')
        );
    }

}


if (!function_exists('get_template_tags')) {

    function get_template_tags($role_id) {
        $tags = array();
        $tags[] = '[name]';
        $tags[] = '[email]';
        $tags[] = '[phone]';

        if($role_id == SUPER_ADMIN){
            
            $tags[] = '[designation]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';            
        }elseif ($role_id == STUDENT) {

            $tags[] = '[class_name]';
            $tags[] = '[section]';
            $tags[] = '[roll_no]';
            $tags[] = '[dob]';
            $tags[] = '[gender]';
            $tags[] = '[religion]';
            $tags[] = '[blood_group]';
            $tags[] = '[registration_no]';
            $tags[] = '[group]';
            $tags[] = '[created_at]';
            $tags[] = '[guardian]';
            
        } else if ($role_id == GUARDIAN) {
            $tags[] = '[profession]';
        } else if ($role_id == TEACHER) {
            $tags[] = '[responsibility]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';
            $tags[] = '[joining_date]';
        } else {
            $tags[] = '[designation]';
            $tags[] = '[gender]';
            $tags[] = '[blood_group]';
            $tags[] = '[religion]';
            $tags[] = '[dob]';
            $tags[] = '[joining_date]';
        }

        $tags[] = '[present_address]';
        $tags[] = '[permanent_address]';

        return $tags;
    }

}

if (!function_exists('get_formatted_body')) {

    function get_formatted_body($body, $role_id, $user_id) {

         $ci = & get_instance();
        $tags = get_template_tags($role_id);
        $user = get_user_by_role($role_id, $user_id);
             
        $arr = array('[', ']');
        foreach ($tags as $tag) {
            $field = str_replace($arr, '', $tag);
            
            if($field == 'blood_group'){                
                 $body = str_replace($tag, $ci->lang->line($user->{$field}), $body);              
            }elseif($field == 'gender'){                
                 $body = str_replace($tag, $ci->lang->line($user->{$field}), $body);              
            }elseif($field == 'group'){                
                 $body = str_replace($tag, $ci->lang->line($user->{$field}), $body);              
            }elseif($field == 'created_at'){                
                $body = str_replace($tag, date('M-d-Y', strtotime($user->created_at)), $body);                
            }else{
                $body = str_replace($tag, $user->{$field}, $body);
            } 
        }
        return $body;
    }
}

if (!function_exists('get_formatted_certificate_text')) {

    function get_formatted_certificate_text($body, $role_id, $user_id) {

        $tags = get_template_tags($role_id);
        $user = get_user_by_role($role_id, $user_id);
              
        $arr = array('[', ']');
        foreach ($tags as $tag) {
            $field = str_replace($arr, '', $tag);
            
            if($field == 'created_at'){                
                $body = str_replace($tag, '<span>'.date('M-d-Y', strtotime($user->created_at)).'</span>', $body);                
            }else{
                $body = str_replace($tag, '<span>'.$user->{$field}.'</span>', $body);
            }            
        }

        return $body;
    }
}



if (!function_exists('get_nice_time')) {

    function get_nice_time($date) {

        $ci = & get_instance();
        if (empty($date)) {
            return "2 months ago"; //"No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();
        $unix_date = strtotime($date);

        // check validity of date
        if (empty($unix_date)) {
            return "2 months ago"; // "Bad date";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

}



if (!function_exists('get_inbox_message')) {

    function get_inbox_message() {
        $ci = & get_instance();
        $ci->db->select('MR.*, M.*');
        $ci->db->from('message_relationships AS MR');
        $ci->db->join('messages AS M', 'M.id = MR.message_id', 'left');
        $ci->db->where('MR.status', 1);
        $ci->db->where('MR.is_read', 0);
        $ci->db->where('MR.owner_id', logged_in_user_id());
        $ci->db->where('MR.receiver_id', logged_in_user_id());
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_hostel_by_school')) {

    function get_hostel_by_school($school_id) {
        $ci = & get_instance();
        $ci->db->select('H.*');
        $ci->db->from('hostels AS H');
        $ci->db->where('H.school_id', $school_id);
       return $ci->db->get()->result();
    }

}

if (!function_exists('get_gallery_images')) {

    function get_gallery_images($school_id, $gallery_id) {
        $ci = & get_instance();
        $ci->db->select('GI.*');
        $ci->db->from('gallery_images AS GI');
        $ci->db->where('GI.school_id', $school_id);
        $ci->db->where('GI.gallery_id', $gallery_id);
       return $ci->db->get()->result();
    }
}


if (!function_exists('get_fee_amount')) {

    function get_fee_amount($income_head_id, $class_id) {
        $ci = & get_instance();
        return $ci->db->get_where('fees_amount', array('class_id'=>$class_id, 'income_head_id'=>$income_head_id))->row();
    }
}

if (!function_exists('get_invoice_paid_amount')) {

    function get_invoice_paid_amount($invoice_id){
        $ci = & get_instance();
        $ci->db->select('I.*, SUM(T.amount) AS paid_amount');
        $ci->db->from('invoices AS I');        
        $ci->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $ci->db->where('I.id', $invoice_id);         
        return $ci->db->get()->row(); 
    }
}

if (!function_exists('get_operation_by_module')) {

    function get_operation_by_module($module_id) {
        $ci = & get_instance();
        $ci->db->select('O.*');
        $ci->db->from('operations AS O');
        $ci->db->where('O.module_id', $module_id);
        return $ci->db->get()->result();
    }

}

if (!function_exists('get_permission_by_operation')) {

    function get_permission_by_operation($role_id, $operation_id) {
        $ci = & get_instance();
        $ci->db->select('P.*');
        $ci->db->from('privileges AS P');
        $ci->db->where('P.role_id', $role_id);
        $ci->db->where('P.operation_id', $operation_id);
        return $ci->db->get()->row();
    }
}

if (!function_exists('get_school_list')) {

    function get_school_list() {
        $ci = & get_instance();
        $ci->db->select('S.*');
        $ci->db->from('schools AS S');
        $ci->db->where('S.status', 1);
        return $ci->db->get()->result();
    }
}

if (!function_exists('get_lang')) {

    function get_lang() {
        $ci = & get_instance();
        $ci->lang->line('dashboard');
    }

}

if (!function_exists('get_default_lang_list')) {

    function get_default_lang_list($lang) {
        $lang_lists = array();
        $lang_lists['english'] = 'english';
        $lang_lists['bengali'] = 'bengali';
        $lang_lists['spanish'] = 'spanish';
        $lang_lists['arabic'] = 'arabic';
        $lang_lists['hindi'] = 'hindi';
        $lang_lists['urdu'] = 'urdu';
        $lang_lists['chinese'] = 'chinese';
        $lang_lists['japanese'] = 'japanese';
        $lang_lists['portuguese'] = 'portuguese';
        $lang_lists['russian'] = 'russian';
        $lang_lists['french'] = 'french';
        $lang_lists['korean'] = 'korean';
        $lang_lists['german'] = 'german';
        $lang_lists['italian'] = 'italian';
        $lang_lists['thai'] = 'thai';
        $lang_lists['hungarian'] = 'hungarian';
        $lang_lists['dutch'] = 'dutch';
        $lang_lists['latin'] = 'latin';
        $lang_lists['indonesian'] = 'indonesian';
        $lang_lists['turkish'] = 'turkish';
        $lang_lists['greek'] = 'greek';
        $lang_lists['persian'] = 'persian';
        $lang_lists['malay'] = 'malay';
        $lang_lists['telugu'] = 'telugu';
        $lang_lists['tamil'] = 'tamil';
        $lang_lists['gujarati'] = 'gujarati';
        $lang_lists['polish'] = 'polish';
        $lang_lists['ukrainian'] = 'ukrainian';
        $lang_lists['panjabi'] = 'panjabi';
        $lang_lists['romanian'] = 'romanian';
        $lang_lists['burmese'] = 'burmese';
        $lang_lists['yoruba'] = 'yoruba';
        $lang_lists['hausa'] = 'hausa';

        if (isset($lang_lists[$lang]) && !empty($lang_lists[$lang])) {
            return true;
        } else {
            return FALSE;
        }
    }

}


if (!function_exists('get_timezones')) {
    function get_timezones() {
        $timezones = array(           
            'Pacific/Midway' => "(GMT-11:00) Midway Island",
            'US/Samoa' => "(GMT-11:00) Samoa",
            'US/Hawaii' => "(GMT-10:00) Hawaii",
            'US/Alaska' => "(GMT-09:00) Alaska",
            'US/Pacific' => "(GMT-08:00) Pacific Time (US &amp; Canada)",
            'America/Tijuana' => "(GMT-08:00) Tijuana",
            'US/Arizona' => "(GMT-07:00) Arizona",
            'US/Mountain' => "(GMT-07:00) Mountain Time (US &amp; Canada)",
            'America/Chihuahua' => "(GMT-07:00) Chihuahua",
            'America/Mazatlan' => "(GMT-07:00) Mazatlan",
            'America/Mexico_City' => "(GMT-06:00) Mexico City",
            'America/Monterrey' => "(GMT-06:00) Monterrey",
            'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
            'US/Central' => "(GMT-06:00) Central Time (US &amp; Canada)",
            'US/Eastern' => "(GMT-05:00) Eastern Time (US &amp; Canada)",
            'US/East-Indiana' => "(GMT-05:00) Indiana (East)",
            'America/Bogota' => "(GMT-05:00) Bogota",
            'America/Lima' => "(GMT-05:00) Lima",
            'America/Caracas' => "(GMT-04:30) Caracas",
            'Canada/Atlantic' => "(GMT-04:00) Atlantic Time (Canada)",
            'America/La_Paz' => "(GMT-04:00) La Paz",
            'America/Santiago' => "(GMT-04:00) Santiago",
            'Canada/Newfoundland' => "(GMT-03:30) Newfoundland",
            'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
            'Greenland' => "(GMT-03:00) Greenland",
            'Atlantic/Stanley' => "(GMT-02:00) Stanley",
            'Atlantic/Azores' => "(GMT-01:00) Azores",
            'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
            'Africa/Casablanca' => "(GMT) Casablanca",
            'Europe/Dublin' => "(GMT) Dublin",
            'Europe/Lisbon' => "(GMT) Lisbon",
            'Europe/London' => "(GMT) London",
            'Africa/Monrovia' => "(GMT) Monrovia",
            'Europe/Amsterdam' => "(GMT+01:00) Amsterdam",
            'Europe/Belgrade' => "(GMT+01:00) Belgrade",
            'Europe/Berlin' => "(GMT+01:00) Berlin",
            'Europe/Bratislava' => "(GMT+01:00) Bratislava",
            'Europe/Brussels' => "(GMT+01:00) Brussels",
            'Europe/Budapest' => "(GMT+01:00) Budapest",
            'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
            'Europe/Ljubljana' => "(GMT+01:00) Ljubljana",
            'Europe/Madrid' => "(GMT+01:00) Madrid",
            'Europe/Paris' => "(GMT+01:00) Paris",
            'Europe/Prague' => "(GMT+01:00) Prague",
            'Europe/Rome' => "(GMT+01:00) Rome",
            'Europe/Sarajevo' => "(GMT+01:00) Sarajevo",
            'Europe/Skopje' => "(GMT+01:00) Skopje",
            'Europe/Stockholm' => "(GMT+01:00) Stockholm",
            'Europe/Vienna' => "(GMT+01:00) Vienna",
            'Europe/Warsaw' => "(GMT+01:00) Warsaw",
            'Europe/Zagreb' => "(GMT+01:00) Zagreb",
            'Europe/Athens' => "(GMT+02:00) Athens",
            'Europe/Bucharest' => "(GMT+02:00) Bucharest",
            'Africa/Cairo' => "(GMT+02:00) Cairo",
            'Africa/Harare' => "(GMT+02:00) Harare",
            'Europe/Helsinki' => "(GMT+02:00) Helsinki",
            'Europe/Istanbul' => "(GMT+02:00) Istanbul",
            'Asia/Jerusalem' => "(GMT+02:00) Jerusalem",
            'Europe/Kiev' => "(GMT+02:00) Kyiv",
            'Europe/Minsk' => "(GMT+02:00) Minsk",
            'Europe/Riga' => "(GMT+02:00) Riga",
            'Europe/Sofia' => "(GMT+02:00) Sofia",
            'Europe/Tallinn' => "(GMT+02:00) Tallinn",
            'Europe/Vilnius' => "(GMT+02:00) Vilnius",
            'Asia/Baghdad' => "(GMT+03:00) Baghdad",
            'Asia/Kuwait' => "(GMT+03:00) Kuwait",
            'Africa/Nairobi' => "(GMT+03:00) Nairobi",
            'Asia/Riyadh' => "(GMT+03:00) Riyadh",
            'Asia/Tehran' => "(GMT+03:30) Tehran",
            'Europe/Moscow' => "(GMT+04:00) Moscow",
            'Asia/Baku' => "(GMT+04:00) Baku",
            'Europe/Volgograd' => "(GMT+04:00) Volgograd",
            'Asia/Muscat' => "(GMT+04:00) Muscat",
            'Asia/Tbilisi' => "(GMT+04:00) Tbilisi",
            'Asia/Yerevan' => "(GMT+04:00) Yerevan",
            'Asia/Kabul' => "(GMT+04:30) Kabul",
            'Asia/Karachi' => "(GMT+05:00) Karachi",
            'Asia/Tashkent' => "(GMT+05:00) Tashkent",
            'Asia/Kolkata' => "(GMT+05:30) Kolkata",
            'Asia/Kathmandu' => "(GMT+05:45) Kathmandu",
            'Asia/Yekaterinburg' => "(GMT+06:00) Ekaterinburg",
            'Asia/Almaty' => "(GMT+06:00) Almaty",
            'Asia/Dhaka' => "(GMT+06:00) Dhaka",
            'Asia/Novosibirsk' => "(GMT+07:00) Novosibirsk",
            'Asia/Bangkok' => "(GMT+07:00) Bangkok",
            'Asia/Jakarta' => "(GMT+07:00) Jakarta",
            'Asia/Krasnoyarsk' => "(GMT+08:00) Krasnoyarsk",
            'Asia/Chongqing' => "(GMT+08:00) Chongqing",
            'Asia/Hong_Kong' => "(GMT+08:00) Hong Kong",
            'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
            'Australia/Perth' => "(GMT+08:00) Perth",
            'Asia/Singapore' => "(GMT+08:00) Singapore",
            'Asia/Taipei' => "(GMT+08:00) Taipei",
            'Asia/Ulaanbaatar' => "(GMT+08:00) Ulaan Bataar",
            'Asia/Urumqi' => "(GMT+08:00) Urumqi",
            'Asia/Irkutsk' => "(GMT+09:00) Irkutsk",
            'Asia/Seoul' => "(GMT+09:00) Seoul",
            'Asia/Tokyo' => "(GMT+09:00) Tokyo",
            'Australia/Adelaide' => "(GMT+09:30) Adelaide",
            'Australia/Darwin' => "(GMT+09:30) Darwin",
            'Asia/Yakutsk' => "(GMT+10:00) Yakutsk",
            'Australia/Brisbane' => "(GMT+10:00) Brisbane",
            'Australia/Canberra' => "(GMT+10:00) Canberra",
            'Pacific/Guam' => "(GMT+10:00) Guam",
            'Australia/Hobart' => "(GMT+10:00) Hobart",
            'Australia/Melbourne' => "(GMT+10:00) Melbourne",
            'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
            'Australia/Sydney' => "(GMT+10:00) Sydney",
            'Asia/Vladivostok' => "(GMT+11:00) Vladivostok",
            'Asia/Magadan' => "(GMT+12:00) Magadan",
            'Pacific/Auckland' => "(GMT+12:00) Auckland",
            'Pacific/Fiji' => "(GMT+12:00) Fiji",
        );

        return $timezones;
    }
}


if (!function_exists('get_date_format')) {
    function get_date_format() {
        
        $date = array();
        $date['Y-m-d'] = '2001-03-15';
        $date['d-m-Y'] = '15-03-2018';
        $date['d/m/Y'] = '15/03/2018';
        $date['m/d/Y'] = '03/15/2018';
        $date['m.d.Y'] = '03.10.2018';
        $date['j, n, Y'] = '14, 7, 2018';
        $date['F j, Y'] = 'July 15, 2018';
        $date['M j, Y'] = 'Jul 13, 2018';
        $date['j M, Y'] = '13 Jul, 2018';
        
        return $date;
    }
}


if (!function_exists('get_mail_protocol')) {
    function get_mail_protocol() {
        
        $protocol = array();
        $protocol['mail'] = 'mail';
        $protocol['sendmail'] = 'sendmail';
        $protocol['smtp'] = 'smtp';        
        
        return $protocol;
    }
}

if (!function_exists('get_smtp_crypto')) {
    function get_smtp_crypto() {
        
        $smtp_crypto = array();
        $smtp_crypto['tls'] = 'tls';
        $smtp_crypto['ssl'] = 'ssl';
        
        return $smtp_crypto;
    }
}

if (!function_exists('get_mail_type')) {
    function get_mail_type() {
        
        $mail_type = array();
        $mail_type['text'] = 'text';
        $mail_type['html'] = 'html';
        
        return $mail_type;
    }
}

if (!function_exists('get_char_set')) {
    function get_char_set() {
        
        $char_set = array();
        $char_set['utf-8'] = 'utf-8';
        $char_set['iso-8859-1'] = 'iso-8859-1';
        
        return $char_set;
    }
}

if (!function_exists('get_email_priority')) {
    function get_email_priority() {
        
        $priority = array();
        $priority['1'] = 'highest';
        $priority['3'] = 'normal';
        $priority['5'] = 'lowest';       
        
        return $priority;
    }
}

if (!function_exists('get_random_tring')) {

    function get_random_tring($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('get_card_bottom_text_align')) {
    function get_card_bottom_text_align() {
        
        $text_align = array();
        $text_align['center'] = 'center';
        $text_align['left'] = 'left';
        $text_align['right'] = 'right';       
        
        return $text_align;
    }
}




if (!function_exists('check_permission')) {

    function check_permission($action) {

        $ci = & get_instance();
        $role_id = $ci->session->userdata('role_id');
        $operation_slug = $ci->router->fetch_class();
        $module_slug = $ci->router->fetch_module();

        if ($module_slug == '') {
            $module_slug = $operation_slug;
        }

        $module_slug = 'my_' . $module_slug;

        $data = $ci->config->item($operation_slug, $module_slug);

        $result = $data[$role_id];
        if (!empty($result)) {
            $array = explode('|', $result);
            if (!$array[$action]) {
                error($ci->lang->line('permission_denied'));
                redirect('dashboard');
            }
        } else {
            error($ci->lang->line('permission_denied'));
            redirect('dashboard');
        }

        return TRUE;
    }

}

if (!function_exists('has_permission')) {

    function has_permission($action, $module_slug = null, $operation_slug = null) {

        $ci = & get_instance();
        $role_id = $ci->session->userdata('role_id');

        if ($module_slug == '') {
            $module_slug = $operation_slug;
        }

        $module_slug = 'my_' . $module_slug;

        $data = $ci->config->item($operation_slug, $module_slug);

        $result = @$data[$role_id];

        if (!empty($result)) {
            $array = explode('|', $result);
            return $array[$action];
        } else {
            return FALSE;
        }
    }

}


if (!function_exists('create_log')) {

    function create_log($activity = null) {

        $ci = & get_instance();
        $data = array();
        
        if($ci->session->userdata('role_id') == SUPER_ADMIN){
            $data['school_id'] = 0;
        }else{
            $data['school_id'] = $ci->session->userdata('school_id');            
        }
        
        if(!$data['school_id']){ return;}
        
        $data['user_id'] = logged_in_user_id();
        $data['role_id'] = logged_in_role_id(); 
        $user = get_user_by_id($data['user_id']);
        
        $data['name'] = $user->name;
        $data['phone'] = $user->phone;
        $data['email'] = $user->email;
        $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $data['activity'] = $activity;
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();
        $ci->db->insert('activity_logs', $data);
    }
}




/* STRICT DATA ACCESS START*/


if (!function_exists('get_guardian_access_data')) {
    
 function get_guardian_access_data($type = NULL){
       
        
        $ci = & get_instance();
        
         if($ci->session->userdata('role_id') != GUARDIAN){
             return FALSE;
         }
        
        $school_id = $ci->session->userdata('school_id'); 
        $guardian_id = $ci->session->userdata('profile_id'); 
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();
        
        $ci->db->select('E.student_id, E.roll_no, E.class_id, E.section_id, C.name AS class_name, SE.name AS section');
        $ci->db->from('enrollments AS E');
        $ci->db->join('students AS S', 'S.id = E.student_id', 'left');
        $ci->db->join('classes AS C', 'C.id = E.class_id', 'left');
        $ci->db->join('sections AS SE', 'SE.id = E.section_id', 'left');
        $ci->db->where('E.academic_year_id', $school->academic_year_id);
        $ci->db->where('S.guardian_id', $guardian_id);
        $ci->db->where('S.school_id', $school_id);
        $result = $ci->db->get()->result();   
        $data = array();
        
       if(!empty($result )){
            if($type == 'class'){

                foreach($result as $obj){
                    $data[] = $obj->class_id;
                }
                
            }elseif($type == 'section'){

                foreach($result as $obj){
                    $data[] = $obj->section_id;
                }
            
            }elseif($type == 'student'){

                foreach($result as $obj){
                    $data[] = $obj->student_id;
                }
            }elseif($type == 'subject'){

                foreach($result as $obj){
                    $data[] = $obj->class_id;
                }  
                
                // Getting subject ids by classes
                $ci->db->select('S.*');
                $ci->db->from('subjects AS S');            
                $ci->db->where_in('S.class_id', implode(',', $data)); 
                $ci->db->order_by("S.id", "ASC");
                $subjects= $ci->db->get()->result();

                foreach($subjects as $obj){
                    $data[] = $obj->teacher_id;
                } 
                
            }
       }
       
       return $data;        
   }   
}


if (!function_exists('get_teacher_access_data')) {
    
 function get_teacher_access_data($type = NULL){
       
        $ci = & get_instance();
        
        if($ci->session->userdata('role_id') != TEACHER){
            return FALSE;
        }
        
        $school_id = $ci->session->userdata('school_id'); 
        $teacher_id = $ci->session->userdata('profile_id'); 
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();
               
        $data = array();                 

        // checking in routine is there a teacher
        $ci->db->select('R.class_id');
        $ci->db->from('routines AS R');            
        $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('R.school_id', $school_id); 
        $ci->db->order_by("R.id", "ASC");
        $result = $ci->db->get()->result();

        foreach($result as $obj){
            $data[] = $obj->class_id;
        }

        // checking in subject is there a teacher
        $ci->db->select('S.class_id');
        $ci->db->from('subjects AS S');                
        $ci->db->where('S.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('S.school_id', $school_id); 
        $ci->db->order_by("S.id", "ASC");
        $result = $ci->db->get()->result();

        foreach($result as $obj){
            $data[] = $obj->class_id;
        }


        // checking in section is there a teacher
        $ci->db->select('S.class_id');
        $ci->db->from('sections AS S');                
        $ci->db->where('S.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('S.school_id', $school_id); 
        $ci->db->order_by("S.id", "ASC");
        $result = $ci->db->get()->result();

        foreach($result as $obj){
            $data[] = $obj->class_id;
        }

        // checking in class is there a teacher
        $ci->db->select('C.id AS class_id');
        $ci->db->from('classes AS C');                
        $ci->db->where('C.teacher_id', $ci->session->userdata('profile_id')); 
        $ci->db->where('C.school_id', $school_id); 
        $ci->db->order_by("C.id", "ASC");
        $result = $ci->db->get()->result();
        
        // checking by responsibility
        $ci->db->select('C.class_id AS class_id');
        $ci->db->from('enrollments AS C');                
        if($ci->session->userdata('responsibility') == 'bpi'){
            $ci->db->where('C.class_bpi_id', $ci->session->userdata('profile_id')); 
        } else if($ci->session->userdata('responsibility') == 'tahfidz'){
            $ci->db->where('C.class_tahfizh_id', $ci->session->userdata('profile_id')); 
        }
        $ci->db->where('C.school_id', $school_id); 
        $ci->db->order_by("C.class_id", "ASC");
        $result = $ci->db->get()->result();

        foreach($result as $obj){
            $data[] = $obj->class_id;
        }    
       
       return array_unique($data);        
   }   
}


if (!function_exists('get_student_access_data')) {
    
 function get_student_access_data($type = NULL){
       
        $ci = & get_instance();
         if($ci->session->userdata('role_id') != STUDENT){
             return FALSE;
         }
        
        $school_id = $ci->session->userdata('school_id'); 
        $student_id = $ci->session->userdata('profile_id'); 
        $school =  $ci->db->get_where('schools', array('id'=>$school_id))->row();
               
        $data = array();
        
        if($type == 'student'){                

            $ci->db->select('R.*, S.name AS subject, T.name AS teacher, C.name AS class_name');
            $ci->db->from('routines AS R');
            $ci->db->join('subjects AS S', 'S.id = R.subject_id', 'left');
            $ci->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
            $ci->db->join('classes AS C', 'C.id = R.class_id', 'left');
            $ci->db->where('R.teacher_id', $ci->session->userdata('profile_id')); 
            $ci->db->order_by("R.id", "ASC");
            $result = $ci->db->get()->result();
            
            foreach($result as $obj){
                $data[] = $obj->class_id;
            }
        }elseif($type == 'subject'){
            
            $ci->db->select('S.*');
            $ci->db->from('subjects AS S');            
            $ci->db->where('S.class_id', $ci->session->userdata('class_id')); 
            $ci->db->order_by("S.id", "ASC");
            $result = $ci->db->get()->result();
            
            foreach($result as $obj){
                $data[] = $obj->teacher_id;
            }            
        }

       
       return $data;        
   }   
}

/** CUSTOM FUNCTION By FATHAN F*/
if (!function_exists('get_student_tahfizh')) {

    function get_student_tahfizh($student_id, $school_id, $academic_year_id, $class_id, $section_id  = null, $year = null, $month = null, $day = null) {
        $ci = & get_instance();
        $field = 'day_' . abs($day);
        $ci->db->select('SA.' . $field);
        $ci->db->from('student_tahfizh AS SA');
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.class_id', $class_id);
        
        if($section_id){
            $ci->db->where('SA.section_id', $section_id);
        }
        
        $ci->db->where('SA.year', $year);
        $ci->db->where('SA.month', $month);
        return @$ci->db->get()->row()->$field;
    }

}
if (!function_exists('get_average_total')){
    function get_average_total($values = array()){
        $average = 0;
        if(isset($values) && !empty($values)){
            $mark = 0;
            foreach($values as $val){
                $mark += $val;
            }
            $total_values = count($values);
            $average = $mark / $total_values;
        }
        
        return number_format((float)$average, 2, '.', '');
    }
}
if (!function_exists('get_grades')){
    function get_grades($value = null) {
        $predicate = '';
        if($value >= 90){
            $predicate = 'A';
        } else if($value >= 80 && $value < 90) {
            $predicate = 'B';
        } else if($value >= 65 && $value < 80) {
            $predicate = 'C';
        } else if($value >= 55 && $value < 65) {
            $predicate = 'D';
        } else {
            $predicate = 'E';
        }
        return $predicate;
    }
}

if (!function_exists('get_grade_tahfizh')){
    function get_grade_tahfizh($value = null, $type = null, $format = null) {
        $predicate = '';
        if($type == 'VII' || $type == 'X'){
            if($value >= 95){
                $predicate = 'Mumtaz';
            } else if($value >= 86 && $value < 95) {
                $predicate = 'Jayyid Jiddan';
            } else if($value >= 75 && $value < 86) {
                $predicate = 'Jayyid';
            } else {
                $predicate = '-';
            }
        } else  if($type == 'VIII' || $type == 'XI') {
            if($value >= 97){
                $predicate = 'Mumtaz';
            } else if($value >= 87 && $value < 97) {
                $predicate = 'Jayyid Jiddan';
            } else if($value >= 77 && $value < 87) {
                $predicate = 'Jayyid';
            } else {
                $predicate = '-';
            }
        } else  if($type == 'IX' || $type == 'XII') {
            if($value >= 98){
                $predicate = 'Mumtaz';
            } else if($value >= 89 && $value < 98) {
                $predicate = 'Jayyid Jiddan';
            } else if($value >= 79 && $value < 89) {
                $predicate = 'Jayyid';
            } else {
                $predicate = '-';
            }
        } else {
            if($value >= 90){
                $predicate = 'Mumtaz';
            } else if($value >= 80 && $value < 90) {
                $predicate = 'Jayyid Jiddan';
            } else if($value >= 65 && $value < 80) {
                $predicate = 'Jayyid';
            } else if($value >= 55 && $value < 65) {
                $predicate = 'Maqbul';
            } else {
                $predicate = 'Naqis';
            }
        }

        
        
        
        return $predicate;
    }
}

if (!function_exists('get_subject_groups')) {

    function get_subject_groups() {
        $ci = & get_instance();
        return array(
            '1' => 'Tahfizh',
            '2' => 'Mahad',
            '3' => 'Akademik',
            '4' => 'BPI'
        );
    }

}

if (!function_exists('get_guardian_earning')) {

    function get_guardian_earning() {
        $ci = & get_instance();
        return array(
            '1' => '< Rp. 2.500.000,-',
            '2' => 'Rp. 2.500.000 s/d 5.000.000,-',
            '3' => 'Rp. 5.000.000 s/d 10.000.000,-',
            '4' => '> Rp. 10.000.000,-'
        );
    }

}

if (!function_exists('get_class_groups')) {

    function get_class_groups() {
        $ci = & get_instance();
        return array(
            '1' => 'Academic',
            '2' => 'Mahad',
            '3' => 'Tahfizh',
            '4' => 'BPI'
        );
    }

}

if (!function_exists('get_muta_score')) {

    function get_muta_score($name = null, $mark = null) {
        $mutabaah = array('pray', 'dhuha', 'tilawah', 'qiyam', 'rawatib', 'dzikir');
        $presence = array('present', 'permit', 'sick', 'alpha');
        switch($name){
            case 'pray':
                $smark = $mark/84;
                $period = 'hari';
            break;

            case 'dhuha':
                $smark = $mark/12;
                $period = 'pekan';
            break;

            case 'tilawah':
                $smark = $mark/240;
                $period = 'pekan';
            break;

            case 'qiyam':
                $smark = $mark/12;
                $period = 'pekan';
            break;

            case 'rawatib':
                $smark = $mark/84;
                $period = 'hari';
            break;

            case 'dzikir':
                $smark = $mark/84;
                $period = 'hari';
            break;

            case 'present':
                case 'sick':
                    case 'permit':
                        case 'alpha':
                $smark = $mark;
            break;

            default:
                $smark = $mark/84;
            break;

        }
        if(in_array($name, $mutabaah)){
            $hotfix = 'x';
            if($name == 'tilawah'){
                $hotfix = 'juz';
            }
            $getscore = round($smark,1) . $hotfix . " per " . $period;
        } else if(in_array($name, $presence)){
            $getscore = $smark . " kali";
        }

        return $getscore;
    }
}
if (!function_exists('translate')) {
    function translate($name = null) {
        $dictionary = array(
            'pray' => 'Shalat Berjamaah',
            'dhuha' => 'Shalat Dhuha',
            'rawatib' => 'Shalat Sunnah Rawatib',
            'dzikir' => 'Dzikir Almatsurat',
            'qiyam' => 'Shalat Sunnah Tahadjud/Qiyamullail',
            'siyam' => 'Puasa Sunnah',
            'tilawah' => 'Membaca/Murajaah Al Quran',
            'sick' => 'Sakit',
            'permit' => 'Izin',
            'alpha' => 'Alpa',
            'present' => 'Kehadiran'
        );
        $wordis = '';
        if(!empty($dictionary[$name])){
            $wordis = $dictionary[$name];
        }

        return $wordis;
    }
}

if (!function_exists('is_JSON')){
    function is_JSON(...$args) {
        json_decode(...$args);
        return (json_last_error()===JSON_ERROR_NONE);
    }
}

if (!function_exists('get_quran_chapter_list')){
    function get_quran_chapter_list() {
        $ayat = array(
            1 => array('AL-FATIHAH', 'PEMBUKAAN'),
            2 => array('AL-BAQARAH', 'SAPI BETINA'),
            3 => array('ALI IMRAN', 'KELUARGA IMRAN'),
            4 => array('ANNISA', 'WANITA'),
            5 => array('AL-MA`IDAH', 'HIDANGAN'),
            6 => array('AL-AN`AM', 'BINATANG TERNAK'),
            7 => array('AL-A`RAF', 'TEMPAT TERTINGGI'),
            8 => array('AL-ANFAL', 'RAMPASAN PERANG'),
            9 => array('ATTAUBAH', 'PENGAMPUNAN'),
            10 => array('YUNUS', 'NABI YUNUS'),
            11 => array('HUD', 'NABI HUD'),
            12 => array('YUSUF', 'NABI YUSUF'),
            13 => array('ARRA`DU', 'GURUH'),
            14 => array('IBRAHIM', 'NABI IBRAHIM'),
            15 => array('AL-HIJRU', 'DAERAH HIJIR'),
            16 => array('AN-NAHL', 'LEBAH'),
            17 => array('AL-ISRA', 'PERJALANAN DI MALAM HARI'),
            18 => array('AL-KAHFI', 'GUA'),
            19 => array('MARYAM', 'SITI MARYAM'),
            20 => array('THOHA', 'TOHA'),
            21 => array('AL-ANBIYA', 'NABI-NABI'),
            22 => array('AL-HAJJ', 'HAJI'),
            23 => array('AL-MU`MINUN', 'ORANG-ORANG YANG BERIMAN'),
            24 => array('AN-NUR', 'CAHAYA'),
            25 => array('AL-FURQAN', 'PEMBEDA'),
            26 => array('ASY-SYU`ARA', 'PENYAIR-PENYAIR'),
            27 => array('AN-NAML', 'SEMUT'),
            28 => array('AL-QASHASH', 'KISAH-KISAH'),
            29 => array('AL-`ANKABUT', 'LABA-LABA'),
            30 => array('AR-RUM', 'BANGSA RUM'),
            31 => array('LUQMAN', 'LUQMAN'),
            32 => array('AS-SAJDAH', 'SUJUD'),
            33 => array('AL-AHZAB', 'GOLONGAN YANG BERSEKUTU'),
            34 => array('SABA`', 'NEGERI SABA'),
            35 => array('FATHIR', 'PENCIPTA'),
            36 => array('YASIN', 'YASIN'),
            37 => array('ASH-SHAFFAT', 'YANG BERBARIS'),
            38 => array('SHAD', 'SHAD'),
            39 => array('AZ-ZUMAR', 'ROMBONGAN-ROMBONGAN'),
            40 => array('AL-MU`MIN', 'ORANG BERIMAN'),
            41 => array('FUSHSHILAT', 'YANG DIJELASKAN'),
            42 => array('ASY-SYURA', 'MUSYAWARAH'),
            43 => array('AZ-ZUKHRUF', 'PERHIASAN'),
            44 => array('AD-DUKHAN', 'KABUT'),
            45 => array('AL-JATSIYAH', 'YANG BERLUTUT'),
            46 => array('AL-AHQAF', 'BUKIT-BUKIT PASIR'),
            47 => array('MUHAMMAD', 'NABI MUHAMMAD'),
            48 => array('AL-FATH', 'KEMENANGAN'),
            49 => array('AL-HUJURAT', 'KAMAR-KAMAR'),
            50 => array('QAF', 'QAF'),
            51 => array('ADZ-DZARIYAT', 'ANGIN YANG MENERBANGKAN'),
            52 => array('ATH-THUR', 'BUKIT THUR'),
            53 => array('AN-NAJM', 'BINTANG'),
            54 => array('AL-QAMAR', 'BULAN'),
            55 => array('AR-RAHMAN', 'MAHA PEMURAH'),
            56 => array('AL-WAQI`AH', 'HARI KIAMAT'),
            57 => array('AL-HADID', 'BESI'),
            58 => array('AL-MUJADILAH', 'WANITA YANG MENGAJUKAN GUGATAN'),
            59 => array('AL-HASYR', 'PENGUSIRAN'),
            60 => array('AL-MUMTAHANAH', 'PEREMPUAN YANG DIUJI'),
            61 => array('ASH-SHAF', 'BARISAN'),
            62 => array('AL-JUMUAH', 'HARI JUMAT'),
            63 => array('AL-MUNAFIQUN', 'ORANG-ORANG MUNAFIK'),
            64 => array('AT-TAGHABUN', 'HARI DITAMPAKKAN'),
            65 => array('ATH-THALAQ', 'TALAQ'),
            66 => array('AT-TAHRIM', 'MENGAHARAMKAN'),
            67 => array('AL-MULK', 'KERAJAAN'),
            68 => array('AL-QALAM', 'QOLAM'),
            69 => array('AL-HAQQAH', 'HARI KIAMAT'),
            70 => array('AL-MA`ARIJ', 'TEMPAT-TEMPAT NAIK'),
            71 => array('NUH', 'NABI NUH'),
            72 => array('AL-JINN', 'JIN'),
            73 => array('AL-MUZAMMIL', 'ORANG-ORANG BERSELIMUT'),
            74 => array('AL-MUDDATS-TSIR', 'ORANG YANG BERKEMUL'),
            75 => array('AL-QIYAMAH', 'HARI KIAMAT'),
            76 => array('AL-INSAN', 'MANUSIA'),
            77 => array('AL-MURSALAT', 'MALAIKAT YANG DIUTUS'),
            78 => array('AN-NABA`', 'BERITA'),
            79 => array('AN-NAZI`AT', 'MALAIKAT YANG MENCABUT'),
            80 => array('ABASA', 'BERMUKA MASAM'),
            81 => array('AT-TAKWIR', 'MENGGULUNG'),
            82 => array('AL-INFITHAR', 'TERBELAH'),
            83 => array('AL-MUTHAFIFIN', 'KECURANGAN'),
            84 => array('AL-INSYIQAQ', 'TERBELAH'),
            85 => array('AL-BURUJ', 'GUGUSAN BINTANG'),
            86 => array('ATH-THARIQ', 'YANG DATANG DI MALAM HARI'),
            87 => array('AL-A`LA', 'YANG PALING TINGGI'),
            88 => array('AL-GHASYIYAH', 'HARI PEMBALASAN'),
            89 => array('AL-FAJR', 'FAJAR'),
            90 => array('AL-BALAD', 'NEGERI'),
            91 => array('ASY-SYAMS', 'MATAHARI'),
            92 => array('AL-LAIL', 'MALAM'),
            93 => array('ADH-DHUHA', 'WAKTU DUHA'),
            94 => array('AL-INSYIRAH', 'KELAPANGAN'),
            95 => array('AT-TIN', 'BUAH TIN'),
            96 => array('AL-`ALAQ', 'SEGUMPAL DARAH'),
            97 => array('AL-QADAR', 'KEMULIAAN'),
            98 => array('AL-BAYYINAH', 'BUKTI'),
            99 => array('AZ-ZALZALAH', 'KEGONCANGAN'),
            100 => array('AL-`ADIYAT', 'KUDA PERANG YANG BERLARI KENCANG'),
            101 => array('AL-QARI`AH', 'HARI KIAMAT'),
            102 => array('AT-TAKATSUR', 'BERMEGAH-MEGAHAN'),
            103 => array('AL-`ASHR', 'WAKTU'),
            104 => array('AL-HUMAZAH', 'PENGUMPAT'),
            105 => array('AL-FIL', 'GAJAH'),
            106 => array('QURAISY', 'SUKU QURAISY'),
            107 => array('AL-MA`UN', 'BARANG-BARANG YANG BERGUNA'),
            108 => array('AL-KAUTSAR', 'NIKMAT YANG BESAR'),
            109 => array('AL-KAFIRUN', 'ORANG-ORANG KAFIR'),
            110 => array('AN-NASHR', 'PERTOLONGAN'),
            111 => array('AL-LAHAB', 'GEJOLAK API'),
            112 => array('AL-IKHLASH', 'PEMURNIAN KEESAAN ALLAH'),
            113 => array('AL-FALAQ', 'WAKTU SHUBUH'),
            114 => array('AN-NAS', 'MANUSIA'),
        );

        return $ayat;
    }
}

if (!function_exists('get_quran_juz_list')){
    function get_quran_juz_list() {
        $juz = array(
            1 => array('JUZ 1 AL FATIHAH 1 - AL BAQARAH 141', 'JUZ 1'),
            2 => array('JUZ 2 AL BAQARAH 142 - AL BAQARAH 252', 'JUZ 2'),
            3 => array('JUZ 3 AL BAQARAH 253 - ALI IMRAN 92', 'JUZ 3'),
            4 => array('JUZ 4 ALI IMRAN 93 - AN NISA 23', 'JUZ 4'),
            5 => array('JUZ 5 AN NISA 24 - AN NISA 147', 'JUZ 5'),
            6 => array('JUZ 6 AN NISA 148 - AL MAIDAH 82', 'JUZ 6'),
            7 => array('JUZ 7 AL MAIDAH 83 - AL ANAM 110', 'JUZ 7'),
            8 => array('JUZ 8 AL ANAM 111 - AL ARAF 87', 'JUZ 8'),
            9 => array('JUZ 9 AL ARAF 88 - AL ANFAL 40', 'JUZ 9'),
            10 => array('JUZ 10 AL ANFAL 41 - AT TAUBAH 92', 'JUZ 10'),
            11 => array('JUZ 11 TAUBAH 93 - HUD 5', 'JUZ 11'),
            12 => array('JUZ 12 HUD 6 - YUSUF 52', 'JUZ 12'),
            13 => array('JUZ 13 YUSUF 53 - IBRAHIM 52', 'JUZ 13'),
            14 => array('JUZ 14 AL HIJR 1 - AN NAHL 128', 'JUZ 14'),
            15 => array('JUZ 15 AL ISRA 1 - AL KAHFI 74', 'JUZ 15'),
            16 => array('JUZ 16 AL KAHFI 75 - TAHA 135', 'JUZ 16'),
            17 => array('JUZ 17 AL ANBIYA 1 - AL HAJJ 78', 'JUZ 17'),
            18 => array('JUZ 18 AL MUMINUN 1 - AL FURQON 20', 'JUZ 18'),
            19 => array('JUZ 19 AL FURQON 21 - AN NAML 55', 'JUZ 19'),
            20 => array('JUZ 20 AN NAML 56 - AL ANKABUT 45', 'JUZ 20'),
            21 => array('JUZ 21 AL ANKABUT 46 - AL AHZAB 30', 'JUZ 21'),
            22 => array('JUZ 22 AL AHZAB 31 - YASIN 27', 'JUZ 22'),
            23 => array('JUZ 23 YASIN 28 - AZ ZUMAR 31', 'JUZ 23'),
            24 => array('JUZ 24 AZ ZUMAR 32 - FUSSILAT 46', 'JUZ 24'),
            25 => array('JUZ 25 FUSSILAT 47 - AL JATSIYAH 37', 'JUZ 25'),
            26 => array('JUZ 26 AL AHQAF 1 - AD DZARIYAT 30', 'JUZ 26'),
            27 => array('JUZ 27 AD DZARIYAT 31 - AL HADID 29', 'JUZ 27'),
            28 => array('JUZ 28 AL-MUJADILAH 1 - AT TAHRIM 12', 'JUZ 28'),
            29 => array('JUZ 29 AL-MULK 1 - AL MURSALAT 50', 'JUZ 29'),
            30 => array('JUZ 30 AN-NABA 1 - AN NAAS 6', 'JUZ 30')
        );

        return $juz;
    }
}
if (!function_exists('get_character_indicator')) {

    function get_character_indicator($level = null) {
        if(empty($level) || $level == 1) {
            $data_character = array(
                '1' => array(
                    'name' => 'Akidah Yang Bersih',
                    'indicator' => array(
                        '101' => 'Tidak berhubungan dengan jin',
                        '102' => 'Tidak meminta tolong kepada orang yang berlindung kepada jin',
                        '103' => 'Tidak meramal nasib dengan melihat telapak tangan',
                        '104' => 'Tidak menghadiri majelis dukun dan peramal',
                        '105' => 'Tidak meminta berkah dengan mengusap-usap kuburan',
                        '106' => 'Tidak meminta tolong kepada orang yang telah dikubur (mati)',
                        '107' => 'Tidak bersumpah dengan selain Allah Swt',
                        '108' => 'Tidak tasya’um (merasa sial karena melihat atau mendengar sesuatu)',
                        '109' => 'Mengikhlaskan amal untuk Allah Swt',
                        '110' => 'Mengimani rukun iman',
                        '111' => 'Beriman kepada nikmat dan siksa kubur',
                        '112' => 'Mensyukuri nikmat Allah Swt saat mendapatkan nikmat',
                        '113' => 'Menjadikan setan sebagai musuh',
                        '114' => 'Tidak mengikuti langkah-langkah setan',
                        '115' => 'Menerima dan tunduk secara penuh kepada Allah Swt dan tidak bertahkim kepada selain yang diturunkan-Nya'  
                    )
                ),
                '2' => array(
                    'name' => 'Ibadah Yang Benar',
                    'indicator' => array(
                        '201' => 'Tidak sungkan Adzan',
                        '202' => 'Ihsan dalam Thaharah',
                        '203' => 'Bersemangat untuk shalat',
                        '204' => 'Ihsan dalam shalat',
                        '205' => 'Qiyamul-Lail minimal sekali sepekan',
                        '206' => 'Membayar zakat',
                        '207' => 'Berpuasa fardlu',
                        '208' => 'Berpuasa sunat minimal sehari dalam sebulan',
                        '209' => 'Niat melaksanakan haji',
                        '210' => 'Berdoa pada waktu-waktu utama',
                        '211' => 'Menutup hari-harinya dengan bertaubat dan beristighfar',
                        '212' => 'Berniat pada setiap melakukan perbuatan',
                        '213' => 'Menjauhi dosa besar',
                        '214' => 'Merutinkan dzikir pagi hari',
                        '215' => 'Merutinkan dzikir sore hari',
                        '216' => 'Dzikir kepada Allah dalam setiap keadaan',
                        '217' => 'Memenuhi nadzar',
                        '218' => 'Menyebarluaskan salam',
                        '219' => 'Menahan anggota tubuh dari segala yang haram',
                        '220' => 'Beri’tikaf pada bulan Ramadhan, jika mungkin',
                        '221' => 'Mempergunakan siwak',
                        '222' => 'Senantiasa menjaga kondisi Thaharah, jika mungkin'

                    )
                ),
                '3' => array(
                    'name' => 'Kepribadian yang matang dan berakhlak mulia',
                    'indicator' => array(
                        '301' => 'Tidak takabur',
                        '302' => 'Tidak imma’ah (asal ikut, tidak punya prinsip)',
                        '303' => 'Tidak dusta',
                        '304' => 'Tidak mencaci maki',
                        '305' => 'Tidak mengadu domba',
                        '306' => 'Tidak ghibah',
                        '307' => 'Tidak menjadikan orang buruk sebagai teman/sahabat',
                        '308' => 'Memenuhi janji',
                        '309' => 'Birrul walidain',
                        '310' => 'Memiliki ghirah (rasa cemburu) pada keluarganya',
                        '311' => 'Memiliki ghirah (rasa cemburu) pada agamanya',
                        '312' => 'Tidak memotong pembicaraan orang lain',
                        '313' => 'Tidak mencibir dengan isyarat apapun',
                        '314' => 'Tidak menghina dan meremehkan orang lain',
                        '315' => 'Menyayangi yang kecil',
                        '316' => 'Menghormati yang besar',
                        '317' => 'Menundukkan pandangan',
                        '318' => 'Menyimpan rahasia',
                        '319' => 'Menutupi dosa orang lain',
                        '320' => 'Melaksanakan hak kedua orang tua',
                        '321' => 'Membantu yang membutuhkan',
                        '322' => 'Memberi petunjuk orang tersesat',
                        '323' => 'Ikut berpartisipasi dalam kegembiraan'
                    )
                ),
                '4' => array(
                    'name' => 'Pribadi yang sungguh-sungguh,  disiplin dan mampu menahan nafsunya',
                    'indicator' => array(
                        '401' => 'Menjauhi segala yang haram',
                        '402' => 'Menjauhi tempat-tempat maksiat',
                        '403' => 'Menjauhi tempat-tempat bermain yang haram',
                        '404' => 'Tidak menjalin hubungan dengan lembaga-lembaga yang menentang Islam',
                        '405' => 'Memperbaiki penampilannya (performennya)',
                        '406' => 'Bangun pagi',
                        '407' => 'Menghabiskan waktu untuk belajar'
                    )
                ),
                '5' => array(
                    'name' => 'Mampu membaca, menghafal, dan memahami Al Qur’an',
                    'indicator' => array(
                        '501' => 'Komitmen dengan adab tilawah',
                        '502' => 'Khusyuk dalam membaca Al-Quran',
                        '503' => 'Hafal satu juz Al-Qur’an',
                        '504' => 'Komitmen dengan wirid tilawah harian',
                        '505' => 'Memperhatikan hukum-hukum tilawah',
                        '506' => 'Membaca satu juz tafsir Al-Qur’an (juz 30)'

                    )
                ),
                '6' => array(
                    'name' => 'Mutsaqoful Fikri (Berwawasan Luas)',
                    'indicator' => array(
                        '601' => 'Baik dalam membaca dan menulis',
                        '602' => 'Mengkaji marhalah Makkiyah dan menguasai karakteristiknya',
                        '603' => 'Mengenal 10 shahabat yang dijamin masuk surga',
                        '604' => 'Mengetahui hukum thaharah',
                        '605' => 'Mengetahui hukum shalat',
                        '606' => 'Mengetahui hukum puasa',
                        '607' => 'Menyadari adanya peperangan Zionisme terhadap Islam',
                        '608' => 'Mengetahui Ghozwul Fikri',
                        '609' => 'Mengetahui organisasi-organisasi terselubung',
                        '610' => 'Mengetahui bahaya pembatasan kelahiran',
                        '611' => 'Berpartisipasi dalam kerja-kerja jama’i',
                        '612' => 'Tidak menerima suara-suara miring tentang pendakwah Islam',
                        '613' => 'Menghafalkan separuh Arba’in (1-20)',
                        '614' => 'Menghafalkan 20 hadits pilihan dari Riyadush-sholihin',
                        '615' => 'Membaca sesuatu yang di luar spesialisasinya 4 jam setiap pekan',
                        '616' => 'Memperluas wawasan diri dengan sarana-sarana baru',
                        '617' => 'Menjadi pendengar yang baik',
                        '618' => 'Mengemukakan pendapatnya',
                        '619' => 'Mencapai 80% kompetensi kognitif PAI dan mawad'

                    )
                ),
                '7' => array(
                    'name' => 'Memiliki ketrampilan hidup (Kesehatan dan kebugaran, lifeskill dan berwirausaha, pengembangan diri)',
                    'indicator' => array(
                        '701' => 'Menjauhi sumber penghasilan haram',
                        '702' => 'Menjauhi riba',
                        '703' => 'Menjauhi judi dengan segala macamnya',
                        '704' => 'Menjauhi tindak penipuan',
                        '705' => 'Membayar zakat',
                        '706' => 'Menabung, meskipun sedikit',
                        '707' => 'Tidak menunda dalam melaksanakan hak orang lain',
                        '708' => 'Menjaga fasilitas umum',
                        '709' => 'Menjaga fasilitas khusus',
                        '710' => 'Bersih badan',
                        '711' => 'Bersih pakaian',
                        '712' => 'Bersih tempat tinggal',
                        '713' => 'Komitmen dengan olah raga 2 jam setiap pekan',
                        '714' => 'Bangun sebelum fajar',
                        '715' => 'Memperhatikan tata cara baca yang sehat',
                        '716' => 'Mencabut diri dari merokok',
                        '717' => 'Komitmen dengan adab makan dan minum sesuai dengan sunah',
                        '718' => 'Tidak berlebihan dalam begadang',
                        '719' => 'Menghindari tempat-tempat kotor dan polusi',
                        '720' => 'Menghindari tempat-tempat bencana (bila masih di luar area)'

                    )
                )
            );
        } else if($level == 2){
            $data_character = array(
                '1' => array(
                    'name' => 'Akidah Yang Bersih',
                    'indicator' => array(
                        '101' => 'Tidak mengafirkan seorang muslim',
                        '102' => 'Tidak mendahulukan makhluk atas Khaliq',
                        '103' => 'Mengingkari orang-orang yang memperolok-olokkan ayat-ayat Allah swt dan tidak bergabung dalam majelis mereka',
                        '104' => 'Mengesakan Allah swt dalam Rububiyyah dan Uluhiyyah',
                        '105' => 'Tidak menyekutukan Allah swt, tidak dalam Asma-Nya, sifat-Nya dan Afal-Nya',
                        '106' => 'Tidak meminta berkah dengan mengusap-usap kuburan',
                        '107' => 'Mempelajari madzhab-madzhab Islam yang berkaitan dengan Asma dan Sifat dan mengikuti madzhab salaf',
                        '108' => 'Mengetahui batasan berwala dan berbara',
                        '109' => 'Bersemangat untuk berteman dengan orang-orang shalih dari sisi-sisi kedekatan dan peneladanan',
                        '110' => 'Meyakini terhapusnya dosa dengan taubat Nashuha',
                        '111' => 'Memprediksikan datangnya kematian kapan saja',
                        '112' => 'Meyakini bahwa masa depan ada di tangan Islam',
                        '113' => 'Berusaha meraih rasa manisnya iman',
                        '114' => 'Berusaha meraih rasa manisnya ibadah',
                        '115' => 'Merasakan adanya para malaikat mulia yang mencatat amalnya',
                        '116' => 'Merasakan adanya istighfar para malaikat dan doa mereka'
                        
                    )
                ),
                '2' => array(
                    'name' => 'Ibadah Yang Benar',
                    'indicator' => array(
                        '201' => 'Melakukan qiyamul-Lail minimal satu kali dalam satu pekan',
                        '202' => 'Bersedekah',
                        '203' => 'Berpuasa sunnat minimal dua hari dalam satu bulan',
                        '204' => 'Haji jika mampu',
                        '205' => 'Banyak bertaubat',
                        '206' => 'Memerintahkan yang maruf',
                        '207' => 'Mencegah yang Munkar',
                        '208' => 'Ziarah kubur untuk mengambil Ibrah',
                        '209' => 'Merutinkan ibadah-ibadah sunnah Rawatib',
                        '210' => 'Khusyu dalam shalat',
                        '211' => 'Selalu memperbaharui niat dan meluruskannya',
                        '212' => 'Menjaga organ tubuh (dari dosa)',
                        '213' => 'Banyak dzikir kepada Allah swt disertai hafalan terhadap yang mudah-mudah',
                        '214' => 'Banyak berdoa dengan memperhatikan syarat-syarat dan tata kramanya',
                        '215' => 'Senantiasa bertafakkur',
                        '216' => 'Beritikaf satu malam pada setiap bulannya'

                    )
                ),
                '3' => array(
                    'name' => 'Kepribadian yang matang dan berakhlak mulia',
                    'indicator' => array(
                        '301' => 'Tidak Inad (membangkang)',
                        '302' => 'Tidak banyak mengobrol',
                        '303' => 'Sedikit bercanda',
                        '304' => 'Tidak berbisik dengan sesuatu yang bathil',
                        '305' => 'Tidak Hiqd (menyimpan kemarahan)',
                        '306' => 'Tidak Hasad',
                        '307' => 'Memiliki rasa malu berbuat kesalahan',
                        '308' => 'Menjalin hubungan baik dengan tetangga',
                        '309' => 'Tawadhu tanpa merendahkan diri',
                        '310' => 'Pemberani',
                        '311' => 'Menjenguk orang sakit',
                        '312' => 'Komitmen dengan adab meminta izin',
                        '313' => 'Mensyukuri orang yang berbuat baik kepadanya',
                        '314' => 'Menyambung silaturahim (shilatur-rahim)',
                        '315' => 'Komitmen dengan tata krama sebagai pendengar',
                        '316' => 'Komitmen dengan adab berbicara',
                        '317' => 'Memuliakan tamu',
                        '318' => 'Menjawab salam',
                        '319' => 'Menebar senyum di depan orang lain',
                        '320' => 'Berhati lembut',
                        '321' => 'Merendahkan suara',
                        '322' => 'Komitmen dengan adab Islam di rumah',
                        '323' => 'Memberi hadiah kepada tetangga',
                        '324' => 'Membantu yang membutuhkan',
                        '325' => 'Menolong yang terzhalimi',
                        '326' => 'Bersemangat mendakwahi istrinya, anak-anaknya, dan kerabatnya',
                        '327' => 'Mendoakan yang bersin',
                        '328' => 'Memberikan pelayanan umum karena Allah swt',
                        '329' => 'Memberikan sesuatu dari yang dimiliki',
                        '330' => 'Mendekati orang lain',
                        '331' => 'Mendorong orang lain berbuat baik',
                        '332' => 'Membantu yang kesulitan',
                        '333' => 'Membantu yang terkena musibah',
                        '334' => 'Berusaha memenuhi hajat orang lain',
                        '335' => 'Memberi makan orang lain'
                    )
                ),
                '4' => array(
                    'name' => 'Pribadi yang sungguh-sungguh,  disiplin dan mampu menahan nafsunya',
                    'indicator' => array(
                        '401' => 'Selalu menyertakan niat  jihad',
                        '402' => 'Menjadikan dirinya bersama orang baik',
                        '403' => 'Menyumbangkan sebagian hartanya untuk amal islami',
                        '404' => 'Sabar atas bencana',
                        '405' => 'Menyesuaikan perbuatan dengan ucapan',
                        '406' => 'Menerima dan memikul beban dakwah',
                        '407' => 'Memerangi dorongan-dorongan nafsu',
                        '408' => 'Tidak berlebihan mengkonsumsi yang mubah',
                        '409' => 'Memakan apa yang disuguhkan dengan penuh keridhaan',
                        '410' => 'Shalat menjadi barometer manajemen waktunya',
                        '411' => 'Teratur di dalam rumah dan kerjanya',
                        '412' => 'Menertibkan ide-ide dan pikiran-pikirannya',
                        '413' => 'Bersemangat memenuhi janji-janji kerja',
                        '414' => 'Memberitahukan gurunya problematika-problematika yang muncul',
                        '415' => 'Menjaga janji-janji umum dan khusus',
                        '416' => 'Mengisi waktunya dengan hal-hal yang berfaedah dan bermanfaat',
                        '417' => 'Memperhatikan adab Islam dalam berkunjung dan mempersingkat pemenuhan hajatnya'

                    )
                ),
                '5' => array(
                    'name' => 'Mampu membaca, menghafal, dan memahami Al Qur’an',
                    'indicator' => array(
                        '501' => 'Khusyu saat membaca Alquran',
                        '502' => 'Sekali Khatam Alquran setiap dua bulan',
                        '503' => 'Mengaitkan antara Alquran dengan realita',
                        '504' => 'Membaca tafsir dua juz Al quran (28-29)',
                        '505' => 'Hafal dan bertajwid tiga juz Al quran (28-30)'
                    )
                ),
                '6' => array(
                    'name' => 'Mutsaqoful Fikri (Berwawasan Luas)',
                    'indicator' => array(
                        '601' => 'Mengkaji marhalah Madaniyyah dan menguasai karakteristiknya',
                        '602' => 'Mengenal sirah 20 sahabat yang syahid',
                        '603' => 'Mengetahui hukum Zakat',
                        '604' => 'Mengetahui fiqih Haji',
                        '605' => 'Mengetahui sisi-sisi Syumuliyatul Islam',
                        '606' => 'Mengetahui problematika kaum muslimin internal dan eksternal',
                        '607' => 'Mengetahui apa kerugian dunia akibat kemunduran kaum muslimin',
                        '608' => 'Mengetahui urgensi Khilafah dan kesatuan kaum muslimin',
                        '609' => 'Mengetahui dan mengulas “tiga risalah”, yaitu: Dawatuna, Ila Ayyi Syaiin Nadun-Naas dan Ilasy-Syabab.',
                        '610' => 'Mengetahui dan mengulas risalah Aqaid',
                        '611' => 'Memahami amal jamai dan taat',
                        '612' => 'Membantah suara-suara miring yang dilontarkan kepada kita',
                        '613' => 'Mengetahui bagaimana proses berdirinya negara Israel',
                        '614' => 'Mengetahui arah-arah pemikiran Islam kontemporer',
                        '615' => 'Memiliki kemampuan mengulas apa yang ia baca',
                        '616' => 'Menghafal seluruh hadits Arbain (20 + 20)',
                        '617' => 'Menghafal 50 hadits Riyadhush-Shalihin (20 + 30)',
                        '618' => 'Membaca tujuh jam setiap pekan di luar spesialisasinya',
                        '619' => 'Menghadiri konferensi dan seminar kita',
                        '620' => 'Mengenali hal-hal baru dari problematika kekinian',
                        '621' => 'Menyebarluaskan apa saja yang diterbitkan oleh koran dan terbitan kita',
                        '622' => 'Berpartisipasi dalam melontarkan dan memecahkan masalah',
                        '623' => 'Mencapai 80% kompetensi kognitif PAI dan mawad'

                    )
                ),
                '7' => array(
                    'name' => 'Memiliki ketrampilan hidup (Kesehatan dan kebugaran, lifeskill dan berwirausaha, pengembangan diri)',
                    'indicator' => array(
                        '701' => 'Bekerja dan berpenghasilan',
                        '702' => 'Berusaha memiliki spesialisasi',
                        '703' => 'Sedang dalam nafkah',
                        '704' => 'Mengutamakan produk-produk Islam',
                        '705' => 'Menjaga kepemilikan khusus',
                        '706' => 'Tidak berambisi menjadi pegawai negeri',
                        '707' => 'Mengutamakan spesialisasil angka yang penting dan dinamis',
                        '708' => 'Hartanya tidak pergi ke pihak non Muslim',
                        '709' => 'Berusaha untuk memperbaiki kualitas produk dengan harga sesuai',
                        '710' => 'Membersihkan peralatan makan dan minumnya',
                        '711' => 'Mampu mempersiapkan makanan',
                        '712' => 'Mengikuti petunjuk-petunjuk kesehatan dalam tidur dan bangun tidur semampunya',
                        '713' => 'Mengobati diri sendiri',
                        '714' => 'Tidak mempergunakan obat tanpa meminta petunjuk',
                        '715' => 'Menjauhi makanan-makanan yang diawetkan dan mempergunakan minuman-minuman alami',
                        '716' => 'Mengatur waktu-waktu makan',
                        '717' => 'Tidak berlebihan mengkonsumsi lemak',
                        '718' => 'Tidak berlebihan mengkonsumsi garam',
                        '719' => 'Tidak berlebihan mengkonsumsi gula',
                        '720' => 'Memilih produsen-produsen makanan',
                        '721' => 'Tidur 6 - 8 jam dan bangun sebelum fajar',
                        '722' => 'Berlatih 10 - 15 menit setiap hari',
                        '723' => 'Berjalan 2 - 3 jam setiap pekan'

                    )
                )
            );
        }
        

        return $data_character;
    }
}
if (!function_exists('get_sign_date')) {
    function get_sign_date($date) {
        $month = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );

        return $month[$date];
    }
}
function remote_file_exists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if( $httpCode == 200 ){return true;}
}

/*STRICT DATA ACCESS END*/