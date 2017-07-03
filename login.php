<?php
        $host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
	session_start();	
	$uEmail		=       $_POST['emailId'];
	$upassword	=	$_POST['password'];
	$loginData = file('../.credentials.txt');
        foreach ($loginData as $line) {
                list($username, $password) = explode(',',$line);
        }
        $credentials    =       "user = $username password=$password";
	$eflag = "0";
	$query = "";
	
	echo "<html>
<head>
<title>Entertainment.in</title>
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <link rel=\"stylesheet\" href=\"bootstrap/css/bootstrap.min.css\">

        <link rel=\"stylesheet\" href=\"font-awesome/css/font-awesome.min.css\">
        <script src=\"bootstrap/jquery.min.js\"></script>
        <script src=\"bootstrap/js/bootstrap.min.js\"></script>
        <style type=\"text/css\">
        @media (min-width: 768px) {
                .navbar-header.navbar-center {
                        position: absolute;
                        left: 50%;
                        transform: translatex(-50%);
                }
        }
        div.menuspan {
                width: 25px;
                height: 2px;
                background-color: white;
                margin: 3px 0;
        }

        </style>

</head>
<body style=\"padding-top: 70px;\">
<nav class=\"navbar navbar-inverse navbar-fixed-top\">
  <div class=\"container-fluid\">
        <ul class=\"nav navbar-nav\">
                <li class=\"active\"><a href=\"#\" onclick=\"reloadframe()\">Home</a></li>
        </ul>
   <button  class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#navHeaderCollapse\">
                        <div class=\"menuspan\"></div>
                        <div class=\"menuspan\"></div>
                        <div class=\"menuspan\"></div>
   </button>
    <div class=\"collapse navbar-collapse\" id=\"navHeaderCollapse\" >
        <div class=\"navbar-header navbar-center\" >
                <a class=\"navbar-brand\" href=\"#\"><font color=\"white\"><b>Entertainment.in</b></font></a>
        </div>
        <ul class=\"nav navbar-nav navbar-right\">";	

        $conn = pg_connect( " $host $port $dbname $credentials" );
        if (!$conn) {
		echo "<li><a href=\"#\" onclick=\"loginFun()\" ><span class=\"glyphicon glyphicon-log-in\"></span> Login</a></li>";
		$eflag = "2";
		$uname = "NA";
        }
	 if ( $_SESSION[userId] == NULL || $_SESSION[userId] == "NA" ) {
		$query = "select name from userdetails where password='$upassword' AND LOWER(email)=LOWER('$uEmail')";
		$query2 = $query;
		$result2 = pg_query($query2);
		if($result2) {
			while ($row = pg_fetch_row($result2)) {
				$uname = $row[0];
			}
		}
		else {
			$eflag = "1" ;
			$uname = "NA";
			$query = "select name from userdetails where noneixt='nonexit'";
		}
	 }
	 else {
		$query = "select name from userdetails where name='$_SESSION[userId]'";	
	}
	$result = pg_query($query);
        if($result){		
		 $rowcount = pg_num_rows($result);
				if ( $_SESSION[userId] == NULL || $_SESSION[userId] == "NA" ) {
					$_SESSION["userId"] = "$uname";
					$_SESSION["uEmailId"] = "$uEmail";
				}
				else {
					$uname = $_SESSION["userId"];
				}
	                	if ($rowcount > 0 && $_SESSION[userId] != NULL && $uname != NULL  ) {
		                	echo "<li><a href=\"#\"><font color=\"white\"><b>$_SESSION[userId]</b></font></a></li><li><a href=\"logout.php\" onclick=\"destroysessio()\"><span class=\"glyphicon glyphicon-log-out\"></span> Logout</a></li>";
				}
				else {
					echo "<li ><a href=\"#\" onclick=\"loginFun()\" ><span class=\"glyphicon glyphicon-log-in\"></span> Login</a></li>";
					echo "<li ><a href=\"#\" onclick=\"signupFun()\"><span class=\"glyphicon glyphicon-user\"></span> Signup</a></li>";				
					$eflag = "1" ;
					$uname = "NA";
				}
	}	
        else{
		echo "<li ><a href=\"#\" onclick=\"loginFun()\" ><span class=\"glyphicon glyphicon-log-in\"></span> Login</a></li>";
		echo "<li ><a href=\"#\" onclick=\"signupFun()\"><span class=\"glyphicon glyphicon-user\"></span> Signup</a></li>";
		$eflag = "1";
		$uname = "NA";
	}
	echo "
	        </ul>
   </div>
  </div>
</nav>";
	if ( $eflag == "1" ) {
		
			session_unset();
			session_destroy();
		echo "<script type=\"text/javascript\">
			alert('Login Failed, Please check you credentials');
			setTimeout(\"location.href = 'index.html'\",0);
			</script>";
        }
        else if ( $eflag == "2" ) {
		
                        session_unset();
                        session_destroy();
                     echo "<script type=\"text/javascript\">
                        alert('Server Busy,  Please tryagian later');
			setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
        }
	echo "<br><br>
        <div class=\"container\">
        <div class=\"row\">
        <div class=\"col-lg-12\">
                <iframe id=\"myframe\" src=\"fetchmoviedetails.php?filter=All\" allowfullscreen=\"true\" webkitallowfullscreen=\"true\" mozallowfullscreen=\"true\" width=\"100%\" height=\"100%\" frameBorder=\"0\"></iframe>
        </div>
        </div>
        </div>
<script type=\"text/javascript\">
                function loginFun() {
                        document.getElementById('myframe').src = 'login.html'
                }
                function signupFun() {
                        document.getElementById('myframe').src = 'signup.html'
                }
                function reloadframe() {
                        document.getElementById('myframe').src = 'fetchmoviedetails.php?filter=All';
                }
        </script>
</body>
</html>
	";
	pg_close($conn);
?>
