<?php defined('BASEPATH') or exit('No direct script access allowed');
define('DOMPDF_ENABLE_AUTOLOAD', false);
require_once 'dompdf_0-8-6/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator
{
    public function generate($html, $filename = '',  $paper = '', $orientation = '', $stream = TRUE)
    {
		ob_start();
		$log_type = 'INFO';
		log_message($log_type,'[REQ]'.'[PDFGENERATOR]'.'[<<<]'."CEKCEK");
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
			ob_end_clean();
			$log_type = 'INFO';
			log_message($log_type,'[REQ]'.'[PDFGENERATOR]'.'[<<<]'."STREAM");
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
            exit();
        } else {
			$log_type = 'INFO';
			log_message($log_type,'[REQ]'.'[PDFGENERATOR]'.'[<<<]'."GAGAL");
            return $dompdf->output();
        }
    }
}