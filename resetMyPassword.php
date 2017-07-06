<?php
	$pId = $_GET['resetId'];
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
        <script type=\"text/javascript\">
		 function clearconfirm() {
                                document.getElementById(\"cnewpassword\").value = \"\";
                                document.getElementById('pass').style.visibility = 'hidden';
                        }

                function validatepass() {
                                var nPass = document.getElementById(\"newpassword\").value;
                                var cPass = document.getElementById(\"cnewpassword\").value;

                                        if ( nPass != cPass || nPass == \"\" ) {
                                                        document.getElementById('pass').style.visibility = 'visible';
                                                        event.preventDefault();
                                                        return false;
                                        }
                                        else {

                                                return true;
                                        }

                        }

        </script>

</head>
<body style=\"padding-top: 70px;background-image:url('film.jpg');background-repeat:no-repeat;background--position:center;background-size:cover;\" >
<nav class=\"navbar navbar-inverse navbar-fixed-top\">
  <div class=\"container-fluid\">
        <ul class=\"nav navbar-nav\">
                <li class=\"active\"><a href=\"index.html\">Home</a></li>
        </ul>
  </div>
</nav>
<br><br>
         <form id=\"myForm\" method=\"post\" action=\"reset.php\" target=\"_parent\">
						<input type=\"hidden\" name=\"pid\" value=\"$pId\"/>
                                                <div class=\"container\" style=\"background-color: #f1f1f1;padding:25px; width:500px\">
                                                       <div class=\"row\">
                                                                <div class=\"col-sm-5\">New Password :</div>
                                                                <div class=\"col-sm-7\"><input type=\"password\" id=\"newpassword\" name=\"newpassword\" pattern=\"(?=.[A-Za-z])(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}\" title=\"8 are more characters starts with alpha charecter includes One caps,small and number \" style=\"width:90%\" onchange=\"clearconfirm()\" required/></div>
                                                        </div>
                                                        <br><div class=\"row\">
                                                                <div class=\"col-sm-5\">Confirm New Password :</div>
                                                                <div class=\"col-sm-7\"><input type=\"password\" id= \"cnewpassword\" name=\"cnewpassword\" style=\"width:90%\" onchange=\"validatepass()\" required/>&nbsp&nbsp<lable id=\"pass\"><span style=\"color:red\">pasword not matching/empty</span></lable></div>
                                                        </div>
                                                        <br>
                                                        <div class=\"row\">
                                                                <div class=\"col-lg-7\"></div>
                                                                <div class=\"col-sm-5\"><button type=\"submit\" id=\"mysubmit\" class=\"btn btn-success mybtn\" onclick=\"validatepass()\" >Update Password</button></div>
                                                        </div>
                                                </div>
                                </form>

<script type=\"text/javascript\">
        document.getElementById(\"pass\").style.visibility = \"hidden\";
</script>
</body>
</html>

	";
?>
