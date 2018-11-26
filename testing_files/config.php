<?php

//CONFIGURATION parameters of RAAdapter in COMPACT
$config = array(
// Configuration of the COMACT Communication bus during trials
    "commbus" => array(
	"cons" => array(
		"0" => array(
		    "paname" => "CDA",
		    "port" => "9092",
		    "topicname" => "soc",
		    "component" => "soc",
		    "host" => "192.168.100.24"
		),
		"1" => array(
		    "paname" => "BOL",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "192.168.100.24"
		),
		"2" => array(
		    "paname" => "CDA",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "192.168.100.24"
		),
		"3" => array(
		    "paname" => "BIT",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "192.168.100.24"
		),
		"4" => array(
		    "paname" => "CMA",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "192.168.100.24"
		),
		"5" => array(
		    "paname" => "DSS",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "192.168.100.24"
		)
	),
	"prod" => array(
		"0" => array(
		    "paname" => "CDA",
		    "port" => "9092",
		    "topicname" => "rating",
		    "component" => "rating",
		    "host" => "192.168.100.24"
		),
		"1" => array(
		    "paname" => "BIT",
		    "port" => "9092",
		    "topicname" => "rating",
		    "component" => "rating",
		    "host" => "192.168.100.24"
		),
		"2" => array(
		    "paname" => "CMA",
		    "port" => "9092",
		    "topicname" => "rating",
		    "component" => "rating",
		    "host" => "192.168.100.24"
		),
		"3" => array(
		    "paname" => "BOL",
		    "port" => "9092",
		    "topicname" => "rating",
		    "component" => "rating",
		    "host" => "192.168.100.24"
		),
		"4" => array(
		    "paname" => "DSS",
		    "port" => "9092",
		    "topicname" => "rating",
		    "component" => "rating",
		    "host" => "192.168.100.24"
		),
		"5" => array(
		    "paname" => "CDA",
		    "port" => "9092",
		    "topicname" => "dashboard",
		    "component" => "dashboard",
		    "host" => "192.168.100.24"
		),
		"6" => array(
		    "paname" => "BIT",
		    "port" => "9092",
		    "topicname" => "dashboard",
		    "component" => "dashboard",
		    "host" => "192.168.100.24"
		),
		"7" => array(
		    "paname" => "CMA",
		    "port" => "9092",
		    "topicname" => "dashboard",
		    "component" => "dashboard",
		    "host" => "192.168.100.24"
		),
		"8" => array(
		    "paname" => "BOL",
		    "port" => "9092",
		    "topicname" => "dashboard",
		    "component" => "dashboard",
		    "host" => "192.168.100.24"
		),
		"9" => array(
		    "paname" => "DSS",
		    "port" => "9092",
		    "topicname" => "dashboard",
		    "component" => "dashboard",
		    "host" => "192.168.100.24"
		)
	)
    )
);

?>
