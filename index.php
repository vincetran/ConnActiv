<?php 

 // Connects to your Database 

 mysql_connect("localhost", "xgamings_connact", "connactive123") or die(mysql_error()); 

 mysql_select_db("xgamings_connactiv") or die(mysql_error()); 


 //Checks if there is a login cookie

 if(isset($_COOKIE['ID_my_site']))


 //if there is, it logs you in and directes you to the members page

 { 
 	$username = $_COOKIE['ID_my_site']; 

 	$pass = $_COOKIE['Key_my_site'];

 	 	$check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());

 	while($info = mysql_fetch_array( $check )) 	

 		{

 		if ($pass != $info['password']) 

 			{

 			 			}

 		else

 			{

 			header("Location: members.php");



 			}

 		}

 }


 //if the login form is submitted 

 if (isset($_POST['submit'])) { // if form has been submitted



 // makes sure they filled it in

 	if(!$_POST['username'] | !$_POST['pass']) {

 		die('You did not fill in a required field.');

 	}

 	// checks it against the database



 	if (!get_magic_quotes_gpc()) {

 		$_POST['email'] = addslashes($_POST['email']);

 	}

 	$check = mysql_query("SELECT * FROM users WHERE username = '".$_POST['username']."'")or die(mysql_error());



 //Gives error if user dosen't exist

 $check2 = mysql_num_rows($check);

 if ($check2 == 0) {

 		die('That user does not exist in our database. <a href=registration.php>Click Here to Register</a>');

 				}

 while($info = mysql_fetch_array( $check )) 	

 {

 $_POST['pass'] = stripslashes($_POST['pass']);

 	$info['password'] = stripslashes($info['password']);

 	$_POST['pass'] = md5($_POST['pass']);



 //gives error if the password is wrong

 	if ($_POST['pass'] != $info['password']) {

 		die('Incorrect password, please try again.');

 	}
else 

 { 

 
 // if login is ok then we add a cookie 

 	 $_POST['username'] = stripslashes($_POST['username']); 

 	 $hour = time() + 3600; 

 setcookie(ID_my_site, $_POST['username'], $hour); 

 setcookie(Key_my_site, $_POST['pass'], $hour);	 

 

 //then redirect them to the members area 

 header("Location: members.php"); 

 } 

 } 

 } 

 else 

{	 

 

 // if they are not logged in 

 ?> 


<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>ConnActiv - The place to be actively connected.</title>
    <link rel="stylesheet" type="text/css" href="ConnActiv.css" title="style" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
        <script type="text/javascript" src="jq/jquery.watermark.js"></script> 
        <script type="text/javascript">/*<![CDATA[*/// 
            $(function () {
		        $("#username").watermark("Enter your username");
		        $("#password").watermark("Enter your password");
	        });

        // ]]&gt;/*]]>*/</script> 

</head>
<body style="background-color:white;">
    <div style="width:1024px; margin:auto;">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
        <table style="width:1024px;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="height:70px;background-color:white">
                    <img src="images/TestLogo.png" alt="TestLogo!"/>
                </td>
                <td>
                    <p>Username:</p>
                </td>
                <td>
                    <input id="username"  type="text" name="username" maxlength="40"/>
                </td>
                <td>
                    <p>Password:</p>
                </td>
                <td>
                    <input id="password" type="password" name="pass" maxlength="50"/>
                </td>
                <td>
                    <input type="submit" name="submit" value="Login"/>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;height:600px;" colspan="6">
                    <img src="images/underConstruction.png" alt="Come back soon!"/>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;border-left:1px solid #116811;border-right:1px solid #116811;" colspan="6">
                   <p> | ©2011 | Dave | Kim | Ray | Rob | Vince |</p>
                </td>
            </tr>
        </table>
        </form> 
        <center><p><a href="login.php">Log in</a> | <a href="registration.php">Sign up </a></p></center>
    </div>
</body>
</html>
 <?php 

 } 

 

 ?> 