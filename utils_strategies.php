<?php

//require('properties.php');
require('kafka_messages.php'); 
//require('example_risk.php');

//get the $RATING_risk_profile from RATING calling getProfile
//$profile = json_decode($example);
//$likelihood = $profile->overallLikelihood;
date_default_timezone_set("Europe/Rome");
$curr_timestamp = date('Y-m-d H:i:s.z');



function getNamesVulnerabilities($element)
{
	$result=array();
	array_push($result,$element->name);
	$texts = $GLOBALS['vuln_texts'];
	$index= intval(($element->risk)*5);
	if ($index!=0)
		array_push($result,$texts[$index-1]);
	else{
		array_push($result,$texts[0]);
	}	
	return $result;
}
function getBackground($element)
{
	//include('adapter_config.php'); //path to the config.php
	$col = $GLOBALS['colors'];
	$index= intval(($element->risk)*5);
	if ($index!=0)
		return $col[$index - 1];
	else{
		return $col[$index];
	}
}




//create table graph for Attack strategies
function createASTable($profile){
	$new_table = $GLOBALS['db_attacks_table_graph'];
	$d_table_AS = json_decode($new_table);
	$d_table_AS->location=1;
	//get the strategies from the $RATING_risk_profile
	$strategies = $profile->attackStrategyRisks;
	//	var_dump($strategies);
	//order the strategies over vulnerability
	usort($strategies, function ($item1, $item2) {
	    
	    if ($item1->risk == $item2->risk) return 0;
	    return $item1->risk > $item2->risk ? -1 : 1;
	});
	//get name and vulnerability and colorfor each attack strategy
	$ordered_strategies = array_map("getNamesVulnerabilities",$strategies);
	$background_colors = array_map("getBackground", $strategies);

	//add them into $d_table_AS->content->data->datasets and $d_table_AS->content->data->backgroundColor
	$d_table_AS->content->data->datasets=$ordered_strategies;
	$d_table_AS->content->data->backgroundColor = $background_colors;
	return $d_table_AS;
}
//$new_table_AS = createASTable($profile);
//print(json_encode($new_table_AS));

?>
