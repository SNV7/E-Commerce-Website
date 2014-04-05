<?php

require_once('lib.php');

$dirPrefix = $_SERVER['DOCUMENT_ROOT']."/../private_html/";

$image = null;
$image_mime = null;

if (array_key_exists('name', $_GET) && count($_GET) == 1)
{
	$name = trim($_GET['name']);
	$name = htmlspecialchars($name);
	$image = $dirPrefix.$name;

	if ( file_exists($image) )
	{
		$fi = new finfo(FILEINFO_MIME);

		$image_mime = $fi->file($image);

    if($image != null && $image_mime != null)
    {
			header('Content-Type: '.$image_mime);
			@readfile($image);
			exit(0);
    }
  }
}
//else
http_response_code(404);
output_header("Image Not Found", array("stylesheet.css"));
echo <<<ZZEOF
			<h4>404 File Not Found</h4>
			<p>The requested resource could not be found.</p>

ZZEOF;
output_footer();
exit(0);