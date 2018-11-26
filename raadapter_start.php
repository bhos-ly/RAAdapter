<?php

 
// $argv[1] : configuration file
// $argv[2] : 

//check params
if ($argc < 2 )
{
    	//echo "Missing configuration file: call raadapter_start.php with config file name as parameter.\ni.e. php raadapter_start.php path_to_config_file/config.php\n" ;

	echo "Are you sure you want to start RAAdapter with the default configuration?\nType 'yes' to continue, or 'no' to abort and call 'php raadapter_start.php path_to_config_file/config.php':   ";
	$handle = fopen ("php://stdin","r");
	$line = fgets($handle);
	if(trim($line) != 'yes'){
	    echo "ABORTING!\n";
	    exit;
	}
	fclose($handle);
	echo "\n"; 
	echo "DEFAULT CONFIGURATION:\nIP=localhost\n\n";
	include 'config.php';
	//echo $K_rating_url;

}else {
	include $argv[1];
	echo "CONFIGURATION FILE: $argv[1]\n\n";
	
}
require 'properties.php';
require 'raadapter_outgoing.php';

?>
