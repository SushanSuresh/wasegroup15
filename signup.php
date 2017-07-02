<?php
        $host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
        $uname		=       $_POST['username'];
        $email		=       $_POST['Email'];
	$pnumber	=	$_POST['pnumber'];
	$upassword	=	$_POST['newpassword'];
	$loginData = file('../.credentials.txt');
        foreach ($loginData as $line) {
                list($username, $password) = explode(',',$line);
        }
        $credentials    =       "user = $username password=$password";
	
        $conn = pg_connect( " $host $port $dbname $credentials" );
        if (!$conn) {
                echo "Server Busy,  Please tryagian later";
        }
	$query = "insert into userdetails values('$uname','$upassword','$email','$pnumber')";
	$result = pg_query($query);
        if($result){
		echo "Signup Successfull, Please Login now...!";	
	}	
        else{
		echo "Sign up failed, Please tryagian later";
	}
	pg_close($conn);
?>
