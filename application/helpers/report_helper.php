<?php

header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('get_enrollment')) {

    function get_enrollment($student_id, $academic_year_id) {
        $ci = & get_instance();
        $ci->db->select('E.*');
        $ci->db->from('enrollments AS E');
        $ci->db->where('E.student_id', $student_id);
        $ci->db->where('E.academic_year_id', $academic_year_id);
        return $ci->db->get()->row();
    }

}

if (!function_exists('get_student_monthly_attendance')) {

    function get_student_monthly_attendance($school_id, $student_id, $academic_year_id, $class_id, $section_id, $month, $days) {

        $fields = '';

        for ($i = 1; $i <= $days; $i++) {
            if ($i == $days) {
                $fields .= 'SA.day_' . $i;
            } else {
                $fields .= 'SA.day_' . $i . ',';
            }
        }

        $ci = & get_instance();
        $ci->db->select($fields);
        $ci->db->from('student_attendances AS SA');
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.class_id', $class_id);
        if($section_id){
        $ci->db->where('SA.section_id', $section_id);
        }
        $ci->db->where('SA.month', $month);
        return $ci->db->get()->row();
    }

}

if (!function_exists('get_teacher_monthly_attendance')) {

    function get_teacher_monthly_attendance($school_id, $teacher_id, $academic_year_id, $month, $days) {

        $fields = '';

        for ($i = 1; $i <= $days; $i++) {
            if ($i == $days) {
                $fields .= 'TA.day_' . $i;
            } else {
                $fields .= 'TA.day_' . $i . ',';
            }
        }

        $ci = & get_instance();
        $ci->db->select($fields);
        $ci->db->from('teacher_attendances AS TA');
        $ci->db->where('TA.school_id', $school_id);
        $ci->db->where('TA.teacher_id', $teacher_id);
        $ci->db->where('TA.academic_year_id', $academic_year_id);
        $ci->db->where('TA.month', $month);
        return $ci->db->get()->row();
    }

}


if (!function_exists('get_employee_monthly_attendance')) {

    function get_employee_monthly_attendance($school_id, $employee_id, $academic_year_id, $month, $days) {

        $fields = '';

        for ($i = 1; $i <= $days; $i++) {
            if ($i == $days) {
                $fields .= 'EA.day_' . $i;
            } else {
                $fields .= 'EA.day_' . $i . ',';
            }
        }

        $ci = & get_instance();
        $ci->db->select($fields);
        $ci->db->from('employee_attendances AS EA');
        $ci->db->where('EA.school_id', $school_id);
        $ci->db->where('EA.employee_id', $employee_id);
        $ci->db->where('EA.academic_year_id', $academic_year_id);
        $ci->db->where('EA.month', $month);
        return $ci->db->get()->row();
    }

}

/** CUSTOM BY FATHAN F */
if (!function_exists('get_student_monthly_tahfizh')) {

    function get_student_monthly_tahfizh($school_id, $student_id, $academic_year_id, $class_id, $section_id = null, $month, $days) {

        $fields = '';

        for ($i = 1; $i <= $days; $i++) {
            if ($i == $days) {
                $fields .= 'SA.day_' . $i;
            } else {
                $fields .= 'SA.day_' . $i . ',';
            }
        }

        $fields .= ',ST.name';

        $ci = & get_instance();
        $ci->db->select($fields);
        $ci->db->from('student_tahfizh AS SA');
        $ci->db->join('students AS ST', 'ST.id = SA.student_id', 'left');
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.class_id', $class_id);
        if(isset($section_id)) {
            $ci->db->where('SA.section_id', $section_id);
        }
        $ci->db->where('SA.month', $month);
        return $ci->db->get()->row();
    }

}

if (!function_exists('get_student_tahfizh_record')) {

    function get_student_tahfizh_record($school_id, $student_id, $academic_year_id, $class_id, $section_id = null, $month, $year) {

        $ci = & get_instance();
        $ci->db->select('ST.name as name, E.roll_no, E.class_tahfizh_id, ST.photo, C.name as class_name, S.name as section, T.name as teacher_name, AY.start_year as academic_year_start, AY.end_year as academic_year_end');
        $ci->db->from('student_tahfizh AS SA');
        $ci->db->join('students AS ST', 'ST.id = SA.student_id', 'left');
        $ci->db->join('enrollments AS E', 'E.student_id = SA.student_id', 'left');
        $ci->db->join('classes AS C', 'C.id = SA.class_id', 'left');
        $ci->db->join('sections AS S', 'S.id = SA.section_id', 'left');
        $ci->db->join('teachers AS T', 'T.id = SA.class_id', 'left');
        $ci->db->join('academic_years AS AY', 'AY.id = SA.academic_year_id', 'left');
        $ci->db->where('SA.school_id', $school_id);
        $ci->db->where('SA.student_id', $student_id);
        $ci->db->where('SA.academic_year_id', $academic_year_id);
        $ci->db->where('SA.class_id', $class_id);
        if(isset($section_id)){
            $ci->db->where('SA.section_id', $section_id);
        }
        $ci->db->where('SA.month', $month);
        return $ci->db->get()->row();
    }

}

if (!function_exists('get_predicate')) {
    function get_predicate($value = null) {
        $predicate = "";
        switch ($value){
            case 'A+':
            $predicate = 'Mumtaz';
            break;

            case 'A':
            $predicate = 'Jayyid Jiddan';
            break;
            
            case 'B':
            $predicate = 'Jayyid';
            break;

            case 'C':
            $predicate = 'Maqbul';
            break;

            case 'D';
            $predicate = 'Naqis';
            break;

            case 'E';
            $predicate = 'Rosib/Dhoif';
            break;
        }

        return $predicate;
    }
}


