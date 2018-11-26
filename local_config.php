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
		    "host" => "localhost"
		),
		"1" => array(
		    "paname" => "BOL",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "localhost"
		),
		"2" => array(
		    "paname" => "CDA",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "localhost"
		),
		"3" => array(
		    "paname" => "BIT",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "localhost"
		),
		"4" => array(
		    "paname" => "CMA",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "localhost"
		),
		"5" => array(
		    "paname" => "DSS",
		    "port" => "9092",
		    "topicname" => "openedu",
		    "component" => "openedu",
		    "host" => "localhost"
		)
	),
	"prod" => array(
		"0" => array(
		    "paname" => "CDA",
		    "port" => "9092",
		    "topicname" => "rating_CDA",
		    "component" => "rating",
		    "host" => "localhost"
		),
		"1" => array(
		    "paname" => "BIT",
		    "port" => "9092",
		    "topicname" => "rating_BIT",
		    "component" => "rating",
		    "host" => "localhost"
		),
		"2" => array(
		    "paname" => "CMA",
		    "port" => "9092",
		    "topicname" => "rating_CMA",
		    "component" => "rating",
		    "host" => "localhost"
		),
		"3" => array(
		    "paname" => "BOL",
		    "port" => "9092",
		    "topicname" => "rating_BOL",
		    "component" => "rating",
		    "host" => "localhost"
		),
		"4" => array(
		    "paname" => "DSS",
		    "port" => "9092",
		    "topicname" => "rating_DSS",
		    "component" => "rating",
		    "host" => "localhost"
		),
		"5" => array(
		    "paname" => "CDA",
		    "port" => "9092",
		    "topicname" => "dashboard_CDA",
		    "component" => "dashboard",
		    "host" => "localhost"
		),
		"6" => array(
		    "paname" => "BIT",
		    "port" => "9092",
		    "topicname" => "dashboard_BIT",
		    "component" => "dashboard",
		    "host" => "localhost"
		),
		"7" => array(
		    "paname" => "CMA",
		    "port" => "9092",
		    "topicname" => "dashboard_CMA",
		    "component" => "dashboard",
		    "host" => "localhost"
		),
		"8" => array(
		    "paname" => "BOL",
		    "port" => "9092",
		    "topicname" => "dashboard_BOL",
		    "component" => "dashboard",
		    "host" => "localhost"
		),
		"9" => array(
		    "paname" => "DSS",
		    "port" => "9092",
		    "topicname" => "dashboard_DSS",
		    "component" => "dashboard",
		    "host" => "localhost"
		)
	)
    )
);

?>
