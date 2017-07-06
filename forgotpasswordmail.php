<?php
        $host           =       "host = 127.0.0.1";
        $port           =       "port = 5432";
        $dbname         =       "dbname = testdb";
	$loginData = file('../.credentials.txt');
	$emailId = $_POST['emailId'];
        foreach ($loginData as $line) {
                list($username, $password) = explode(',',$line);
        }

        $credentials    =       "user = $username password=$password";
        $conn = pg_connect( " $host $port $dbname $credentials" )
           or die ("Could not connect to server\n");

	$query = "select * from userdetails where LOWER(email)=LOWER('$emailId')";
	$result = pg_query($query);
        if($result){
		 $rowcount = pg_num_rows($result);
		 if ( $rowcount > 0 ){
			$randomNumber = "";
			function generateRandomnumber() {
				$randomNumber = rand(1000000000,10000000000);
				$myranpassword = "reset-" . $randomNumber;
				$squery = "select * from userdetails where password='$myranpassword'";
				$result = pg_query($squery);
				if($result){					
					$rowcount = pg_num_rows($result);
					if ( $rowcount > 0 || $randomNumber == NULL || $randomNumber == "" ){
						generateRandomnumber();
					}
					else {
						return $randomNumber;
					}
				}
			}
			$randomNumber = generateRandomnumber();
			$myranpassword = "reset-" . $randomNumber;
			$query = "update userdetails set password='$myranpassword' where LOWER(email)=LOWER('$emailId')";
			$result = pg_query($query);
			 if($result){
				$to = $emailId;
				$subject = "Password Reset";
				$message = "Click on the below link to reset it.\nhttp://35.154.84.222:80/wasegroup15/resetMyPassword.php?resetId=$randomNumber \n Thank you";
				$message = wordwrap($message,70);
				$headers = "From : Entertainment.in";
				mail($to,$subject,$message,$headers);
				 echo "
                <html><body>
<script type=\"text/javascript\">
                        alert(\"Password reset link has been sent to mail $emailId \");
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>
                </body></html
";

			}
			else {
				 echo "
                <html><body>
<script type=\"text/javascript\">
                        alert('Failed to reset your password, Please try again...!');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>
                </body></html
";

			}
		}
		else {
			 		echo "
		<html><body>
<script type=\"text/javascript\">
                        alert('Email Id provided below is not registered with us');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>
		</body></html
";
			
		}
	}
	else {
		 		echo "
		<html><body>
<script type=\"text/javascript\">
                        alert('Email Id provided below is not registered with us');
                        setTimeout(\"location.href = 'index.html'\",0);
                        </script>
		</body></html
";
	}
pg_close($conn);
?>
