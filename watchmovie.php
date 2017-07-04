<?php
	$host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
        $loginData = file('../.credentials.txt');
        foreach ($loginData as $line) {
                list($username, $password) = explode(',',$line);
        }
	$movieId = $_GET['movieId'];
        $credentials    =       "user = $username password=$password";
        $conn = pg_connect( " $host $port $dbname $credentials" )
           or die ("Could not connect to server\n");
        session_start();
        $userId = ( isset ( $_SESSION['userId'] ) && trim ( $_SESSION['userId'] ) != 'NA' )? trim ( $_SESSION['userId'] ) : 'NA' ;
if ( $userId != "NA" ) {
echo "
	<!DOCTYPE html>
	<html> 
	<head>
	<title>Entertainment.in</title>
	<meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <link rel=\"stylesheet\" href=\"bootstrap/css/bootstrap.min.css\">

        <link rel=\"stylesheet\" href=\"font-awesome/css/font-awesome.min.css\">
        <script src=\"bootstrap/jquery.min.js\"></script>
        <script src=\"bootstrap/js/bootstrap.min.js\"></script>
	<style>
		 #myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;

}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: white;
}

.myspanstyletable:hover {
        cursor: pointer;
}
.myspanstyle:hover {
        color:#9999ff;
}
	</style>
</head>
<body style=\"background-color:transparent\">
<div class=\"container\" >
	<div class=\"row\">
		<div class=\"col-lg-2\"></div>
		<div class=\"col-lg-8\">
			<video width=\"600\"  controls controlslist=\"nodownload\" style=\"border:3px solid black\">
				<source src=\"displaywase.php?movieId=${movieId}\" type=\"video/mp4\">
				Your browser does not support HTML5 video.
			</video>
		</div>
		<div class=\"col-lg-2\" style=\"background-color: #f1f1f1;padding:25px\">";
			 $query = "select * from moviedeatils where name='${movieId}'";
			$result = pg_query($query);
			if($result) {
				echo "<br><br><table id=\"myTable\" class=\"table table-hover\" style=\"border:1px solid;\">";
				while ($row = pg_fetch_row($result)) {
					echo "<tr><th>Name</th><td>$row[0]</td></tr>
					      <tr><th>Genre</th><td>$row[1]</td></tr>
					      <tr><th>Language</th><td>$row[2]</td></tr>
					      <tr><th>Actor</th><td>$row[3]</td></tr>
					      <tr><th>Actress</th><td>$row[4]</td></tr>
					";
				}
			}
echo "		</div>
	</div>
</div>
</body> 
</html>";
}
else {
	
echo "<script type=\"text/javascript\">
                        alert('Server Busy,  Please tryagian later');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
}
pg_close($conn);
?>
