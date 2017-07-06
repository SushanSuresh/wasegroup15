<?php
        $host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
        $pid		=       $_POST['pid'];
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
	$myranpassword = "reset-" . $pid;
	$query = "select * from userdetails where password='$myranpassword'";
	$result = pg_query($query);
	if($result){
		$rowcount = pg_num_rows($result);
		if ($rowcount > 0 ) {
			$query = "update userdetails set password = '$upassword' where password='$myranpassword'";				
			$result = pg_query($query);
                         if($result){
				echo "<script type=\"text/javascript\">
        	                alert('Updated the password, Please try login in');
                	        setTimeout(\"location.href = 'index.html'\",0);
                        	</script>";
			}
			else {
				echo "<script type=\"text/javascript\">
                                alert('Failed to update password, Please try again1');
                                setTimeout(\"location.href = 'index.html'\",0);
                                </script>";

			}
		}
		else {
		 echo "<script type=\"text/javascript\">
                                alert('Failed to update password/Link you are trying is wrong, Please try again2');
                                setTimeout(\"location.href = 'index.html'\",0);
                                </script>";
	
		}

	}
	else{
			 echo "<script type=\"text/javascript\">
                                alert('Failed to update password, Please try again3');
                                setTimeout(\"location.href = 'index.html'\",0);
                                </script>";

        }
	pg_close($conn);
?>
