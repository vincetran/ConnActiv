<?php 
	$myfile = "database.xml";
	
	mysql_connect("localhost", "root", "") or die(mysql_error()); 	//This is wamp database credentials
	mysql_select_db("xgamings_connactiv") or die(mysql_error());
//users	
	$table = "users";
	

	$query = mysql_query("select * from ".$table) or die(mysql_error());

	$xml .= "<".$table.">\n";
	
	
	while($info = mysql_fetch_array($query)){
		$xml .= "<row>\n";
		$i = 0;
		$atts = mysql_query("describe ".$table) or die(mysql_error());
		while($info1 = mysql_fetch_array($atts)){
					
			$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
			$i++;		
		}
		$xml .= "</row>\n";		
	}
	$xml .= "</".$table.">\n";

//connactions
	$table = "connactions";
	

	$query = mysql_query("select * from ".$table) or die(mysql_error());

	$xml .= "<".$table.">\n";
	
	
	while($info = mysql_fetch_array($query)){
		$xml .= "<row>\n";
		$i = 0;
		$atts = mysql_query("describe ".$table) or die(mysql_error());
		while($info1 = mysql_fetch_array($atts)){
					
			$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
			$i++;		
		}
		$xml .= "</row>\n";		
	}
	$xml .= "</".$table.">\n";

//friends
	$table = "friends";
	

	$query = mysql_query("select * from ".$table) or die(mysql_error());

	$xml .= "<".$table.">\n";
	
	
	while($info = mysql_fetch_array($query)){
		$xml .= "<row>\n";
		$i = 0;
		$atts = mysql_query("describe ".$table) or die(mysql_error());
		while($info1 = mysql_fetch_array($atts)){
					
			$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
			$i++;		
		}
		$xml .= "</row>\n";		
	}
	$xml .= "</".$table.">\n";

//networks
$table = "networks";
	

	$query = mysql_query("select * from ".$table) or die(mysql_error());

	$xml .= "<".$table.">\n";
	
	
	while($info = mysql_fetch_array($query)){
		$xml .= "<row>\n";
		$i = 0;
		$atts = mysql_query("describe ".$table) or die(mysql_error());
		while($info1 = mysql_fetch_array($atts)){
					
			$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
			$i++;		
		}
		$xml .= "</row>\n";		
	}
	$xml .= "</".$table.">\n";

//unique_networks
$table = "unique_networks";
	

	$query = mysql_query("select * from ".$table) or die(mysql_error());

	$xml .= "<".$table.">\n";
	
	
	while($info = mysql_fetch_array($query)){
		$xml .= "<row>\n";
		$i = 0;
		$atts = mysql_query("describe ".$table) or die(mysql_error());
		while($info1 = mysql_fetch_array($atts)){
					
			$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
			$i++;		
		}
		$xml .= "</row>\n";		
	}
	$xml .= "</".$table.">\n";

//user_activities
$table = "user_activities";
	

	$query = mysql_query("select * from ".$table) or die(mysql_error());

	$xml .= "<".$table.">\n";
	
	
	while($info = mysql_fetch_array($query)){
		$xml .= "<row>\n";
		$i = 0;
		$atts = mysql_query("describe ".$table) or die(mysql_error());
		while($info1 = mysql_fetch_array($atts)){
					
			$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
			$i++;		
		}
		$xml .= "</row>\n";		
	}
	$xml .= "</".$table.">\n";

//messages
$table = "messages";
	

	$query = mysql_query("select * from ".$table) or die(mysql_error());

	$xml .= "<".$table.">\n";
	
	
	while($info = mysql_fetch_array($query)){
		$xml .= "<row>\n";
		$i = 0;
		$atts = mysql_query("describe ".$table) or die(mysql_error());
		while($info1 = mysql_fetch_array($atts)){
					
			$xml .= "<".$info1[0].">".$info[$i]."</".$info1[0].">\n";
			$i++;		
		}
		$xml .= "</row>\n";		
	}
	$xml .= "</".$table.">\n";



	
	$fh = fopen($myfile, "w");
	$error = fwrite($fh, $xml);
	echo $error;
	fclose($fh);
?>
