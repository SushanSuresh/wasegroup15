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
		echo "<script type=\"text/javascript\">
                        alert('Server Busy,  Please tryagian later');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
        }
	$query = "select * from userdetails where LOWER(email)=LOWER('$email') OR phonenumber='$pnumber'";
	$result = pg_query($query);
	if($result){
		$rowcount = pg_num_rows($result);
		if ($rowcount > 0 ) {
			echo "<script type=\"text/javascript\">
                        alert('Email id/Phone number exist in our record, Please try with different email id/phone number');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
		}
		else {
			
			if ( $email == NULL || $email == "" || $upassword == NULL || $upassword == "" || $uname == NULL || $uname == "" ) {
				echo "<script type=\"text/javascript\">
                        alert('Sign up failed, Please tryagian later. If it is recurring issue please contact administrator');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
			}
			else {
				$query = "insert into userdetails values('$uname','$upassword','$email','$pnumber')";
				$result = pg_query($query);
			        if($result){
					echo "<script type=\"text/javascript\">
                        alert('Signup Successfull, Please Login now...!');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
				}	
			        else{
					 echo "<script type=\"text/javascript\">
                        alert('Sign up failed, Please tryagian later. If it is recurring issue please contact administrator');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
				}
			}
		}
	}
	else{
		 echo "<script type=\"text/javascript\">
                        alert('Sign up failed, Please tryagian later. If it is recurring issue please contact administrator');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>";
        }
	pg_close($conn);
?>
