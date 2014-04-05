<?php

require_once('lib.php');
output_header("Careers", array("stylesheet.css"));

header('Content-Type: text/html');

$xmlFile = new DOMDocument();
$xmlFile->load('joblistings.xml');
//echo $xmlFile->saveXML();

$xslFile = new DOMDocument();
$xslFile->load('formatlisting.xsl');

$proc = new XSLTProcessor();
$proc->importStylesheet($xslFile);
echo $proc->transformToXML($xmlFile);

output_footer();
?>
