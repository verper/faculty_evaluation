<?php
class Pdf {
    
    function m_pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        // include_once APPPATH.'mpdf/mpdf.php';
        include_once 'mpdf/mpdf.php';
         
        if ($params == NULL)
        {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';                
        }
         
        //return new mPDF($param);
        return new mPDF();
    }
}