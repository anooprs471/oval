<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Philo\Blade\Blade;
use Carbon\Carbon;

$mpdf = new \mPDF();

$mpdf->WriteHTML('<p>Hallo World</p>');

$mpdf->Output();