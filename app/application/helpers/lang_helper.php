<?php

  function t($string) {
    $string = trim($string);
    $CI = & get_instance();
 // echo $CI->session->userdata('lang');die;
    $lang_code = $CI->session->userdata('lang') ? $CI->session->userdata('lang') : 'en';
    if ($lang_code == 'en')
        return $string;
    else {
        $data = $CI->db->select('en, ' . $lang_code)->where('en', $string)->get('translator')->row();
        if (!empty($data))
            return $data->{$lang_code} != '' ? $data->{$lang_code} : $string;
        else
            return $string;
    }
}

function t_key($string) {
    $string = trim($string);
    $CI = & get_instance();
    $lang_code = $CI->session->userdata('lang') ? $CI->session->userdata('lang') : 'en';
    $data = $CI->db->select('en, ' . $lang_code)->where('msg_str', $string)->get('translator')->row();
    if (!empty($data))
        return $data->{$lang_code} != '' ? $data->{$lang_code} : $string;
    else
        return $string;
}

?>
