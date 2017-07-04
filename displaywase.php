<?php

require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
session_start();
$userId = ( isset ( $_SESSION['userId'] ) && trim ( $_SESSION['userId'] ) != 'NA' )? trim ( $_SESSION['userId'] ) : 'NA' ;
if ( $userId != "NA" && $userId != NULL ) {
	$keyname = $_GET['movieId'] . ".mp4";
	$bucket = 'kedage';
	$s3 = S3Client::factory(array(
	    'profile' => 'my_profile',
	    'signature' => 'v4',
	    'region' => 'ap-south-1'
	));

	try {
	    // Get the object
	    $result = $s3->getObject(array(
	    'Bucket' => $bucket,
	    'Key'    => $keyname
	));

  	// Display the object in the browser
	    header("Content-Type: {$result['ContentType']}");
	    echo $result['Body'];
	} catch (S3Exception $e) {
  		echo $e->getMessage() . "\n";
	}
}
else {
	
echo "<script type=\"text/javascript\">
                        alert('Sorry Login credentials is missing, Please login and try again');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
}
?>
