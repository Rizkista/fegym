<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
 use Dompdf\Dompdf;
  
 class Pdf {
     public function __construct(){
        require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
        $pdf = new DOMPDF();
        $options = $pdf->getOptions();
        $options->setDefaultFont('sans-serif');
        $options->setIsRemoteEnabled(true);
        $pdf->setOptions($options);

        $CI =& get_instance();
        $CI->dompdf = $pdf;
     }
 }
 ?>