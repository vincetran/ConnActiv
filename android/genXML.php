<?php 
	include("../views/functions/config.php");

	mysql_connect("connactiv.db", "connactiv_site", "connactiv123") or die(mysql_error()); 	
	mysql_select_db("connactiv") or die(mysql_error());

	//connactions
	$myfile = "connactionDb.xml";
	$table = "connactions";
	
	$xml .= "<".$table.">\n";

	//Gets the proper unique networks for the user
	//$id_query = "select unique_network_id from user_networks where user_id = ".$_POST['userId'];
	$id_query = "select unique_network_id from user_networks where user_id = 2";
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
