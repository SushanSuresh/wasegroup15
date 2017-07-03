<?php
        $host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
	$loginData = file('../.credentials.txt');
        foreach ($loginData as $line) {
                list($username, $password) = explode(',',$line);
        }

        $credentials    =       "user = $username password=$password";
        $conn = pg_connect( " $host $port $dbname $credentials" )
           or die ("Could not connect to server\n");
	session_start();
	$userId = ( isset ( $_SESSION['userId'] ) && trim ( $_SESSION['userId'] ) != 'NA' )? trim ( $_SESSION['userId'] ) : 'NA' ;
$myfilter = $_GET['filter'] ;
if ( $myfilter == "All" ) {
	$query = "select * from moviedeatils";
}else {
        $query = "select * from moviedeatils where genre='$myfilter'";
}

$result = pg_query($query);
echo "
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
 #myInput {
  background-image: url('searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
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
  background-color: #f1f1f1;
}

.myspanstyle:hover {
	color:blue;
}

</style>
<script type=\"text/javascript\">
                function changeDivContent(filtervar) {
                         window.location.assign(\"fetchmoviedetails.php?filter=\" + filtervar);
                }
		function alertFun() {
			alert('Please login to watch movie');
		}
        </script>

</head>
<body >
	<div class=\"container\">
	<div class=\"row\">
	<div class=\"col-lg-1\"></div>
	<div class=\"col-lg-10\">
	<input type=\"text\" id=\"myInput\" onkeyup=\"myFunction()\" placeholder=\"Search for names..\" title=\"Type in a name\"><br>
         <table id=\"myTable\" class=\"table table-hover\" style=\"border:1px solid;\"><tr style=\"background-color: #f1f1f1;\"><th>Name</th>
	<th>
	<div class=\"dropdown\">
		Genre<button class=\"btn dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-filter\"></span>
  		</button>
		  <ul class=\"dropdown-menu\">
			<li><a href=\"#\" onclick=\"changeDivContent('Drama')\">Drama</a></li>
			<li><a href=\"#\" onclick=\"changeDivContent('Mystery')\">Mystery</a></li>
			<li><a href=\"#\" onclick=\"changeDivContent('Action')\">Action</a></li>
			<li><a href=\"#\" onclick=\"changeDivContent('All')\">All</a></li>
		  </ul>
		</div>
	</th>

<th>Language</th><th>Actor</th><th>Actress</th></tr>";
if($result)
{
	while ($row = pg_fetch_row($result)) {
		if  ( $userId != "NA" && $userId != NULL )  {
			echo "<tr><td><a href=\"watchmovie.php?movieId=$row[0]\" target=\"_self\"><span class=\"glyphicon glyphicon-play-circle\"></span>&nbsp;&nbsp;$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
		}
		else {
			echo "<tr><td class=\"myspanstyle\" onclick=\"alertFun()\"><span class=\"glyphicon glyphicon-play-circle\" ></span>&nbsp;&nbsp;$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>";
		}
	}
}
echo "</table>
</div>
<div class=\"col-lg-1\"></div>
</div></div>
<script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById(\"myInput\");
  filter = input.value.toUpperCase();
  table = document.getElementById(\"myTable\");
  tr = table.getElementsByTagName(\"tr\");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName(\"td\")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = \"\";
      } else {
        tr[i].style.display = \"none\";
      }
    }
  }
}
</script>

</body>
</html>";
pg_close($conn);
?>
