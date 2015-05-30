<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Carbon\Carbon;

$mpdf = new \mPDF('utf-8', 'A3');
$date = Carbon::now()->format('y-m-d');

$bootstrap_css = file_get_contents('bs3/css/bootstrap.min.css');

$stylesheet = file_get_contents('css/pdf.css');

$mpdf->WriteHTML($bootstrap_css, 1);
$mpdf->WriteHTML($stylesheet, 1);

$html = '';
$html .= '<html>';
$html .= '<head>';
$html .= '</head>';
$html .= '<body>';
$html .= '<div class="wrapper">';
$html .= '<div class="logo">';
$html .= '<img src="images/client-files/logo-file-print.jpg" />';
$html .= '</div>';
$html .= '<div class="data">';
$html .= 'data here !!!!';
$html .= '</div>';
$html .= '</div>';
$html .= '</body>';
$html .= '</html>';
$mpdf->WriteHTML($html);

$mpdf->Output($date . '.pdf', 'I');

exit;