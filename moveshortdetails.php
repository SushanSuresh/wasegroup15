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
?>
