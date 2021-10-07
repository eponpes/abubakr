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
        $ci->db->select('MF.*, C.name AS class_name, C.numeric_name AS class_no');
        $ci->db->from('mark_forms AS MF');  
        $ci->db->join('classes AS C', 'C.id = MF.class_id', 'left');
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
    //$clientcode = 'ymk';
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
        if($clientcode == 'ymk' || $clientcode == 'ymn'){
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
                default:
                    $label = 'Jayyid';
                break;
            }
        } else {
            $label = get_tahsin_target($score);
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
    }  else if($type == 'Z' || $type == 'M' || $type == 'L'){
        switch($score){
            case 'A+':
                $label = 'Mumtaz';
            break;
            case 'A':
                $label = 'Jayyid Jiddan';
            break;
            case 'B':
                $label = 'Jayyid';
            break;
            case 'C':
                $label = 'Maqbul';
            break;
            case 'D':
                $label = 'Naqis';
            break;
            case 'E':
                $label = 'Dhoif';
            break;
            default:
            $label = 'Jayyid';
            break;
        }
    }
    
    return $label;
}

function get_tahsin_target($score = null){
    $tahsin_target = array(
        '1' => 'Basic 1',
        '2' => 'Basic 2',
        '3' => 'Basic 3',
        '4' => 'Intermediet 1',
        '5' => 'Intermediet 2',
        '6' => 'Intermediet 3',
        '7' => 'Advance 1',
        '8' => 'Advance 2',
        '9' => 'Advance 3',
    );
    $tahsin = $tahsin_target;
    if(!empty($score)){
        if(!empty($tahsin_target[$score])){
            $tahsin = $tahsin_target[$score];
        }
    }
    return $tahsin;
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

function get_markform_score_grade($score = null){
    $grade = '';
    $grades = array(
        'A' => 'Konsisten dan telah terbiasa',
        'B' => 'Berkembang dengan baik',
        'C' => 'Sudah nampak dan perlu support/ bantuan',
        'D' => 'Belum nampak',
        'E' => '-'
    );
    if(!empty($grades[$score])){
        $grade = $grades[$score];
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

if (!function_exists('get_educations')) {

    function get_educations() {
        $ci = & get_instance();
        return array(
            '1' => 'S3',
            '2' => 'S2',
            '3' => 'S1',
            '4' => 'Diploma',
            '5' => 'SMA/SMK',
            '6' => 'SMP',
            '7' => 'SD',
            '8' => 'Lainnya'
        );
    }

}

if (!function_exists('get_jobs')) {

    function get_jobs() {
        $ci = & get_instance();
        return array(
            '1' => 'Pelajar',
            '2' => 'Karyawan',
            '3' => 'Pengusaha',
            '4' => 'Freelance',
            '5' => 'Mahasiswa',
            '6' => 'Guru',
            '7' => 'Dosen',
            '8' => 'Ibu Rumah Tangga',
            '9' => 'Belum Bekerja'
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
            if ($data->snap_status) {
                $methods['snap'] = 'Midtrans';
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

    function get_muta_score($name = null, $mark = null, $options = null) {
        $mutabaah = array('pray', 'dhuha', 'tilawah', 'qiyam', 'rawatib', 'dzikir', 'siyam', 'book', 'sedekah', 'silat', 'sport');
        $presence = array('present', 'permit', 'sick', 'alpha');

        $prayist = 84;
        $rawatibist = 84;
        $qiyamist = 12;
        $dzikirist = 84;
        $tilawahist = 240;
        $siyamist = 3;
        $infaqist = 8;
        $bookist = 8;

        if(!empty($options)){
            if(!empty($options['datecreated']) && !empty($options['datenewversion'])){
                $created = $options['datecreated'];
                $newversion = $options['datenewversion'];
                if($created > $newversion){
                    $prayist = 56;
                    $rawatibist = 56;
                    $qiyamist = 8;
                    $dzikirist = 56;
                    $tilawahist = 8;
                    $siyamist = 8;
                    $infaqist = 8;
                    $bookist = 8;
                    $silatist = 8;
                    $sportist = 8;
                }
            }
        }
        
        switch($name){
            case 'pray':
                $smark = $mark/$prayist;
                $period = 'hari';
            break;

            case 'dhuha':
                $smark = $mark/8;
                $period = 'pekan';
            break;

            case 'tilawah':
                $smark = $mark/$tilawahist;
                $period = 'pekan';
            break;

            case 'qiyam':
                $smark = $mark/$qiyamist;
                $period = 'pekan';
            break;

            case 'rawatib':
                $smark = $mark/$rawatibist;
                $period = 'hari';
            break;

            case 'dzikir':
                $smark = $mark/$dzikirist;
                $period = 'hari';
            break;

            case 'siyam':
                $smark = $mark/$siyamist;
                $period = 'pekan';
            break;

            case 'sedekah':
                $smark = $mark/$infaqist;
                $period = 'pekan';
            break;

            case 'book':
                $smark = $mark/$bookist;
                $period = 'pekan';
            break;

            case 'silat':
                $smark = $mark/$silatist;
                $period = 'pekan';
            break;

            case 'sport':
                $smark = $mark/$sportist;
                $period = 'pekan';
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
            } else if($name == 'book'){
                $hotfix = 'hal';
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
            'book' => 'Membaca Buku/Tematik',
            'sedekah' => 'Sedekah/Infaq',
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

function get_class_grade($clientcode = null, $class_id = null){
    if($clientcode == 'ibd'){
        $class_basic = array(2, 5, 4,6,7,8);
        $class_next = array(6,7,8);
        if(in_array($class_id, $class_basic)){
            return 'basic';
        }
    }

    return 'next';
}

function get_teacher_sign($teacher_id){
    $teachers = array();
    $teachers['id'] = $teacher_id;
    $special_men = array(77, 78, 79, 80, 81, 36, 37);
    $special_woman = array(71,72,73,74,75,76);
    if(in_array($teacher_id, $special_men)){
        $teachers['id'] = 52;
        $teachers['name'] = 'Ust. Udin Zaenudin';
        $teachers['draw'] = '<br>('.$teachers['name'].')';
    } else if(in_array($teacher_id, $special_woman)){
        $teachers['name'] = 'Ustdzh. Aisyah Hilma';
        $teachers['draw'] = '<br>('.$teachers['name'].')';
        $teachers['id'] = 30;
    }

    return $teachers;
}
if (!function_exists('get_character_indicator')) {

    function get_character_indicator($level = null, $class_id = null, $period = null) {
        // Class id name for code ibd
        //  VII = 2, VIII = 5, IX = 4, X = 6, XI = 7, XII = 8
        $smp_class = array(2,5,4);
        $sma_class = array(6,7,8);
        $master_data = array();

        if(!empty($period)){
            if($period == 'Q1' || $period == 'Q2'){
                $period == 1;
            } else {
                $period == 2;
            }
        }
        
       
        // Indikator Wajib SMP
        if(in_array($class_id, $smp_class)){
            $aqidah = array("Tidak berhubungan dengan jin", "Tidak meminta tolong kepada orang yang berlindung kepada jin", "Tidak meramal nasib dengan melihat telapak tangan", "Tidak menghadiri majelis dukun dan peramal", "Tidak meminta berkah dengan mengusap-usap kuburan", "Tidak meminta tolong kepada orang yang telah dikubur (mati)", "Tidak bersumpah dengan selain Allah Swt", "Tidak tasyaum (merasa sial karena melihat atau mendengar sesuatu)", "Mengikhlaskan amal untuk Allah Swt", "Mengimani rukun iman", "Beriman kepada nikmat dan siksa kubur", "Mensyukuri nikmat Allah Swt saat mendapatkan nikmat", "Menjadikan setan sebagai musuh", "Tidak mengikuti langkah-langkah setan", "Menerima dan tunduk secara penuh kepada Allah Swt dan tidak bertahkim kepada selain yang diturunkan-Nya");

            $ibadah = array("Tidak sungkan adzan", "Ihsan dalam thaharah", "Bersemangat untuk shalat berjama’ah", "Ihsan dalam shalat", "Qiyamul-Lail minimal sekali sepekan", "Membayar zakat", "Berpuasa fardlu", "Berpuasa sunat minimal sehari dalam sebulan", "Niat melaksanakan haji", "Berdoa pada waktu-waktu utama", "Menutup hari-harinya dengan bertaubat dan beristighfar", "Berniat pada setiap melakukan perbuatan", "Menjauhi dosa besar", "Merutinkan dzikir pagi hari", "Merutinkan dzikir sore hari", "Dzikir kepada Allah dalam setiap keadaan", "Memenuhi nadzar", "Menyebarluaskan salam", "Menahan anggota tubuh dari segala yang haram", "Beri’tikaf pada bulan Ramadhan, jika mungkin", "Mempergunakan siwak", "Senantiasa menjaga kondisi Thaharah, jika mungkin");

            $kepribadian = array("Tidak takabur", "Tidak imma’ah (asal ikut, tidak punya prinsip)", "Tidak dusta", "Tidak mencaci maki", "Tidak mengadu domba", "Tidak ghibah", "Tidak menjadikan orang buruk sebagai teman/sahabat", "Memenuhi janji", "Birrul walidain", "Memiliki ghirah (rasa cemburu) pada keluarganya", "Memiliki ghirah (rasa cemburu) pada agamanya", "Tidak memotong pembicaraan orang lain", "Tidak mencibir dengan isyarat apapun", "Tidak menghina dan meremehkan orang lain", "Menyayangi yang kecil", "Menghormati yang besar", "Menundukkan pandangan", "Menyimpan rahasia", "Menutupi dosa orang lain", "Melaksanakan hak kedua orang tua", "Membantu yang membutuhkan", "Memberi petunjuk orang tersesat", "Ikut berpartisipasi dalam kegembiraan");

            $pribadi = array("Menjauhi segala yang haram", "Menjauhi tempat-tempat maksiat", "Menjauhi tempat-tempat bermain yang haram", "Tidak menjalin hubungan dengan lembaga-lembaga yang menentang Islam", "Memperbaiki penampilannya (performennya)", "Bangun pagi", "Menghabiskan waktu untuk belajar");

            $alquran = array("Komitmen dengan adab tilawah", "Khusyuk dalam membaca Al-Quran", "Hafal satu juz Al-Qur’an", "Komitmen dengan wirid tilawah harian", "Memperhatikan hukum-hukum tilawah", "Membaca satu juz tafsir Al-Quran (juz 30)");

            $alfiqri = array("Baik dalam membaca dan menulis", "Mengkaji marhalah Makkiyah dan menguasai karakteristiknya", "Mengenal 10 shahabat yang dijamin masuk surga", "Mengetahui hukum thaharah", "Mengetahui hukum shalat", "Mengetahui hukum puasa", "Menyadari adanya peperangan Zionisme terhadap Islam", "Mengetahui Ghozwul Fikri", "Mengetahui organisasi-organisasi terselubung", "Mengetahui bahaya pembatasan kelahiran", "Berpartisipasi dalam kerja-kerja jama’i", "Tidak menerima suara-suara miring tentang pendakwah Islam", "Menghafalkan separuh Arba’in (1-20)", "Menghafalkan 20 hadits pilihan dari Riyadush-sholihin", "Membaca sesuatu yang di luar spesialisasinya 4 jam setiap pekan", "Memperluas wawasan diri dengan sarana-sarana baru", "Menjadi pendengar yang baik", "Mengemukakan pendapatnya", "Mencapai 80% kompetensi kognitif PAI dan mawad");

            $keterampilan = array("Menjauhi sumber penghasilan haram", "Menjauhi riba", "Menjauhi judi dengan segala macamnya", "Menjauhi tindak penipuan", "Membayar zakat", "Menabung, meskipun sedikit", "Tidak menunda dalam melaksanakan hak orang lain", "Menjaga fasilitas umum", "Menjaga fasilitas khusus", "Bersih badan", "Bersih pakaian", "Bersih tempat tinggal", "Komitmen dengan olah raga 2 jam setiap pecan", "Bangun sebelum fajar", "Memperhatikan tata cara baca yang sehat", "Mencabut diri dari merokok", "Komitmen dengan adab makan dan minum sesuai dengan sunah", "Tidak berlebihan dalam begadang", "Menghindari tempat-tempat kotor dan polusi", "Menghindari tempat-tempat bencana (bila masih di luar area)");

            // Kelas 7 Semester 1
            if($class_id == 2 && $period == 1){
                $aqidah_sm1 = array("Tidak berhubungan dengan jin", "Tidak meminta tolong kepada orang yang berlindung kepada jin", "Tidak meramal nasib", "Tidak menghadiri majelis dukun dan peramal");
                $ibadah_sm1 = array("Ihsan dalam taharah", "Memahami manfaat wudu", "Memahami dan mengamalkan fikih taharah", "Ihsan dalam salat", "Membayar zakat", "Melaksanakan zakat fitrah dengan penuh kesadaran", "Terbiasa berinfak", "Berpuasa fardu", "Menyebarluaskan salam", "Bersemangat untuk salah berjamaah", "Bersemangat untuk salat berjamaah di masjid bagi laki-laki");
                $kepribadian_sm1 = array("Tidak takabur", "Tidak imma’ah", "Tidak dusta", "Tidak mencaci maki", "Menunjukkan adab berbicara yang baik kepada orang lain", "Tidak mengadu domba", "Berusaha tidak membicarakan kekurangan orang lain", "Tidak menjadikan orang buruk sebagai teman atau sahabat", "Menepati janji", "Menunjukkan perilaku menepati janji kepada orang lain");
                $alquran_sm1 = array("Menjauhi segala yang haram", "Menjauhi tempat-tempat maksiat");
                $alfiqri_sm1 = array("Mengkaji marhalah Makkiyah dan menguasai karakteristiknya", "Mengetahui hokum taharah", "Memahami dan mengamalkan fikih taharah", "Mengetahui hokum salat");
                $ketrampilan_sm1 = array("Bersih badan", "Membiasakan merawat diri dan menjaga penampilan", "Bersih pakaian", "Bersih tempat tinggal", "Membiasakan diri menjaga kebersihan lingkungan dan memahami konsep go green");
                $aqidah = array_merge($aqidah, $aqidah_sm1);
                $ibadah = array_merge($ibadah, $ibadah_sm1);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm1);
                $alquran = array_merge($alquran, $alquran_sm1);
                $alfiqri = array_merge($alfiqri, $alfiqri_sm1);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm1);
            }       
            
            if($class_id == 2 && $period == 2){
                // Kelas 7 Semester 2
                $aqidah_sm2 = array("Tidak meminta berkah dengan benda dan tempat tertentu", "Tidak meminta tolong kepada orang yang telah dikubur", "Tidak bersumpah dengan selain Allah swt", "Menjauhi dosa besar");
                $ibadah_sm2 = array("Birrul walidain", "Melaksanakan hak orang tua", "Tidak tasya’um (merasa sial karena melihat atau mendengat sesuatu)", "Memenuhi nazar", "Tidak sungkan adzan", "Membantu yang membutuhkan", "Terbiasa membantu orang yang terkena musibah");
                $kepribadian_sm2 = array("Menjauhi sumber penghasilan haram", "Menjauhi riba", "Menjauhi judi dengan segala macamnya", "Menjauhi tindakan penipuan", "Mengetahui ghazwul fikri", "Mengetahui organisasi-organisasi terselubung", "Mengetahui pembatasan kelahiran");
                $alquran_sm2 = array("Komitmen dengan olahraga 2 jam setiap pecan", "Bangun sebelum fajar", "Mengonsumsi makanan bergizi", "Mampu berenang dengan gaya bebas", "Menguasai bela diri tingkat dasar");
                $aqidah = array_merge($aqidah, $aqidah_sm2);
                $ibadah = array_merge($ibadah, $ibadah_sm2);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm2);
                $alquran = array_merge($alquran, $alquran_sm2);
                
            }     
            

            if($class_id == 5 && $period == 1){
                // Kelas 8 Semester 1
                $aqidah_sm1 = array("Mengikhlaskan amal untuk Allah", "Mengimani rukun iman", "Beriman pada nikat dan siksa kubur");
                $ibadah_sm1 = array("Menutup hari-harinya dengan bertaubat dan beristighfar", "Berniat pada setiap melakukan perbuatan", "Zikir kepada Allah swt dalam setiap keadaan", "Senantiasa menjaga kondisi bersuci jika mungkin", "Terbiasa salat sunah rawatib");
                $kepribadian_sm1 = array("Tidak memotong pembicaraan orang lain", "Tidak mencibir dengan isyarat apapun", "Tidak menghina dan meremehkan orang lain", "Memiliki girah (rasa cemburu) pada keluarganya", "Menyayangi yang kecil", "Menghormati yang besar", "Memperbaiki penampilan");
                $pribadi_sm1 = array("Menghabiskan waktu untuk belajar");
                $alfiqri_sm1 = array("Menjadi pendengar yang baik", "Mampu mengemukakan pendapat");
                $keterampilan_sm1 = array("Memperhatikan tata car abaca yang sehat", "Tidak merokok", "Komitmen dengan adab makan dan minum sesuai sunah");
                $aqidah = array_merge($aqidah, $aqidah_sm1);
                $ibadah = array_merge($ibadah, $ibadah_sm1);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm1);
                $pribadi = array_merge($pribadi, $pribadi_sm1);
                $alfiqri = array_merge($alfiqri, $alfiqri_sm1);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm1);
            }   

            if($class_id == 5 && $period == 2){
                // Kelas 8 Semester 2
                $aqidah_sm2 = array("Mensyukuri nikmat Allah swt saat mendapatkan nikmat", "Menjadikan setan sebagai musuh", "Tidak mengikuti langkah-langkah setan", "Menerapkan pemahaman al-Asmau Al-Husna dalam kehidupan sehari-hari");
                $ibadah_sm2 = array("Komitmen dengan wirid tilawah harian", "Merutinkan zikir pagi dan sore", "Berdoa pada waktu-waktu utama");
                $kepribadian_sm2 = array("Senang berinfak dan bersedekah", "Menabung meskipun sedikit", "Menjaga fasilitas umum dan khusus", "Memberi petunjuk orang tersesat", "Ikut berpartisipasi dalam kegembiraan", "Memahami konsep diri dnegan benar dan mampu bersikap dengan baik", "Menjenguk dan mendoakan orang yang terkena musibah", "Menunjukkan sifat qana’ah dalam kehidupan sehari-hari");
                $pribadi_sm2 = array("Menjauhi tempat bermain yang haram", "Terbiasa menghargai aturan", "Mampu mengendalikan emosi");
                $alfiqri_sm2 = array("Berpartisipasi dalam kerja-kerja jama’i", "Memperluas wawasan dengan sarana-sarana yang baru", "Tidak mengkonsumsi makanan rendah gizi");
                $aqidah = array_merge($aqidah, $aqidah_sm2);
                $ibadah = array_merge($ibadah, $ibadah_sm2);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm2);
                $pribadi = array_merge($pribadi, $pribadi_sm2);
                $alfiqri = array_merge($alfiqri, $alfiqri_sm2);
            }   

            

            if($class_id == 4 && $period == 1){
                // Kelas 9 Semester 1
                $aqidah_sm1 = array("Menerima dan tunduk secara penuh kepada Allah dan tidak bertahkim kepada selain yang diturunkan-Nya", "Mengesakan Allah dan tidak menyekutukan-Nya dalam asma’, sifat, dan perbuatan");
                $ibadah_sm1 = array("Gemar qiyamul lail", "Gemar berpuasa sunah", "Gemar salat duha", "Beriktikaf pada bulan Ramadan jika mungkin", "Mempu mengajak kebaikan dan mencegah keburukan", "Terbiasa menutup aurat dengan penuh");
                $kepribadian_sm1 = array("Menutup dosa orang lain", "Tidak menunda dalam melaksanakan hak orang lain", "Mampu menunjukkan sikap percaya diri yang berlandaskan pada nilai kebenaran", "Menunjukkan rasa malu dalam berbuat dosa", "Menundukkan pandangan", "Menikah dengan pasangan yang sesuai", "Menunjukkan perilaku menyambung tali persaudaraan", "Menunjukkan perilaku memuliakan tamu", "Memiliki ghirah (rasa cemburu) pada agama");
                $pribadi_sm1 = array("Menjaga pandangan dan pendengaran");
                $alfiqri_sm1 = array("Tidak menerima suara-suara miring tentang Islam (melakukan pembelaan)", "Tidak berlebihan dalam begadang");
                $keterampilan_sm1 = array("Menghindari tempat-tempat kotor dan polusi");
                $aqidah = array_merge($aqidah, $aqidah_sm1);
                $ibadah = array_merge($ibadah, $ibadah_sm1);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm1);
                $pribadi = array_merge($alquran, $pribadi_sm1);
                $alfiqri = array_merge($alfiqri, $alfiqri_sm1);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm1);
            }   
            
            

            if($class_id == 4 && $period == 2){
                // Kelas 9 Semester 2
                $aqidah_sm2 = array("Mengikhlaskan amal untuk Allah swt", "Mengimani rukun iman", "Tauhidullah", "Menjadikan setan sebagai musuh", "Menerima dan tunduk secara penuh kepada Allah swt dan tidak bertahkim kepada selain yang diturunkan-Nya");
                $ibadah_sm2 = array("Qiyamullail minimal sekali dalam sepekan", "Mengenal tugas nabi dan rasul", "Merutinkan zikir pagi hari", "Zikir kepada Allah swt dalam setiap keadaan", "Tidak menyekutukan Allah swt dalam asma’-Nya");
                $kepribadian_sm2 = array("Memiliki girah pada keluarganya", "Memiliki rasa cemburu (girah) pada agamanya", "Tidak memotong pembicaraan orang lain", "Tidak mencibir dengan isyarat apa pun", "Tidak menghina dan meremehkan orang lain", "Ikut berpartisipasi dalam kegembiraan");
                $pribadi_sm2 = array("Menjauhi tempat-tempat bermain yang haram");
                $alfiqri_sm2 = array("Tidak menerima suara-suara miring tentang pendakwah islam");
                $keterampilan_sm2 = array("Komitmen dengan adab makan dan minum sesuai dengan sunah");
                $aqidah = array_merge($aqidah, $aqidah_sm2);
                $ibadah = array_merge($ibadah, $ibadah_sm2);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm2);
                $pribadi = array_merge($alquran, $pribadi_sm2);
                $alfiqri = array_merge($alfiqri, $alfiqri_sm2);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm2);
            }   
            
            



        } else if(in_array($class_id, $sma_class)){
            // Indikator Wajib SMA

            $aqidah = array("Tidak mengafirkan seorang muslim", "Tidak mendahulukan makhluk atas Khaliq", "Mengingkari orang-orang yang memperolok-olokkan ayat-ayat Allah swt dan tidak bergabung dalam majelis mereka", "Mengesakan Allah swt dalam Rububiyyah dan Uluhiyyah", "Tidak menyekutukan Allah swt, tidak dalam Asma'-Nya, sifat-Nya dan Af'al-Nya", "Tidak meminta berkah dengan mengusap-usap kuburan", "Mempelajari madzhab-madzhab Islam yang berkaitan dengan Asma dan Sifat dan mengikuti madzhab salaf", "Mengetahui batasan berwala dan berbara'", "Bersemangat untuk berteman dengan orang-orang shalih dari sisi-sisi kedekatan dan peneladanan", "Meyakini terhapusnya dosa dengan taubat Nashuha", "Memprediksikan datangnya kematian kapan saja", "Meyakini bahwa masa depan ada di tangan Islam", "Berusaha meraih rasa manisnya iman", "Berusaha meraih rasa manisnya ibadah", "Merasakan adanya para malaikat mulia yang mencatat amalnya", "Merasakan adanya istighfar para malaikat dan doa mereka");

            $ibadah = array("Melakukan qiyamul-Lail minimal satu kali dalam satu pecan", "Bersedekah", "Berpuasa sunnat minimal dua hari dalam satu bulan", "Haji jika mampu", "Banyak bertaubat", "Memerintahkan yang ma'ruf", "Mencegah yang Munkar", "Ziarah kubur untuk mengambil Ibrah", "Merutinkan ibadah-ibadah sunnah Rawatib", "Khusyu dalam shalat", "Selalu memperbaharui niat dan meluruskannya", "Menjaga organ tubuh (dari dosa)", "Banyak dzikir kepada Allah swt disertai hafalan terhadap yang mudah-mudah", "Banyak berdoa dengan memperhatikan syarat-syarat dan tata kramanya", "Senantiasa bertafakkur", "Beri'tikaf satu malam pada setiap bulannya");

            $kepribadian = array("Tidak Inad (membangkang)", "Tidak banyak mengobrol", "Sedikit bercanda", "Tidak berbisik dengan sesuatu yang bathil", "Tidak Hiqd (menyimpan kemarahan)", "Tidak Hasad", "Memiliki rasa malu berbuat kesalahan", "Menjalin hubungan baik dengan tetangga", "Tawadhu tanpa merendahkan diri", "Pemberani", "Menjenguk orang sakit", "Komitmen dengan adab meminta izin", "Mensyukuri orang yang berbuat baik kepadanya", "Menyambung silaturahim (shilatur-rahim)", "Komitmen dengan tata krama sebagai pendengar", "Komitmen dengan adab berbicara", "Memuliakan tamu", "Menjawab salam", "Menebar senyum di depan orang lain", "Berhati lembut", "Merendahkan suara", "Komitmen dengan adab Islam di rumah", "Memberi hadiah kepada tetangga", "Membantu yang membutuhkan", "Menolong yang terzhalimi", "Bersemangat mendakwahi istrinya, anak-anaknya, dan kerabatnya", "Mendoakan yang bersin", "Memberikan pelayanan umum karena Allah swt", "Memberikan sesuatu dari yang dimiliki", "Mendekati orang lain", "Mendorong orang lain berbuat baik", "Membantu yang kesulitan", "Membantu yang terkena musibah", "Berusaha memenuhi hajat orang lain", "Memberi makan orang lain");

            $pribadi = array("Selalu menyertakan niat  jihad", "Menjadikan dirinya bersama orang baik", "Menyumbangkan sebagian hartanya untuk amal islami", "Sabar atas bencana", "Menyesuaikan perbuatan dengan ucapan", "Menerima dan memikul beban dakwah", "Memerangi dorongan-dorongan nafsu", "Tidak berlebihan mengkonsumsi yang mubah", "Memakan apa yang disuguhkan dengan penuh keridhaan", "Shalat menjadi barometer manajemen waktunya", "Teratur di dalam rumah dan kerjanya", "Menertibkan ide-ide dan pikiran-pikirannya", "Bersemangat memenuhi janji-janji kerja", "Memberitahukan gurunya problematika-problematika yang muncul", "Menjaga janji-janji umum dan khusus", "Mengisi waktunya dengan hal-hal yang berfaedah dan bermanfaat", "Memperhatikan adab Islam dalam berkunjung dan mempersingkat pemenuhan hajatnya");

            $alquran = array("Khusyu saat membaca Alquran", "Sekali Khatam Alquran setiap dua bulan", "Mengaitkan antara Alquran dengan realita", "Membaca tafsir dua juz Al quran (28-29)", "Hafal dan bertajwid tiga juz Al quran (28-30)");

            $alfiqri = array("Mengkaji marhalah Madaniyyah dan menguasai karakteristiknya", "Mengenal sirah 20 sahabat yang syahid", "Mengetahui hukum Zakat", "Mengetahui fiqih Haji", "Mengetahui sisi-sisi Syumuliyatul Islam", "Mengetahui problematika kaum muslimin internal dan eksternal", "Mengetahui apa kerugian dunia akibat kemunduran kaum muslimin", "Mengetahui urgensi Khilafah dan kesatuan kaum muslimin", "Mengetahui dan mengulas “tiga risalah”, yaitu: Da'watuna, Ila Ayyi Syai'in Nad'un-Naas dan Ilasy-Syabab.", "Mengetahui dan mengulas risalah Aqaid", "Memahami amal jama'i dan taat", "Membantah suara-suara miring yang dilontarkan kepada kita", "Mengetahui bagaimana proses berdirinya negara Israel", "Mengetahui arah-arah pemikiran Islam kontemporer", "Memiliki kemampuan mengulas apa yang ia baca", "Menghafal seluruh hadits Arbain (20 + 20)", "Menghafal 50 hadits Riyadhush-Shalihin (20 + 30)", "Membaca tujuh jam setiap pekan di luar spesialisasinya", "Menghadiri konferensi dan seminar kita", "Mengenali hal-hal baru dari problematika kekinian", "Menyebarluaskan apa saja yang diterbitkan oleh koran dan terbitan kita", "Berpartisipasi dalam melontarkan dan memecahkan masalah", "Mencapai 80% kompetensi kognitif PAI dan mawad");

            $keterampilan = array("Bekerja dan berpenghasilan", "Berusaha memiliki spesialisasi", "Sedang dalam nafkah", "Mengutamakan produk-produk Islam", "Menjaga kepemilikan khusus", "Tidak berambisi menjadi pegawai negeri", "Mengutamakan spesialisasil angka yang penting dan dinamis", "Hartanya tidak pergi ke pihak non Muslim", "Berusaha untuk memperbaiki kualitas produk dengan harga sesuai", "Membersihkan peralatan makan dan minumnya", "Mampu mempersiapkan makanan", "Mengikuti petunjuk-petunjuk kesehatan dalam tidur dan bangun tidur semampunya", "Mengobati diri sendiri", "Tidak mempergunakan obat tanpa meminta petunjuk", "Menjauhi makanan-makanan yang diawetkan dan mempergunakan minuman-minuman alami", "Mengatur waktu-waktu makan", "Tidak berlebihan mengkonsumsi lemak", "Tidak berlebihan mengkonsumsi garam", "Tidak berlebihan mengkonsumsi gula", "Memilih produsen-produsen makanan", "Tidur 6 - 8 jam dan bangun sebelum fajar", "Berlatih 10 - 15 menit setiap hari", "Berjalan 2 - 3 jam setiap pekan");

            if($class_id == 6 && $period == 1){
                // Kelas 10 Semester 1
                $keterampilan_sm1 = array("Meneladani metode dakwah wali songo", "Memahami empat pilar kebangsaan");
                $aqidah_sm1 = array("Mengesakan Allah swt dalam rububiyyah dan uluhiyyah", "Tidak menyekutukan Allah swt., tidak dalam asma-Nya, dan af’al-Nya.", "Tidak mendahulukan makhluk atas khaliq", "Mengingkari orang-orang yang memperolok-olokan ayat-ayat Allah swt dan tidak bergabung");
                $ibadah_sm1 = array("Melakukan qiyamul lail minima satu kali dalam satu pekan", "Memerintahkan yang ma’ruf", "Mencegah yang munkar");
                $kepribadian_sm1 = array("Komitmen dengan adab islam di rumah", "Tidak al-‘inad", "Risalatul insan", "Tidak banyak mengobrol", "Tidak berbisik dengan sesuatu yang batil", "Tidak hiqd (menyimpan kemarahan)");
                $aqidah = array_merge($aqidah, $aqidah_sm1);
                $ibadah = array_merge($ibadah, $ibadah_sm1);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm1);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm1);
            }
            
               
            if($class_id == 6 && $period == 2){
                // Kelas 10 Semester 2
                $keterampilan_sm2 = array("Bersikap toleran", "Memahami Dakwah Islam Kultural di Nusantara", "Mengetahui sisi-sisi syumuliyatul Islam");
                $kepribadian_sm2 = array("Membiasakan diri memuliakan Islam melalui sikap sehari-hari", "Melaksanakan hak-hak teman", "Membantu yang membutuhkan", "Pemberani", "Menolong yang terdzalimi");
                $pribadi_sm2 = array("Selalu menyertakan niat jihad", "Selalu menyertakan niat jihad", "Menjadikan dirinya bersama orang baik", "Menyesuaikan perbuatan dengan ucapan", "Menjaga janji-janji umum dan khusus", "Menjaga janji-janji umum dan khusus");
                $kepribadian = array_merge($kepribadian, $kepribadian_sm2);
                $pribadi = array_merge($alquran, $pribadi_sm2);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm2);
            }
            
            
            if($class_id == 7 && $period == 1){
                // Kelas 11 Semester 1
                $keterampilan_sm1 = array("Memahami peran umat islam dalam kemerdekaan Indonesia", "Memahami kelemahan umat islam saat ini", "Mengetahui problematika kaum muslimin internal dan eksternal", "Meneladani kepemimpinan dan semangat juang pahlawan muslim", "Mengetahui apa kerugian dunia akibat kemunduran kaum muslim", "Mengetahui urgensi kesatuan kaum Muslimin");
                $pribadi_sm1 = array("Mengisi waktunya dengan hal-hal yang berfaedah dan bermanfaat", "Teratur di dalam rumah dan kerjaannya", "Berusaha memiliki spesialisasi", "Mengutamakan produk-produk islam");
                $kepribadian_sm1 = array("Memahami karakter dinul islam","Memahami cara menentukan umat");
                $kepribadian = array_merge($kepribadian, $kepribadian_sm1);
                $pribadi = array_merge($alquran, $pribadi_sm1);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm1);
            }
            
            
            if($class_id == 7 && $period == 2){
                // Kelas 11 Semester 2
                $keterampilan_sm2 = array("Memahami lahirnya Piagam Jakarta dan Pancasila", "Memahami umat islam sebagai penyokong kekuatan NKRI", "Mengetahui dan mengulas risalah aqa’id", "Memahami amal jama’I dan taat", "Membantah suara-suara miring yang dilontarkan kepada islam dan dakwah");
                $aqidah_sm2 = array("Al-inqilah lil islami", "Mengetahui batasan ber-wala’ dan ber-bara’", "Berusaha meraih rasa manisnya iman", "Berusaha meraih rasa manisnya ibadah");
                $ibadah_sm2 = array("Selalu memperbaharui niat dan meluruskannya", "Menjaga organ tubuh (dari dosa)");
                $kepribadian_sm2 = array("Komitmen dengan adab meminta izin");
                $aqidah = array_merge($aqidah, $aqidah_sm2);
                $ibadah = array_merge($ibadah, $ibadah_sm2);
                $kepribadian = array_merge($kepribadian, $kepribadian_sm2);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm2);
            }
            
            
            if($class_id == 8 && $period == 1){
                // Kelas 12 Semester 1
                $keterampilan_sm1 = array("Menjaga keutuhan NKRI", "NKRI dan falsafah bernegara");
                $kepribadian_sm1 = array("Membantu orang tua");
                $pribadi_sm1 = array("Menerima dan memikul beban dakwah", "Menerima dan memikul beban dakwah", "Menerima dan memikul beban dakwah", "Menerima dan memikul beban dakwah", "Menerima dan memikul beban dakwah", "Memerangi dorongan-dorongan nafsu");
                $kepribadian = array_merge($kepribadian, $kepribadian_sm1);
                $pribadi = array_merge($alquran, $pribadi_sm1);
                $keterampilan = array_merge($keterampilan, $keterampilan_sm1);
            }
            
            
            if($class_id == 8 && $period == 2){
                // Kelas 12 Semester 2
                $keterampilan_sm2 = array("Memiliki semangat bela negara dalam konteks jihad fil islam", "Memiliki tekad menjadi generasi penerus bangsa yang berkualitas", "Iqamatud Din", "Pilar-pilar kebangkitan umat", "Mengetahui dan mengulas tiga risalah, yaitu da'watuna, illa ayyi syai'in nad'unnas, dan illasysyabab", "Mengetahui dan mengulas tiga risalah, yaitu da'watuna, illa ayyi syai'in nad'unnas, dan illasysyabab", "Mengetahui dan mengulas tiga risalah, yaitu da'watuna, illa ayyi syai'in nad'unnas, dan illasysyabab");    
                $keterampilan = array_merge($keterampilan, $keterampilan_sm2);
            }
                    
        }

        $compliance = array('aqidah', 'ibadah', 'kepribadian', 'pribadi', 'alquran', 'alfiqri', 'keterampilan');
        $curly = 1;

        foreach($compliance as $comp){
            $seleb = ${$comp};        
            if(!empty($seleb)){
                $nom = 1;
                $newseleb = array();
                foreach($seleb as $row){
                    $num_padded = sprintf("%02d", $nom);
                    $numberseleb = $curly.$num_padded;
                    $newseleb[$numberseleb] = $row;
                    $nom++;
                }

                ${$comp} = $newseleb;
            }
            $curly++;
        }       

        $master_data = array(
            '1' => array(
                'name' => 'Akidah Yang Bersih',
                'indicator' => $aqidah
            ),
            '2' => array(
                'name' => 'Ibadah Yang Benar',
                'indicator' => $ibadah
            ),
            '3' => array(
                'name' => 'Kepribadian yang matang dan berakhlak mulia',
                'indicator' => $kepribadian
            ),
            '4' => array(
                'name' => 'Pribadi yang sungguh-sungguh,  disiplin dan mampu menahan nafsunya',
                'indicator' => $pribadi
            ),
            '5' => array(
                'name' => 'Mampu membaca, menghafal, dan memahami  Al Quran
                ',
                'indicator' => $alquran
            ),
            '6' => array(
                'name' => 'Mutsaqoful Fikri',
                'indicator' => $alfiqri
            ),
            '7' => array(
                'name' => 'Memiliki ketrampilan hidup (Kesehatan dan kebugaran, lifeskill dan berwirausaha, pengembangan diri)',
                'indicator' => $keterampilan
            )
        );

        return $master_data;
    }
}
if (!function_exists('get_sign_date')) {
    function get_sign_date($date) {
        $month = array(
            '1' => 'Januari',
            '01' => 'Januari',
            '2' => 'Februari',
            '02' => 'Februari',
            '3' => 'Maret',
            '03' => 'Maret',
            '4' => 'April',
            '04' => 'April',
            '5' => 'Mei',
            '05' => 'Mei',
            '6' => 'Juni',
            '06' => 'Juni',
            '7' => 'Juli',
            '07' => 'Juli',
            '8' => 'Agustus',
            '08' => 'Agustus',
            '9' => 'September',
            '09' => 'September',
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

function get_tahsin_target_grade($class_id, $period){
    if($class_id == 'VII' || $class_id == 'X'){
        $grade = 'Basic 3';
    } else if($class_id == 'VIII' || $class_id == 'XI'){
        $grade = 'Intermediate 3';
    } else if($class_id == 'IX' || $class_id == 'XII'){
        $grade = 'Advance 3';
    }
    return $grade;
}

function get_tahsin_target_detail($grade){
    $target = array(
        'Basic 3' =>   'Tepat dalam konsistensi tanda panjang<br>
                        Tepat dalam keseimbangan tanda gunnah<br>
                        Tepat dalam pengucapan huruf sukun<br>
                        Tepat dalam tuntutan kesempurnaan vokal<br>',
        'Basic 2' =>   'Kriteria Belum Sempurna di Salah Satu Kriteria<br> 
                        meliputi (Konsistensi Tanda Panjang, Keseimbangan Tanda Gunnah,<br> 
                        Pengucapan Huruf Sukun dan Tuntutan Kesempurnaan Vokal)',
        'Basic 1' =>   'Kriteria Bacaan Masih Terbata-bata<br>Predikat Belum Terlampaui',
    );
    return $target[$grade];
}

function get_tahfizh_target($class_id, $period){
    switch($period){
        case 'SM1':
        case 'SM2':
            $session = 'SM1';
        break;

        case 'SM3':
        case 'SM4':
            $session = 'SM2';
        break;

        default:
            $session = 'SM1';
        break;
    }
    if(($class_id == 'VII' || $class_id == 'X') && $session == 'SM1'){
        $target = 'Tahsin';
    } else if(($class_id == 'VII' || $class_id == 'X') && $session == 'SM2'){
        $target = '1 Juz (Juz 30)';
    } else if(($class_id == 'VIII' || $class_id == 'XI') && $session == 'SM1'){
        $target = '3 Juz (Juz 30, 29, 28)';
    } else if(($class_id == 'VIII' || $class_id == 'XI') && $session == 'SM2'){
        $target = '5 Juz (Juz 30, 29, 28, 27, 26)';
    } else if(($class_id == 'IX' || $class_id == 'XII') && $session == 'SM1'){
        $target = '6 Juz (Juz 30, 29, 28, 27, 26, 1)';
    } else if(($class_id == 'IX' || $class_id == 'XII') && $session == 'SM2'){
        $target = '6 Juz (Munaqosyah)';
    }
    return $target;
}

if (!function_exists('translate_day_id')) {
    function translate_day_id($day) {
        $month = array(
            'Sunday' => 'Ahad',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        );

        return $month[$day];
    }
}

function get_period_name($period=null) {
    $periods = array(
        'Q1' => 'JULI - SEPTEMBER',
        'Q2' => 'OKTOBER - DESEMBER',
        'Q3' => 'JANUARI - MARET',
        'Q4' => 'APRIL - JUNI'
    );

    if(!empty($period)){
        return $periods[$period];
    }

    return $periods['Q1'];

}

function get_academic_year_name($period=null, $sessions = null) {
    $pieces = explode("/", $sessions);
    if($period == 'Q1' || $period == 'Q2'){
        return $pieces[0];
    } else {
        return $pieces[1];
    }
}
/*STRICT DATA ACCESS END*/