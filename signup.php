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
	$query = "select * from userdetails where LOWER(email)=LOWER('$email') OR phonenumber='$pnumber'";
	$result = pg_query($query);
	if($result){
		$rowcount = pg_num_rows($result);
		if ($rowcount > 0 ) {
			echo "Email id/Phone number exist in our record, Please try with different email id/phone number";
		}
		else {
			
			if ( $email == NULL || $email == "" || $upassword == NULL || $upassword == "" || $uname == NULL || $uname == "" ) {
				echo "Sign up failed, Please tryagian later. If it is recurring issue please contact administrator";
			}
			else {
				$query = "insert into userdetails values('$uname','$upassword','$email','$pnumber')";
				$result = pg_query($query);
			        if($result){
					echo "Signup Successfull, Please Login now...!";	
				}	
			        else{
					echo "Sign up failed, Please tryagian later. If it is recurring issue please contact administrator";
				}
			}
		}
	}
	else{
                                echo "Sign up failed, Please tryagian later. If it is recurring issue please contact administrator";
        }
	pg_close($conn);
?>
