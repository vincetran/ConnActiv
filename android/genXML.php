<?php 
	include("../views/functions/config.php");

	//connactions
	$myfile = $_POST['userId']."connactionDb.xml";
	$table = "connactions";
	
	$xml .= "<".$table.">\n";

	//Gets the proper unique networks for the user
	$id_query = "select unique_network_id from user_networks where user_id = ".$_POST['userId'];
	$result = mysql_query($id_query);

	while($info = mysql_fetch_array($result)){
		$unique_network_id = $info[0];
		$result1 = mysql_query("select * from connactions where unique_network_id = ".$unique_network_id);

		while($info = mysql_fetch_array($result1))
		{
			$xml .= "<row>\n";
			$i = 0;
			$atts = mysql_query("describe ".$table) or die(mysql_error());
			while($info1 = mysql_fetch_array($atts)){
				
				if(strcmp ($info1[0],"USER_ID")==0)
				{
					$xml .= "<".$info1[0].">".getUserName($info[$i])."</".$info1[0].">\n";
				}
				else if(strcmp ($info1[0],"UNIQUE_NETWORK_ID")==0)
				{
					$xml .= "<".$info1[0].">".prettifyName($info[$i])."</".$info1[0].">\n";
					//Gets an array of the activities from UNID
					$act = mysql_query("select activity_id from unique_networks where unique_network_id = ".$info[$i]);
					$act1 = mysql_fetch_array($act);
					$activityID = $act1[0];
					$self = getActivityLevel($_POST['userId'],$activityID, 3);
					$prefer = getActivityLevel($_POST['userId'],$activityID, 2);
					$accept_low = getActivityLevel($_POST['userId'],$activityID, 0);
					$accept_high = getActivityLevel($_POST['userId'],$activityID, 1);
					$xml .= "<LEVELS>".$accept_low."|".$accept_high."|".$prefer."|".$self."</LEVELS>\n";
				}
				else
				{
					$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
				}
				$i++;			
			}
			
			$xml .= "</row>\n";		
		}

	}
	
	$xml .= "</".$table.">\n";

	$fh = fopen($myfile, "w");
	$error = fwrite($fh, $xml);
	//echo $error;
	fclose($fh);

?>
